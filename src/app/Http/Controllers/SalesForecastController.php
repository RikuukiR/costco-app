<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Sale;

class SalesForecastController extends Controller
{
    public function index()
    {
        $sales = Sale::orderBy('sales_date', 'asc')->take(10)->get();
        $cacheKey = 'daily_forecast_' . now()->toDateString();

        $comment = Cache::remember($cacheKey, now()->addDay(), function () use ($sales) {
            $prompt = "以下は売上データです。\n";
            $prompt .= "このデータをもとに売上傾向を予測し、下記のフォーマットで出力してください。\n\n";
            $prompt .= "【条件】\n- 出力は1段落、150文字程度\n- 冒頭に「予測: 」と書く\n- 挨拶や補足は不要\n\n";
            $prompt .= "【売上データ】\n";

            foreach ($sales as $sale) {
                $prompt .= "{$sale->sales_date}: {$sale->sales_amount}円\n";
            }

            $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
                'model' => env('OPENAI_MODEL', 'gpt-3.5-turbo'),
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.7,
            ]);

            $content = $response->json()['choices'][0]['message']['content'] ?? null;

            return $content && str_starts_with($content, '予測:')
                ? $content
                : '予測コメントを取得できませんでした。';
        });

        return view('sales_forecasts.index', compact('sales', 'comment'));
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
