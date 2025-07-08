<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Sale;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class SalesForecastController extends Controller
{
    public function index(Request $request)
    {
        Log::info('SalesForecastController@index に入りました');
        $mode = $request->get('mode', 'day');
        $targetValues = [];     // 初期化

        // モードに応じた期間の売上データ取得
        switch ($mode) {
            case 'week':
                $sales = Sale::where('sales_date', '>=', now()->subWeeks(12))
                    ->orderBy('sales_date', 'asc')->get();
                break;

            case 'year':
                $sales = Sale::where('sales_date', '>=', now()->subYears(2))
                    ->orderBy('sales_date', 'asc')->get();
                break;

            case 'day':
            default:
                $sales = Sale::where('sales_date', '>=', now()->subDays(14))
                    ->orderBy('sales_date', 'asc')
                    ->get()
                    ->groupBy('sales_date')
                    ->map(function ($items, $date) {
                        return [
                            'sales_date' => $date,
                            'sales_amount' => $items->sum('sales_amount'),
                        ];
                    })->values(); // ← コレクションのキーをリセット
                break;
        }

        // デバッグ情報をログに出力
        Log::info('SalesForecast Debug', [
            'mode' => $mode,
            'sales_count' => $sales->count(),
            'sales_data' => $sales->toArray()
        ]);

        // 曜日別目標金額とグラフデータ生成
        $salesLabels = [];
        $salesValues = [];
        $targetValues = [];
        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
        $goals = [
            'Mon' => 1800000,
            'Tue' => 1800000,
            'Wed' => 2000000,
            'Thu' => 2500000,
            'Fri' => 2800000,
            'Sat' => 4800000,
            'Sun' => 4800000,
        ];

        $prevMonth = null;

        foreach ($sales as $sale) {
            $date = Carbon::parse($sale['sales_date']);
            $month = $date->format('n');
            $day = $date->format('j');
            $weekdayEng = $date->format('D');
            $weekdayJp = $weekdays[$date->dayOfWeek];

            if ($month !== $prevMonth) {
                $salesLabels[] = "{$month}/{$day}\n（{$weekdayJp}）";
                $prevMonth = $month;
            } else {
                $salesLabels[] = "{$day}\n（{$weekdayJp}）";
            }

            $salesValues[] = $sale['sales_amount'];
            $targetValues[] = $goals[$weekdayEng] ?? 0;
        }
        // モードごと + 日付ごとでキャッシュキーを生成
        $cacheKey = 'forecast_' . $mode . '_' . now()->toDateString();

        // .envから読み取り
        $useOpenAI = config('services.openai.enabled');

        // キャッシュの設定と停止するための分岐を追加
        // 再開するときは .env の USE_OPENAI=true に
        $comment = Cache::remember($cacheKey, now()->addDay(), function () use ($sales, $mode, $useOpenAI) {
            if (!$useOpenAI) {
                return '(※現在 ChatGPT は一時停止中です)';
            }

            // プロンプトの生成
            $prompt = "以下は「{$mode}」モードの売上データです。\n";
            $prompt .= "このデータをもとに売上傾向を予測し、下記のフォーマットで出力してください。\n\n";
            $prompt .= "【条件】\n- 出力は1段落、です・ます調で、150文字程度\n- 冒頭に「予測： 」と書く\n\n";
            $prompt .= "【売上データ】\n";

            // 売上データを文字列として整形
            foreach ($sales as $sale) {
                $prompt .= "{$sale->sales_date}: {$sale->sales_amount}円\n";
            }

            //APIの呼び出し
            $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
                'model' => env('OPENAI_MODEL'),
                // chatGPTの回答形式を指定
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.7,
            ]);

            // 生成されたテキストを取り出す処理（JSON→PHP）
            $content = $response->json()['choices'][0]['message']['content'] ?? null;

            // 形式チェック（三項演算子）
            return $content && str_starts_with($content, '予測：')
                ? $content
                : '予測コメントを取得できませんでした。';
        });

        // 3＋2の変数を渡しながら画面遷移
        return view('sales_forecasts.index', compact('sales', 'comment', 'mode', 'salesLabels', 'salesValues', 'targetValues'));
    }

    public function create()
    {
        return view('sales_forecasts.create');
    }

    public function store(Request $request)
    {
        // 実装予定
        return redirect()->route('sales_forecasts.index');
    }

    public function show($id)
    {
        return view('sales_forecasts.show');
    }

    public function edit($id)
    {
        return view('sales_forecasts.edit');
    }

    public function update(Request $request, $id)
    {
        // 実装予定
        return redirect()->route('sales_forecasts.index');
    }

    public function destroy($id)
    {
        // 実装予定
        return redirect()->route('sales_forecasts.index');
    }
}
