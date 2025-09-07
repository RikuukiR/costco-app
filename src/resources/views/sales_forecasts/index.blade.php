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
    var targetValues = <?php echo json_encode($targetValues); ?>;
    var mode = <?php echo json_encode($mode); ?>;
    var allValues = salesValues.concat(targetValues);

    // データセットを構築
    var datasets = [{
        label: '売上金額（円）',
        data: salesValues,
        borderColor: 'rgba(59, 130, 246, 1)',
        backgroundColor: 'rgba(59, 130, 246, 0.2)',
        fill: true,
        tension: 0.4
    }];

    // targetValuesが空でなければ、モードに応じて目標グラフを追加
    if (Array.isArray(targetValues) && targetValues.length > 0) {
        let targetLabel = '目標金額（円）'; // デフォルトラベル
        if (mode === 'week') {
            targetLabel = '週間目標金額（円）';
        }

        datasets.push({
            label: targetLabel,
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
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#333',
                    bodyColor: '#666',
                    borderColor: '#ddd',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 12,
                    callbacks: {
                        title: function(context) {
                            // 日付をより読みやすい形式で表示
                            return context[0].label;
                        },
                        label: function(context) {
                            let label = context.dataset.label || '';
                            
                            if (label) {
                                label += ': ';
                            }
                            
                            // 金額を日本円形式でフォーマット
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('ja-JP', {
                                    style: 'currency',
                                    currency: 'JPY',
                                    minimumFractionDigits: 0
                                }).format(context.parsed.y);
                            }
                            
                            return label;
                        },
                        afterLabel: function(context) {
                            // 前日比の計算と表示
                            if (context.dataIndex > 0) {
                                const current = context.parsed.y;
                                const previous = context.dataset.data[context.dataIndex - 1];
                                if (previous && current && previous !== 0) {
                                    const change = ((current - previous) / previous * 100).toFixed(1);
                                    return `前日比: ${change > 0 ? '+' : ''}${change}%`;
                                }
                            }
                            return '';
                        },
                        footer: function(tooltipItems) {
                            // 売上と目標の差額を計算
                            let salesValue = null;
                            let targetValue = null;
                            
                            tooltipItems.forEach(item => {
                                if (item.dataset.label.includes('売上')) {
                                    salesValue = item.parsed.y;
                                } else if (item.dataset.label.includes('目標')) {
                                    targetValue = item.parsed.y;
                                }
                            });
                            
                            if (salesValue !== null && targetValue !== null && targetValue !== 0) {
                                const difference = salesValue - targetValue;
                                const percentage = ((salesValue / targetValue - 1) * 100).toFixed(1);
                                return [
                                    `差額: ${new Intl.NumberFormat('ja-JP', {
                                        style: 'currency',
                                        currency: 'JPY',
                                        minimumFractionDigits: 0
                                    }).format(difference)}`,
                                    `達成率: ${percentage > 0 ? '+' : ''}${percentage}%`
                                ];
                            }
                            
                            return '';
                        }
                    }
                },
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
                    suggestedMax: allValues.length > 0 ? Math.max(...allValues) * 1.1 : undefined,
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