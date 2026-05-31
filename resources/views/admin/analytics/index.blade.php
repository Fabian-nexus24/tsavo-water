@extends('layouts.admin')

@section('page-title', 'Finance & Analytics')

@push('styles')
<style>
    .kpi-card { transition: transform 0.2s; }
    .kpi-card:hover { transform: translateY(-3px); }
    .icon-box { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 12px; }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Financial Overview</h4>
</div>

<!-- KPI Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 bg-white h-100 kpi-card">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="icon-box bg-success bg-opacity-10 text-success me-3">
                    <i class="bi bi-wallet2 fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted fw-bold small text-uppercase mb-1">Total Revenue</h6>
                    <h3 class="fw-bold mb-0 text-dark">KES {{ number_format($totalRevenue) }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 bg-white h-100 kpi-card">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="icon-box bg-primary bg-opacity-10 text-primary me-3">
                    <i class="bi bi-graph-up-arrow fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted fw-bold small text-uppercase mb-1">Total Profit</h6>
                    <h3 class="fw-bold mb-0 text-dark">KES {{ number_format($totalProfit) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 bg-white h-100 kpi-card">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="icon-box bg-info bg-opacity-10 text-info me-3">
                    <i class="bi bi-cart-check fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted fw-bold small text-uppercase mb-1">Total Orders</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalOrders) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 bg-white h-100 kpi-card">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="icon-box bg-warning bg-opacity-10 text-warning me-3">
                    <i class="bi bi-calculator fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted fw-bold small text-uppercase mb-1">Avg Order Value</h6>
                    <h3 class="fw-bold mb-0 text-dark">KES {{ number_format($averageOrderValue) }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Chart -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
            <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Revenue vs Profit (Last 30 Days)</h6>
            </div>
            <div class="card-body p-4">
                <canvas id="financeChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Selling Products -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
            <div class="card-header bg-white p-4 border-bottom">
                <h6 class="fw-bold mb-0">Top Selling Products</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush rounded-4">
                    @forelse($topProducts as $top)
                    <li class="list-group-item d-flex justify-content-between align-items-center p-4 border-0 border-bottom">
                        <div>
                            <h6 class="fw-bold mb-1">{{ $top->name }}</h6>
                            <span class="text-muted small">{{ number_format($top->total_sold) }} units sold</span>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                            KES {{ number_format($top->total_revenue) }}
                        </span>
                    </li>
                    @empty
                    <li class="list-group-item p-4 text-center text-muted border-0">No data available</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
    <div class="card-header bg-white p-4 border-bottom">
        <h6 class="fw-bold mb-0">Recent Completed Orders</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4 py-3 border-0 small text-uppercase text-muted fw-bold">Order ID</th>
                    <th class="py-3 border-0 small text-uppercase text-muted fw-bold">Customer</th>
                    <th class="py-3 border-0 small text-uppercase text-muted fw-bold">Date</th>
                    <th class="py-3 border-0 small text-uppercase text-muted fw-bold text-end">Revenue</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $order)
                <tr>
                    <td class="ps-4 py-3"><span class="fw-bold text-primary font-mono">{{ $order->order_number }}</span></td>
                    <td class="py-3 fw-medium">{{ $order->user->name ?? 'Unknown' }}</td>
                    <td class="py-3 text-muted small">{{ $order->created_at->format('M d, Y h:i A') }}</td>
                    <td class="py-3 fw-bold text-end pe-4">KES {{ number_format($order->total_amount) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">No recent transactions</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('financeChart').getContext('2d');
    
    // Create gradient for Revenue line
    let revenueGradient = ctx.createLinearGradient(0, 0, 0, 400);
    revenueGradient.addColorStop(0, 'rgba(32, 201, 151, 0.5)'); // success color
    revenueGradient.addColorStop(1, 'rgba(32, 201, 151, 0)');

    // Create gradient for Profit line
    let profitGradient = ctx.createLinearGradient(0, 0, 0, 400);
    profitGradient.addColorStop(0, 'rgba(13, 110, 253, 0.5)'); // primary color
    profitGradient.addColorStop(1, 'rgba(13, 110, 253, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [
                {
                    label: 'Revenue (KES)',
                    data: {!! json_encode($chartRevenue) !!},
                    borderColor: '#20c997', // success
                    backgroundColor: revenueGradient,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#20c997',
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Profit (KES)',
                    data: {!! json_encode($chartProfit) !!},
                    borderColor: '#0d6efd', // primary
                    backgroundColor: profitGradient,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#0d6efd',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 8,
                        font: {
                            family: "'DM Sans', sans-serif",
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: { family: "'DM Sans', sans-serif" },
                    bodyFont: { family: "'DM Sans', sans-serif" },
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += 'KES ' + new Intl.NumberFormat().format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        font: { family: "'DM Sans', sans-serif" },
                        callback: function(value) {
                            return 'KES ' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: { family: "'DM Sans', sans-serif" }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
        }
    });
});
</script>
@endpush
