@extends('adminlte::page')

@section('title', 'Reservation Status Kanban')

@section('content_header')
    <h1>Reservation Status Kanban</h1>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="form-group">
        <input type="text" id="search" class="form-control mb-3" placeholder="Search for reservation..." />
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <label for="startDateFilter">Start Date</label>
            <input type="date" id="startDateFilter" class="form-control">
        </div>
        <div class="col-md-3 ml-2">
            <label for="endDateFilter">End Date</label>
            <input type="date" id="endDateFilter" class="form-control">
        </div>
    </div>

    <div class="row d-flex align-items-stretch">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Pending</h3>
                </div>
                <div id="pending" class="kanban-column card-body" data-status="pending">
                    @foreach ($reservations as $reservation)
                        @if ($reservation->status === 'pending')
                            <div class="kanban-item card mb-2" draggable="true" data-id="{{ $reservation->id }}"
                                data-user="{{ $reservation->user->name }}"
                                data-car="{{ $reservation->car->make }} {{ $reservation->car->model }}"
                                data-start-date="{{ $reservation->start_date }}"
                                data-end-date="{{ $reservation->end_date }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $reservation->user->name }} - {{ $reservation->car->make }}
                                        {{ $reservation->car->model }}</h5>
                                    <p class="card-text">From: {{ $reservation->start_date }} To:
                                        {{ $reservation->end_date }}</p>
                                    <small class="text-muted">Total Price: ${{ $reservation->total_price }}</small>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Reserved</h3>
                </div>
                <div id="reserved" class="kanban-column card-body" data-status="reserved">
                    @foreach ($reservations as $reservation)
                        @if ($reservation->status === 'reserved')
                            <div class="kanban-item card mb-2" draggable="true" data-id="{{ $reservation->id }}"
                                data-user="{{ $reservation->user->name }}"
                                data-car="{{ $reservation->car->make }} {{ $reservation->car->model }}"
                                data-start-date="{{ $reservation->start_date }}"
                                data-end-date="{{ $reservation->end_date }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $reservation->user->name }} - {{ $reservation->car->make }}
                                        {{ $reservation->car->model }}</h5>
                                    <p class="card-text">From: {{ $reservation->start_date }} To:
                                        {{ $reservation->end_date }}</p>
                                    <small class="text-muted">Total Price: ${{ $reservation->total_price }}</small>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">In Use</h3>
                </div>
                <div id="in_use" class="kanban-column card-body" data-status="in use">
                    @foreach ($reservations as $reservation)
                        @if ($reservation->status === 'in use')
                            <div class="kanban-item card mb-2" draggable="true" data-id="{{ $reservation->id }}"
                                data-user="{{ $reservation->user->name }}"
                                data-car="{{ $reservation->car->make }} {{ $reservation->car->model }}"
                                data-start-date="{{ $reservation->start_date }}"
                                data-end-date="{{ $reservation->end_date }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $reservation->user->name }} - {{ $reservation->car->make }}
                                        {{ $reservation->car->model }}</h5>
                                    <p class="card-text">From: {{ $reservation->start_date }} To:
                                        {{ $reservation->end_date }}</p>
                                    <small class="text-muted">Total Price: ${{ $reservation->total_price }}</small>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Returned</h3>
                </div>
                <div id="returned" class="kanban-column card-body" data-status="returned">
                    @foreach ($reservations as $reservation)
                        @if ($reservation->status === 'returned')
                            <div class="kanban-item card mb-2" draggable="true" data-id="{{ $reservation->id }}"
                                data-user="{{ $reservation->user->name }}"
                                data-car="{{ $reservation->car->make }} {{ $reservation->car->model }}"
                                data-start-date="{{ $reservation->start_date }}"
                                data-end-date="{{ $reservation->end_date }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $reservation->user->name }} - {{ $reservation->car->make }}
                                        {{ $reservation->car->model }}</h5>
                                    <p class="card-text">From: {{ $reservation->start_date }} To:
                                        {{ $reservation->end_date }}</p>
                                    <small class="text-muted">Total Price: ${{ $reservation->total_price }}</small>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .kanban-column {
            min-height: 400px;
            position: relative;
        }

        .kanban-item {
            cursor: move;
            transition: transform 0.2s, opacity 0.2s;
        }

        .kanban-item.dragging {
            opacity: 0.5;
            transform: scale(1.05);
            z-index: 1000;
        }

        .kanban-item:hover {
            transform: scale(1.02);
        }
    </style>
@endsection

@section('js')
    <script>
        document.getElementById('search').addEventListener('input', filterReservations);
        document.getElementById('startDateFilter').addEventListener('change', filterReservations);
        document.getElementById('endDateFilter').addEventListener('change', filterReservations);

        function filterReservations() {
            const searchValue = document.getElementById('search').value.toLowerCase();
            const startDateValue = document.getElementById('startDateFilter').value;
            const endDateValue = document.getElementById('endDateFilter').value;

            const items = document.querySelectorAll('.kanban-item');

            items.forEach(item => {
                const user = item.getAttribute('data-user').toLowerCase();
                const car = item.getAttribute('data-car').toLowerCase();
                const startDate = item.getAttribute('data-start-date');
                const endDate = item.getAttribute('data-end-date');

                const matchesSearch = user.includes(searchValue) || car.includes(searchValue);
                const matchesStartDate = !startDateValue || new Date(startDate) >= new Date(startDateValue);
                const matchesEndDate = !endDateValue || new Date(endDate) <= new Date(endDateValue);

                if (matchesSearch && matchesStartDate && matchesEndDate) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }


        const columns = document.querySelectorAll('.kanban-column');
        columns.forEach(column => {
            column.addEventListener('dragover', (e) => {
                e.preventDefault();
            });

            column.addEventListener('drop', (e) => {
                const id = e.dataTransfer.getData('text/plain');
                const item = document.querySelector(`[data-id='${id}']`);
                column.appendChild(item);
                item.classList.remove('dragging');

                const newStatus = column.getAttribute('data-status');
                updateReservationStatus(id, newStatus);
            });
        });

        const items = document.querySelectorAll('.kanban-item');
        items.forEach(item => {
            item.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('text/plain', item.getAttribute('data-id'));
                item.classList.add('dragging');
            });

            item.addEventListener('dragend', () => {
                item.classList.remove('dragging');
            });
        });

        function updateReservationStatus(reservationId, newStatus) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/admin/reservations/${reservationId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                })
                .catch(error => console.error('There was a problem with the fetch operation:', error));
        }
    </script>
@endsection
