@extends('adminlte::page')

@section('title', 'Reports and Analytics')

@section('content_header')
    <h1>Reports and Analytics</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalCars ?? 'No data' }}</h3>
                    <p>Total Cars</p>
                </div>
                <div class="icon">
                    <i class="fas fa-car"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalReservations ?? 'No data' }}</h3>
                    <p>Total Reservations</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner text-white">
                    <h3>{{ $totalRatings ?? 'No data' }}</h3>
                    <p>Total Ratings</p>
                </div>
                <div class="icon">
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $reservationsThisMonth ?? 'No data' }}</h3>
                    <p>Reservations This Month</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $totalUsers ?? 'No data' }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2>Car Statuses</h2>
            @if (count($carStatuses) > 0)
                <ul>
                    @foreach ($carStatuses as $status => $count)
                        <li>{{ ucfirst($status) }}: {{ $count }}</li>
                    @endforeach
                </ul>
            @else
                <p>No available car statuses.</p>
            @endif
        </div>
        <div class="col-md-6">
            <h2>Reservation Statuses</h2>
            @if (count($reservationStatuses) > 0)
                <ul>
                    @foreach ($reservationStatuses as $status => $count)
                        <li>{{ ucfirst($status) }}: {{ $count }}</li>
                    @endforeach
                </ul>
            @else
                <p>No available reservation statuses.</p>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2>Monthly Reservations Chart</h2>
            <canvas id="reservationsChart"></canvas>
        </div>
        <div class="col-md-6">
            <h2>Monthly Ratings Chart</h2>
            <canvas id="ratingsChart"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h2>Top Rated Cars</h2>
            @if (count($topRatedCars) > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Car Make</th>
                            <th>Car Model</th>
                            <th>Average Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topRatedCars as $car)
                            <tr>
                                <td>{{ $car->make }}</td>
                                <td>{{ $car->model }}</td>
                                <td>{{ number_format($car->average_rating, 1) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No top-rated cars available.</p>
            @endif
        </div>
    </div>
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Definišemo niz meseci
        var months = ['October', 'November', 'December', 'January', 'February', 'March', 'April', 'May', 'June', 'July',
            'August', 'September'
        ];

        // Monthly Reservations Chart
        var ctx = document.getElementById('reservationsChart').getContext('2d');
        var reservationsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Number of Reservations',
                    data: @json($monthlyReservations), // Očekuje da su podaci u ispravnom redosledu
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Monthly Ratings Chart
        var ctx2 = document.getElementById('ratingsChart').getContext('2d');
        var ratingsChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Number of Ratings',
                    data: @json($monthlyRatings), // Očekuje da su podaci u ispravnom redosledu
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Proveri podatke u konzoli
        console.log('Monthly Reservations:', @json($monthlyReservations));
        console.log('Monthly Ratings:', @json($monthlyRatings));
    </script>
@stop
