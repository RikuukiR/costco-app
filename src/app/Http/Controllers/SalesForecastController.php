<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Sale;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class SalesForecastController extends Controller
{
    public function index(Request $request)
    {
        $mode = $request->get('mode', 'day');

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
                $sales = Sale::where('sales_date', '>=', now()->subDays(30))
                    ->orderBy('sales_date', 'asc')->get();
                break;
        }

        // 配列形式でデータをJSに渡すために整形// 例：Controller（DAY/WEEK/YEAR でまとめ方を変える）
        $salesLabels = $sales->map(function ($sale) use ($mode) {
            if ($mode === 'day') return \Carbon\Carbon::parse($sale->sales_date)->format('n/j');
            if ($mode === 'week') return \Carbon\Carbon::parse($sale->sales_date)->format('W週');
            if ($mode === 'year') return \Carbon\Carbon::parse($sale->sales_date)->format('Y年');
        });
        $salesValues = $sales->pluck('sales_amount')->toArray();

        // モードごと + 日付ごとでキャッシュキーを生成
        $cacheKey = 'forecast_' . $mode . '_' . now()->toDateString();

        // 
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
        return view('sales_forecasts.index', compact('sales', 'comment', 'mode', 'salesLabels', 'salesValues'));
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
