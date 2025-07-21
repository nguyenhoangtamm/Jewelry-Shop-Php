@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="card-container">
    <h3 class="main-title">Data</h3>
    <div class="card-wrapper">
        <div class="payment-card light-red">
            <div class="card-header">
                <div class="amount">
                    <span class="title">Income</span>
                    <span class="amount-value">{{ $income }}</span>
                </div>
                <i class="fas fa-dollar-sign icon dark-blue"></i>
            </div>
        </div>
        <div class="payment-card light-purple">
            <div class="card-header">
                <div class="amount">
                    <span class="title">Orders</span>
                    <span class="amount-value">{{ $count_order }}</span>
                </div>
                <i class="fas fa-list icon dark-purple"></i>
            </div>
        </div>
        <div class="payment-card light-green">
            <div class="card-header">
                <div class="amount">
                    <span class="title">Customers</span>
                    <span class="amount-value">{{ $count_customer }}</span>
                </div>
                <i class="fas fa-users icon dark-green"></i>
            </div>
        </div>
    </div>
</div>
<div class="table-wrapper income-statistical">
    <h3 class="main-title">Income</h3>
    <div class="combobox-select-year">
        <label for="selected-year-income">Year</label>
        <select id="selected-year-income">
            @for ($y = 2021; $y <= date('Y'); $y++)
                <option value="{{ $y }}" @if($year==$y) selected @endif>{{ $y }}</option>
                @endfor
        </select>
    </div>
    <div class="chart-container">
        <canvas id="lineChart-income-month"></canvas>
        <canvas id="lineChart-income-year"></canvas>
    </div>
</div>
<div class="table-wrapper books-statistical">
    <h3 class="main-title">Number of jewelry categories sold</h3>
    <div class="combobox-select-year">
        <label for="selected-year-numJewelry">Year</label>
        <select id="selected-year-numJewelry">
            @for ($y = 2021; $y <= date('Y'); $y++)
                <option value="{{ $y }}" @if($year==$y) selected @endif>{{ $y }}</option>
                @endfor
        </select>
    </div>
    <div class="chart-container chart-container-pie">
        <canvas id="pieChart-categoryJewelrySold-month"></canvas>
        <canvas id="barChart-categoryJewelrySold-month"></canvas>
    </div>
</div>
@endsection