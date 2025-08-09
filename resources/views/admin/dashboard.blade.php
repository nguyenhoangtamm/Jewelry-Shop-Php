@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="dashboard-container">
    <div class="stats-section">
        <h3 class="section-title">Tổng quan dữ liệu</h3>
        <div class="stats-grid">
            <div class="stat-card income-card">
                <div class="stat-content">
                    <div class="stat-info">
                        <h4 class="stat-title">Doanh thu</h4>
                        <p class="stat-value">{{ number_format($income) }}₫</p>
                        <span class="stat-change positive">+12.5%</span>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
                <div class="stat-gradient income-gradient"></div>
            </div>
            
            <div class="stat-card orders-card">
                <div class="stat-content">
                    <div class="stat-info">
                        <h4 class="stat-title">Đơn hàng</h4>
                        <p class="stat-value">{{ $count_order }}</p>
                        <span class="stat-change positive">+8.2%</span>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
                <div class="stat-gradient orders-gradient"></div>
            </div>
            
            <div class="stat-card customers-card">
                <div class="stat-content">
                    <div class="stat-info">
                        <h4 class="stat-title">Khách hàng</h4>
                        <p class="stat-value">{{ $count_customer }}</p>
                        <span class="stat-change positive">+15.7%</span>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-gradient customers-gradient"></div>
            </div>
        </div>
    </div>

    <div class="charts-section">
        <div class="chart-card income-chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Biểu đồ doanh thu</h3>
                <div class="year-selector">
                    <label for="selected-year-income">Năm</label>
                    <select id="selected-year-income" onchange="onChangeYear(this.value)">
                        @foreach ($years as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="chart-tabs">
                <button class="tab-btn active" data-chart="monthly">Theo tháng</button>
                <button class="tab-btn" data-chart="yearly">Theo năm</button>
            </div>
            <div class="chart-container">
                <canvas id="lineChart-income-month" class="chart-canvas active"></canvas>
                <canvas id="lineChart-income-year" class="chart-canvas"></canvas>
            </div>
        </div>

        <div class="chart-card category-chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Thống kê danh mục trang sức</h3>
                <div class="year-selector">
                    <label for="selected-year-numJewelry">Năm</label>
                    <select id="selected-year-numJewelry" onchange="onChangeYear(this.value)">
                        @foreach ($years as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="chart-tabs">
                <button class="tab-btn active" data-chart="pie">Biểu đồ tròn</button>
                <button class="tab-btn" data-chart="bar">Biểu đồ cột</button>
            </div>
            <div class="chart-container">
                <canvas id="pieChart-categoryJewelrySold-month" class="chart-canvas active"></canvas>
                <canvas id="barChart-categoryJewelrySold-month" class="chart-canvas"></canvas>
            </div>
        </div>
    </div>
</div>

<style>
/* Galaxy Blue Theme Variables */
:root {
    --galaxy-primary: #0098fe;
    --galaxy-secondary: #3949ab;
    --galaxy-accent: #5c6bc0;
    --galaxy-light: #9fa8da;
    --galaxy-gradient: linear-gradient(135deg, #1a237e 0%, #3949ab 50%, #5c6bc0 100%);
    --galaxy-dark: #0d1421;
    --text-primary: #070823;
    --text-secondary: #0096e1;
    --background: #0f1419;
    --card-bg: rgba(26, 35, 126, 0.1);
    --glass-bg: rgba(255, 255, 255, 0.05);
    --shadow: 0 8px 32px rgba(26, 35, 126, 0.2);
    --border-radius: 16px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: var(--background);
    color: var(--text-primary);
    font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
}

.dashboard-container {
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
    gap: 2rem;
    display: flex;
    flex-direction: column;
}

/* Stats Section */
.stats-section {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    background: var(--galaxy-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.stat-card {
    position: relative;
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: var(--border-radius);
    padding: 2rem;
    overflow: hidden;
    transition: var(--transition);
    cursor: pointer;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow);
    border-color: var(--galaxy-accent);
}

.stat-content {
    position: relative;
    z-index: 2;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stat-title {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-value {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.stat-change {
    font-size: 0.85rem;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-weight: 600;
}

.stat-change.positive {
    background: rgba(76, 175, 80, 0.2);
    color: #4caf50;
}

.stat-icon {
    font-size: 2.5rem;
    opacity: 0.7;
    color: var(--galaxy-accent);
}

.stat-gradient {
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    opacity: 0.1;
    border-radius: var(--border-radius);
    z-index: 1;
}

.income-gradient {
    background: linear-gradient(135deg, #ff6b6b, #ffa726);
}

.orders-gradient {
    background: linear-gradient(135deg, #42a5f5, #26c6da);
}

.customers-gradient {
    background: linear-gradient(135deg, #ab47bc, #7e57c2);
}

/* Charts Section */
.charts-section {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

.chart-card {
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: var(--border-radius);
    padding: 2rem;
    transition: var(--transition);
}

.chart-card:hover {
    border-color: var(--galaxy-accent);
    box-shadow: var(--shadow);
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.chart-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-primary);
}

.year-selector {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.year-selector label {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.year-selector select {
    background: var(--galaxy-primary);
    color: var(--text-primary);
    border: 1px solid var(--galaxy-accent);
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    cursor: pointer;
    transition: var(--transition);
}

.year-selector select:focus {
    outline: none;
    border-color: var(--galaxy-light);
    box-shadow: 0 0 0 3px rgba(159, 168, 218, 0.2);
}

.chart-tabs {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    background: rgba(255, 255, 255, 0.05);
    padding: 0.25rem;
    border-radius: 12px;
    width: fit-content;
}

.tab-btn {
    background: transparent;
    color: var(--text-secondary);
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    cursor: pointer;
    transition: var(--transition);
    font-weight: 500;
}

.tab-btn.active {
    background: var(--galaxy-primary);
    color: var(--text-primary);
    box-shadow: 0 2px 8px rgba(26, 126, 124, 0.3);
}

.tab-btn:hover:not(.active) {
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-primary);
}

.chart-container {
    position: relative;
    height: 400px;
    width: 100%;
}

.chart-canvas {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    transition: var(--transition);
}

.chart-canvas.active {
    opacity: 1;
    visibility: visible;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 1rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-card {
        padding: 1.5rem;
    }
    
    .chart-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    
    .chart-container {
        height: 300px;
    }
}

@media (min-width: 1200px) {
    .charts-section {
        grid-template-columns: 1fr 1fr;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card,
.chart-card {
    animation: fadeInUp 0.6s ease-out;
}

.stat-card:nth-child(2) {
    animation-delay: 0.1s;
}

.stat-card:nth-child(3) {
    animation-delay: 0.2s;
}

.chart-card:nth-child(2) {
    animation-delay: 0.3s;
}
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chuyển trang khi chọn năm
    function onChangeYear(year) {
        const url = new URL(window.location.href);
        url.searchParams.set('year', year);
        window.location.href = url.toString();
    }

    // Tab switching functionality
    document.addEventListener('DOMContentLoaded', () => {
        // Tab switching
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const chartType = btn.dataset.chart;
                const container = btn.closest('.chart-card');
                
                // Update tab buttons
                container.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                // Update charts
                container.querySelectorAll('.chart-canvas').forEach(canvas => {
                    canvas.classList.remove('active');
                });
                
                if (chartType === 'monthly') {
                    container.querySelector('#lineChart-income-month').classList.add('active');
                } else if (chartType === 'yearly') {
                    container.querySelector('#lineChart-income-year').classList.add('active');
                } else if (chartType === 'pie') {
                    container.querySelector('#pieChart-categoryJewelrySold-month').classList.add('active');
                } else if (chartType === 'bar') {
                    container.querySelector('#barChart-categoryJewelrySold-month').classList.add('active');
                }
            });
        });
    });

    // Tránh khai báo lại nếu script bị push nhiều lần
    if (typeof window.dashboardChartData === 'undefined') {
        window.dashboardChartData = {
            monthlyIncome: {!! json_encode($monthly_income_chart) !!},
            yearlyIncome: {!! json_encode($yearly_income) !!},
            categoryJewelry: {!! json_encode($category_jewelry_sold) !!}
        };
    }

    document.addEventListener('DOMContentLoaded', () => {
        const { monthlyIncome, yearlyIncome, categoryJewelry } = window.dashboardChartData;

        // Galaxy Blue Color Scheme
        const galaxyColors = {
            primary: '#1a237e',
            secondary: '#3949ab',
            accent: '#5c6bc0',
            light: '#9fa8da',
            gradient: ['#1a237e', '#3949ab', '#5c6bc0', '#7986cb', '#9fa8da', '#c5cae9']
        };

        const canvasMonth = document.getElementById('lineChart-income-month');
        if (canvasMonth) {
            new Chart(canvasMonth.getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                    datasets: [{
                        label: 'Doanh thu theo tháng (VND)',
                        data: monthlyIncome,
                        borderWidth: 3,
                        borderColor: galaxyColors.accent,
                        backgroundColor: 'rgba(92, 107, 192, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: galaxyColors.secondary,
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color:' #003366'
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#b0bec5'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        },
                        y: {
                            ticks: {
                                color: '#b0bec5'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        }
                    }
                }
            });
        }

        const canvasYear = document.getElementById('lineChart-income-year');
        if (canvasYear) {
            new Chart(canvasYear.getContext('2d'), {
                type: 'line',
                data: {
                    labels: Object.keys(yearlyIncome),
                    datasets: [{
                        label: 'Doanh thu theo năm (VND)',
                        data: Object.values(yearlyIncome),
                        borderWidth: 3,
                        borderColor: galaxyColors.light,
                        backgroundColor: 'rgba(159, 168, 218, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: galaxyColors.primary,
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: ' #003366'
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#b0bec5'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        },
                        y: {
                            ticks: {
                                color: '#b0bec5'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        }
                    }
                }
            });
        }

        const canvasPie = document.getElementById('pieChart-categoryJewelrySold-month');
        if (canvasPie) {
            new Chart(canvasPie.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: Object.keys(categoryJewelry),
                    datasets: [{
                        label: 'Số lượng đã bán',
                        data: Object.values(categoryJewelry),
                        backgroundColor: galaxyColors.gradient,
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#003366',
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }

        const canvasBar = document.getElementById('barChart-categoryJewelrySold-month');
        if (canvasBar) {
            new Chart(canvasBar.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: Object.keys(categoryJewelry),
                    datasets: [{
                        label: 'Số lượng đã bán',
                        data: Object.values(categoryJewelry),
                        backgroundColor: galaxyColors.gradient.map(color => color + '80'),
                        borderColor: galaxyColors.gradient,
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                 color: '#003366'
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#b0bec5'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        },
                        y: {
                            ticks: {
                                color: '#b0bec5'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush