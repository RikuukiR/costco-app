@extends('layouts.app')

@section('title', 'HOME')

@section('css')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
<div class="home-container">
    <div class="card__flex">
        <a href="{{ route('products.index') }}" class="card__item">
            <img src="{{ asset('images/ingredients-icon.png') }}" alt="商品管理">
            <span>INGREDIENTS</span>
        </a>
        <a href="{{ route('specs.index') }}" class="card__item">
            <img src="{{ asset('images/spec-icon.png') }}" alt="SPEC管理">
            <span>SPEC</span>
        </a>
        <a href="{{ route('volumes.index') }}" class="card__item">
            <img src="{{ asset('images/volume-icon.png') }}" alt="VOLUME管理">
            <span>VOLUME</span>
        </a>
        <a href="{{ route('destroys.index') }}" class="card__item">
            <img src="{{ asset('images/destroy-icon.png') }}" alt="DESTROY管理">
            <span>DESTROY</span>
        </a>
        <a href="{{ route('weights.index') }}" class="card__item">
            <img src="{{ asset('images/weight-icon.png') }}" alt="WEIGHT管理">
            <span>WEIGHT</span>
        </a>
        <a href="{{ route('sales.index') }}" class="card__item">
            <img src="{{ asset('images/sales-icon.png') }}" alt="売上管理">
            <span>SALES</span>
        </a>
        <a href="{{ route('sales_forecasts.index') }}" class="card__item">
            <img src="{{ asset('images/sales_forecasts-icon.png') }}" alt="売上予測">
            <span>SALES FORECASTS</span>
        </a>
        <a href="{{ route('schedules.index') }}" class="card__item">
            <img src="{{ asset('images/schedule-icon.png') }}" alt="スケジュール管理">
            <span>SCHEDULE</span>
        </a>
    </div>

    <div class="reminder-section">
        <div class="reminder-title">
            <img src="{{ asset('images/remind-icon.png') }}" alt="リマインド">
            <h3>REMIND</h3>
        </div>
        <div class="reminder-content">
            <table class="reminder-table">
                <thead>
                    <tr>
                        <th>CATEGORY</th>
                        <th>ACTION</th>
                        <th>STATUS</th>
                        <th>DATE</th>
                        <th>USER</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>SPEC</td>
                        <td>未登録</td>
                        <td class="status-urgent">未対応</td>
                        <td>2025-06-09</td>
                        <td>SHINJI</td>
                    </tr>
                    <tr>
                        <td>VOLUME</td>
                        <td>発注漏れ</td>
                        <td class="status-warning">確認中</td>
                        <td>2025-06-08</td>
                        <td>KYOHEI</td>
                    </tr>
                    <tr>
                        <td>WEIGHT</td>
                        <td>測定未完了</td>
                        <td class="status-urgent">未対応</td>
                        <td>2025-06-09</td>
                        <td>SHUHEI</td>
                    </tr>
                    <tr>
                        <td>SALES</td>
                        <td>データ未入力</td>
                        <td class="status-warning">確認中</td>
                        <td>2025-06-10</td>
                        <td>SHINJI</td>
                    </tr>
                    <tr>
                        <td>DESTROY</td>
                        <td>廃棄処理待ち</td>
                        <td class="status-urgent">未対応</td>
                        <td>2025-06-10</td>
                        <td>KYOHEI</td>
                    </tr>
                    <tr>
                        <td>SCHEDULE</td>
                        <td>シフト未提出</td>
                        <td class="status-warning">確認中</td>
                        <td>2025-06-11</td>
                        <td>SHINJI</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection