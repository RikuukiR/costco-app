@extends('layouts.app')

@section('title', 'SALES FORECASTS')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sales_forecasts/index.css') }}">
@endsection

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="contain">

    {{-- タブ切替 --}}
    <div class="tab-container">
        <div class="tab-buttons">
            <a href="{{ route('sales_forecasts.index', ['mode' => 'day']) }}"
                class="tab-button {{ $mode === 'day' ? 'active' : '' }}">DAY</a>
            <a href="{{ route('sales_forecasts.index', ['mode' => 'week']) }}"
                class="tab-button {{ $mode === 'week' ? 'active' : '' }}">WEEK</a>
            <a href="{{ route('sales_forecasts.index', ['mode' => 'year']) }}"
                class="tab-button {{ $mode === 'year' ? 'active' : '' }}">YEAR</a>
        </div>
    </div>

    {{-- 検索フォーム --}}
    <!-- 非機能要件のため今は割愛 -->

    {{-- グラフ表示 --}}
    <canvas id="salesChart" class="sales-chart"></canvas>

    {{-- コメントセクション --}}
    @if($comment)
    <div class="chatgpt-box">
        <div class="chatgpt-title">ChatGPT</div>
        <p class="chatgpt-message">{{ $comment }}</p>
    </div>
    @endif
</div>

<script>
    console.log('targetValues', <?php echo json_encode($targetValues ?? 'not set'); ?>);

    // PHPから渡されたデータをJavaScript変数として定義
    var salesLabels = <?php echo json_encode($salesLabels); ?>;
    var salesValues = <?php echo json_encode($salesValues); ?>;
    var targetValues = <?php echo json_encode($targetValues) ?>;
    var mode = <?php echo json_encode($mode) ?>;

    // データセットを構築
    var datasets = [{
        label: '売上金額（円）',
        data: salesValues,
        borderColor: 'rgba(59, 130, 246, 1)',
        backgroundColor: 'rgba(59, 130, 246, 0.2)',
        fill: true,
        tension: 0.4
    }];

    // DAYモードの場合は目標金額データセットを追加
    if (mode === 'day') {
        datasets.push({
            label: '目標金額（円）',
            data: targetValues,
            borderColor: 'rgba(255, 159, 64, 1)',
            backgroundColor: 'rgba(255, 159, 64, 0.3)',
            fill: true,
            tension: 0.4,
            pointRadius: 0
        });
    }

    const ctx = document.getElementById('salesChart').getContext('2d');

    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: salesLabels,
            datasets: datasets
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                x: {
                    ticks: {
                        callback: function(value, index, ticks) {
                            return this.getLabelForValue(index).split('\n');
                        },
                        font: {
                            size: 12
                        }
                    },
                    title: {
                        display: true,
                        text: '', // 必要であれば記述
                        font: {
                            size: 14
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    // 上限を自動で設定
                    suggestedMax: Math.max(...salesValues) * 1.1,
                    title: {
                        display: true,
                        text: '売上金額（円）',
                        font: {
                            size: 14
                        },
                        padding: {
                            top: 0,
                            bottom: 30
                        }
                    },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>


@endsection