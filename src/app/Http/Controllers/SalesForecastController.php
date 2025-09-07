<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Sale;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class SalesForecastController extends Controller
{
    private function calculateMonthlyGoal(int $year, int $month, array $goals): int
    {
        $totalGoal = 0;
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $weekdayEng = $date->format('D');
            $totalGoal += $goals[$weekdayEng] ?? 0;
        }
        return $totalGoal;
    }

    private function calculateYearlyGoal(int $year, array $goals): int
    {
        $totalGoal = 0;
        for ($month = 1; $month <= 12; $month++) {
            $totalGoal += $this->calculateMonthlyGoal($year, $month, $goals);
        }
        return $totalGoal;  //年間目標金額を返す
    }

    public function index(Request $request)
    {
        // モードを取得、デフォルトはDAY
        $mode = $request->get('mode', 'day');

        $goals = [
            'Mon' => 1800000,
            'Tue' => 1800000,
            'Wed' => 2000000,
            'Thu' => 2500000,
            'Fri' => 2800000,
            'Sat' => 4800000,
            'Sun' => 4800000,
        ];

        // モードに応じた期間設定
        switch ($mode) {
            case 'week':
                // 直近8週間
                $startDate = now()->subWeeks(7)->startOfWeek();
                $endDate = now()->endOfWeek();
                break;
            case 'year':
                // 直近5年間
                $startDate = now()->subYears(4)->startOfYear();
                $endDate = now()->endOfMonth();
                break;
            case 'day':
            default:
                // 直近14日間
                $startDate = now()->subDays(13)->startOfDay();
                $endDate = now()->endOfDay();
                break;
        }

        // 期間内の売上データを取得
        $salesData = Sale::whereBetween('sales_date', [$startDate, $endDate])
            ->orderBy('sales_date', 'asc')
            ->get();

        // グラフデータとChatGPT用のデータを生成
        $salesLabels = [];
        $salesValues = [];
        $targetValues = [];
        $salesForGpt = [];
        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];

        if ($mode === 'day') {
            $period = CarbonPeriod::create($startDate, '1 day', $endDate);
            $prevMonth = null;
            // 日毎の売上データをあらかじめ集計
            $dailySalesData = $salesData->groupBy(function($sale) {
                return Carbon::parse($sale->sales_date)->toDateString();
            })->map(function($daySales) {
                return $daySales->sum('sales_amount');
            });

            foreach ($period as $date) {
                $month = $date->format('n');
                $day = $date->format('j');
                $weekdayJp = $weekdays[$date->dayOfWeek];
                if ($month !== $prevMonth) {
                    $salesLabels[] = "{$month}/{$day}\n（{$weekdayJp}）";
                    $prevMonth = $month;
                } else {
                    $salesLabels[] = "{$day}\n（{$weekdayJp}）";
                }
                $dateString = $date->toDateString();
                $dailySales = $dailySalesData[$dateString] ?? 0;
                $salesValues[] = $dailySales;
                $weekdayEng = $date->format('D');
                $targetValues[] = $goals[$weekdayEng] ?? 0;
                $salesForGpt[] = ['sales_date' => $dateString, 'sales_amount' => $dailySales];
            }
        } elseif ($mode === 'week') {
            // 週ごとの売上データをあらかじめ集計
            $weeklySalesData = $salesData->groupBy(function($sale) {
                return Carbon::parse($sale->sales_date)->startOfWeek()->toDateString();
            })->map(function($weekSales) {
                return $weekSales->sum('sales_amount');
            });

            $period = CarbonPeriod::create($startDate, '1 week', $endDate);
            foreach ($period as $date) {
                $salesLabels[] = $date->format('n/j（第W週）');
                $startOfWeek = $date->copy()->startOfWeek()->toDateString();
                $weeklySales = $weeklySalesData[$startOfWeek] ?? 0;
                $salesValues[] = $weeklySales;
                $targetValues[] = array_sum($goals);
                $salesForGpt[] = ['sales_date' => $startOfWeek, 'sales_amount' => $weeklySales];
            }
        } elseif ($mode === 'year') {
            // 年ごとの売上データをあらかじめ集計
            $yearlySalesData = $salesData->groupBy(function($sale) {
                return Carbon::parse($sale->sales_date)->year;
            })->map(function($yearSales) {
                return $yearSales->sum('sales_amount');
            });

            $period = CarbonPeriod::create($startDate, '1 year', $endDate);
            foreach ($period as $date) {
                $year = $date->year;
                $salesLabels[] = $year . '年';
                $yearlySales = $yearlySalesData[$year] ?? 0;
                $salesValues[] = $yearlySales;
                $targetValues[] = $this->calculateYearlyGoal($year, $goals);
                $salesForGpt[] = ['sales_date' => $date->startOfYear()->toDateString(), 'sales_amount' => $yearlySales];
            }
        }

        // モードごと + 日付ごとでキャッシュキーを生成
        $cacheKey = 'forecast_' . $mode . '_' . now()->toDateString();

        // .envから読み取り
        $useOpenAI = config('services.openai.enabled');

        // キャッシュの設定と停止するための分岐を追加
        // 再開するときは .env の USE_OPENAI=true に
        $comment = Cache::remember($cacheKey, now()->addDay(), function () use ($salesForGpt, $mode, $useOpenAI) {
            if (!$useOpenAI) {
                return '(※現在 ChatGPT は一時停止中です)';
            }

            // プロンプトの生成
            $prompt = "以下は「{$mode}」モードの売上データです。\n";
            $prompt .= "このデータをもとに売上傾向を予測し、下記のフォーマットで出力してください。\n\n";
            $prompt .= "【条件】\n- 出力は1段落、です・ます調で、150文字程度\n- 冒頭に「予測： 」と書く\n\n";
            $prompt .= "【売上データ】\n";

            // 売上データを文字列として整形
            foreach ($salesForGpt as $sale) {
                $prompt .= "{$sale['sales_date']}: {$sale['sales_amount']}円\n";
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
        return view('sales_forecasts.index', compact('comment', 'mode', 'salesLabels', 'salesValues', 'targetValues'));
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
