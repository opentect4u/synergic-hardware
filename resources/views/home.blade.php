@extends('common.master')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card bg-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <h4 class="mt-1 mb-1">Welcome to {{auth()->user()->user_name}} !</h4>
                    <!-- <button class="btn btn-info d-none d-md-block">Import</button> -->
                </div>
            </div>
        </div>
    </div>

    @if($lowStockItems->isNotEmpty())
    <div id="low-stock-notification" class="alert alert-danger alert-dismissible fade show" role="alert"
        style="position:fixed;top:80px;right:20px;z-index:1050;width:calc(100% - 40px);max-width:420px;max-height:80vh;overflow-y:auto;opacity:1;background-color:#f8d7da;cursor:move;touch-action:none;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <button type="button" class="btn btn-link text-danger font-weight-bold p-0 text-left"
            data-toggle="collapse" data-target="#low-stock-details" aria-expanded="false"
            aria-controls="low-stock-details">
            <i class="mdi mdi-alert-outline mr-1"></i>
            Low stock: {{ $lowStockItems->count() }} item(s) need attention
        </button>
        <div id="low-stock-details" class="collapse mt-2">
            <ul class="mb-0 pl-3">
                @foreach($lowStockItems as $item)
                <li>{{ $item->mc_type }}: {{ $item->current_quantity }} in stock</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="row no-gutters">
        <div class="col-md-3 stretch-card">
            <a href="{{ route('customer') }}" class="d-block w-100" style="text-decoration:none;color:inherit;">
                <div class="card">
                    <div class="card-body text-center position-relative">
                        <i class="mdi mdi-account" style="font-size:36px;color:#4caf50;"></i>
                        <h6 class="card-title mt-2">Customers</h6>
                        <h2>{{ $counts['customers'] ?? 0 }}</h2>
                        <span class="stretched-link" aria-hidden="true"></span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 stretch-card">
            <a href="{{ route('deviceType') }}" class="d-block w-100" style="text-decoration:none;color:inherit;">
                <div class="card">
                    <div class="card-body text-center position-relative">
                        <i class="mdi mdi-laptop" style="font-size:36px;color:#2196f3;"></i>
                        <h6 class="card-title mt-2">Device Types</h6>
                        <h2>{{ $counts['devices'] ?? 0 }}</h2>
                        <span class="stretched-link" aria-hidden="true"></span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 stretch-card">
            <a href="{{ route('serviceCentre') }}" class="d-block w-100" style="text-decoration:none;color:inherit;">
                <div class="card">
                    <div class="card-body text-center position-relative">
                        <i class="mdi mdi-office-building" style="font-size:36px;color:#ff9800;"></i>
                        <h6 class="card-title mt-2">Service Centres</h6>
                        <h2>{{ $counts['service_centres'] ?? 0 }}</h2>
                        <span class="stretched-link" aria-hidden="true"></span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 stretch-card">
            <a href="{{ route('technician') }}" class="d-block w-100" style="text-decoration:none;color:inherit;">
                <div class="card">
                    <div class="card-body text-center position-relative">
                        <i class="mdi mdi-account-tie" style="font-size:36px;color:#9c27b0;"></i>
                        <h6 class="card-title mt-2">Technicians</h6>
                        <h2>{{ $counts['technicians'] ?? 0 }}</h2>
                        <span class="stretched-link" aria-hidden="true"></span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row no-gutters">
        <div class="col-md-6 stretch-card">
            <a href="{{ route('reports.warranty.current.month.purchase') }}" class="d-block w-100" style="text-decoration:none;color:inherit;">
            <div class="card w-100">
                <div class="card-body text-center">
                    <i class="mdi mdi-calendar-plus" style="font-size:36px;color:#009688;"></i>
                    <h6 class="card-title mt-2">Purchase AMC for this month</h6>
                    <h2>{{ $counts['purchase_amc'] ?? 0 }}</h2>
                </div>
            </div>
            </a>
        </div>

        <div class="col-md-6 stretch-card">
            <a href="{{ route('reports.warranty.current.month.sale') }}" class="d-block w-100" style="text-decoration:none;color:inherit;">
            <div class="card w-100">
                <div class="card-body text-center">
                    <i class="mdi mdi-calendar-check" style="font-size:36px;color:#e91e63;"></i>
                    <h6 class="card-title mt-2">Sale AMC for this month</h6>
                    <h2>{{ $counts['sale_amc'] ?? 0 }}</h2>
                </div>
            </div>
            </a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <form method="get" action="{{ route('dashboard') }}" class="form-inline">
                        <label for="chart-item" class="mr-3">Item</label>
                        <select id="chart-item" name="item" class="form-control" onchange="this.form.submit()">
                            @foreach($availableItems as $item)
                            <option value="{{ $item->mc_id }}" {{ (string) $selectedItem === (string) $item->mc_id ? 'selected' : '' }}>
                                {{ $item->mc_type }}
                            </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card w-100">
                <div class="card-body">
                    <h4 class="card-title">{{ optional($availableItems->firstWhere('mc_id', $selectedItem))->mc_type ?? 'Selected Item' }}: Purchase vs Sale</h4>
                    <div style="height:420px;position:relative;">
                        <canvas id="comparison-chart"></canvas>
                    </div>
                    <div class="text-center mt-4">
                        <h6 class="card-title">Current Stock as on {{ date('d-m-Y') }}</h6>
                        <h2>{{ $currentStock ?? 0 }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="row">
        <div class="col-xl-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Total Sales</p>
                    <p class="text-muted">Audience to which the users belonged while on the current date Audience to
                        which
                        the users belonged while on the current date Audience to which the users belonged while on the
                        current date </p>
                    <div class="d-flex flex-wrap mb-4 mt-4 pb-4">
                        <div class="mr-4 mr-md-5">
                            <p class="mb-0">Revenue</p>
                            <h4>13,956</h4>
                        </div>
                        <div class="mr-4 mr-md-5">
                            <p class="mb-0">Returns</p>
                            <h4>27,219</h4>
                        </div>
                        <div class="mr-4 mr-md-5">
                            <p class="mb-0">Queries</p>
                            <h4>03,386</h4>
                        </div>
                        <div class="mr-4 mr-md-5">
                            <p class="mb-0">Invoices</p>
                            <h4>04,739</h4>
                        </div>
                    </div>
                    <canvas id="total-sales-chart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6 grid-margin">
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title">Users</p>
                            <div class="d-flex flex-wrap align-items-baseline">
                                <h2 class="mr-3">33,956</h2>
                                <i class="mdi mdi-arrow-up mr-1 text-danger"></i><span>
                                    <p class="mb-0 text-danger font-weight-medium">+2.12%</p>
                                </span>
                            </div>
                            <p class="mb-0 text-muted">Total users world wide</p>
                        </div>
                        <canvas id="users-chart"></canvas>
                    </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title">Projects</p>
                            <div class="d-flex flex-wrap align-items-baseline">
                                <h2 class="mr-3">50.36%</h2>
                                <i class="mdi mdi-arrow-up mr-1 text-success"></i><span>
                                    <p class="mb-0 text-success font-weight-medium">+9.12%</p>
                                </span>
                            </div>
                            <p class="mb-0 text-muted">Total users world wide</p>
                        </div>
                        <canvas id="projects-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title">Downloads</p>
                            <p class="text-muted mb-2">Watching ice melt. This is fun. Only you could make those words
                                cute.
                            </p>
                            <div class="row mt-4">
                                <div class="col-md-6 stretch-card">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-6">
                                            <div id="offlineProgress"></div>
                                        </div>
                                        <div class="col-6 pl-0">
                                            <p class="mb-0">Offline</p>
                                            <h2>45,324</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 stretch-card mt-4 mt-md-0">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-6">
                                            <div id="onlineProgress"></div>
                                        </div>
                                        <div class="col-6 pl-0">
                                            <p class="mb-0">Online</p>
                                            <h2>12,236</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

</div>

@endsection

@section('script')
<script>
var lowStockNotification = document.getElementById('low-stock-notification');
if (lowStockNotification) {
    var isDragging = false;
    var dragOffsetX = 0;
    var dragOffsetY = 0;

    lowStockNotification.addEventListener('pointerdown', function(event) {
        if (event.target.closest('button, a')) {
            return;
        }

        var bounds = lowStockNotification.getBoundingClientRect();
        lowStockNotification.style.left = bounds.left + 'px';
        lowStockNotification.style.top = bounds.top + 'px';
        lowStockNotification.style.right = 'auto';
        dragOffsetX = event.clientX - bounds.left;
        dragOffsetY = event.clientY - bounds.top;
        isDragging = true;
        lowStockNotification.setPointerCapture(event.pointerId);
    });

    lowStockNotification.addEventListener('pointermove', function(event) {
        if (!isDragging) {
            return;
        }

        lowStockNotification.style.left = (event.clientX - dragOffsetX) + 'px';
        lowStockNotification.style.top = (event.clientY - dragOffsetY) + 'px';
    });

    lowStockNotification.addEventListener('pointerup', function() {
        isDragging = false;
    });
}

$(function() {
    new Chart(document.getElementById('comparison-chart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($comparisonChart->pluck('period')->values()) !!},
                datasets: [{
                    label: 'Purchase',
                    data: {!! json_encode($comparisonChart->pluck('purchase_quantity')->values()) !!},
                    backgroundColor: '#2196f3',
                    borderColor: '#ffffff',
                    borderWidth: 2
                }, {
                    label: 'Sale',
                    data: {!! json_encode($comparisonChart->pluck('sale_quantity')->values()) !!},
                    backgroundColor: '#ff9800',
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { display: true, position: 'top' },
                tooltips: {
                    callbacks: {
                        title: function() {
                            return '';
                        },
                        label: function(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            return dataset.label + ': ' + tooltipItem.yLabel;
                        }
                    }
                },
                scales: {
                    xAxes: [{
                        ticks: { autoSkip: false },
                        scaleLabel: { display: true, labelString: 'Period' }
                    }],
                    yAxes: [{
                        ticks: { beginAtZero: true },
                        scaleLabel: { display: true, labelString: 'Count' }
                    }]
                }
            }
        });
});
</script>

@endsection