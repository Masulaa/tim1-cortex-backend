@extends('adminlte::page')

@section('title', 'Car Status Kanban')

@section('content_header')
    <h1>Car Status Kanban</h1>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="form-group">
        <input type="text" id="search" class="form-control mb-3" placeholder="Search for vehicle..." />
    </div>

    <div class="form-group row">
        <div class="col-md-2">
            <label for="fuel-type">Filter by Fuel Type:</label>
            <select id="fuel-type" class="form-control">
                <option value="">All</option>
                <option value="gasoline">Gasoline</option>
                <option value="diesel">Diesel</option>
                <option value="electric">Electric</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="transmission-type">Filter by Transmission:</label>
            <select id="transmission-type" class="form-control">
                <option value="">All</option>
                <option value="manual">Manual</option>
                <option value="automatic">Automatic</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="door-count">Filter by Number of Doors:</label>
            <select id="door-count" class="form-control">
                <option value="">All</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="year-range">Filter by Year:</label>
            <input type="range" id="year-range" min="1980" max="2024" value="2024" class="form-control-range">
            <small>Selected Year: <span id="selected-year">2024</span></small>
        </div>
        <div class="col-md-4">
            <label for="price-range">Filter by Price Per Day:</label>
            <input type="range" id="price-range" min="0" max="200" value="200" class="form-control-range">
            <small>Selected Price: $<span id="selected-price">200</span>/day</small>
        </div>
    </div>

    <div class="row d-flex align-items-stretch">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Available</h3>
                </div>
                <div id="available" class="kanban-column card-body" data-status="available">
                    @foreach ($cars as $car)
                        @if ($car->status === 'available')
                            <div class="kanban-item card mb-2" draggable="true" data-id="{{ $car->id }}"
                                data-fuel="{{ $car->fuel_type }}" data-transmission="{{ $car->transmission }}"
                                data-doors="{{ $car->doors }}" data-year="{{ $car->year }}"
                                data-price="{{ $car->price_per_day }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $car->make }} {{ $car->model }}</h5>
                                    <small class="text-muted">Price: ${{ $car->price_per_day }}/day</small>
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
                    @foreach ($cars as $car)
                        @if ($car->status === 'reserved')
                            <div class="kanban-item card mb-2" draggable="true" data-id="{{ $car->id }}"
                                data-fuel="{{ $car->fuel_type }}" data-transmission="{{ $car->transmission }}"
                                data-doors="{{ $car->doors }}" data-year="{{ $car->year }}"
                                data-price="{{ $car->price_per_day }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $car->make }} {{ $car->model }}</h5>
                                    <p class="card-text">{{ $car->description }}</p>
                                    <small class="text-muted">Price: ${{ $car->price_per_day }}/day</small>
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
                    <h3 class="card-title">Under Maintenance</h3>
                </div>
                <div id="maintenance" class="kanban-column card-body" data-status="under maintenance">
                    @foreach ($cars as $car)
                        @if ($car->status === 'under maintenance')
                            <div class="kanban-item card mb-2" draggable="true" data-id="{{ $car->id }}"
                                data-fuel="{{ $car->fuel_type }}" data-transmission="{{ $car->transmission }}"
                                data-doors="{{ $car->doors }}" data-year="{{ $car->year }}"
                                data-price="{{ $car->price_per_day }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $car->make }} {{ $car->model }}</h5>
                                    <p class="card-text">{{ $car->description }}</p>
                                    <small class="text-muted">Price: ${{ $car->price_per_day }}/day</small>
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
                    <h3 class="card-title">Out of Order</h3>
                </div>
                <div id="out_of_order" class="kanban-column card-body" data-status="out of order">
                    @foreach ($cars as $car)
                        @if ($car->status === 'out of order')
                            <div class="kanban-item card mb-2" draggable="true" data-id="{{ $car->id }}"
                                data-fuel="{{ $car->fuel_type }}" data-transmission="{{ $car->transmission }}"
                                data-doors="{{ $car->doors }}" data-year="{{ $car->year }}"
                                data-price="{{ $car->price_per_day }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $car->make }} {{ $car->model }}</h5>
                                    <p class="card-text">{{ $car->description }}</p>
                                    <small class="text-muted">Price: ${{ $car->price_per_day }}/day</small>
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

        .form-control-range {
            width: 100%;
        }
    </style>
@endsection

@section('js')
    <script>
        const columns = document.querySelectorAll('.kanban-column');
        const selectedYearDisplay = document.getElementById('selected-year');
        const selectedPriceDisplay = document.getElementById('selected-price');
        const yearRange = document.getElementById('year-range');
        const priceRange = document.getElementById('price-range');

        yearRange.addEventListener('input', function() {
            selectedYearDisplay.textContent = yearRange.value;
            filterCars();
        });

        priceRange.addEventListener('input', function() {
            selectedPriceDisplay.textContent = priceRange.value;
            filterCars();
        });

        columns.forEach(column => {
            column.addEventListener('dragover', (e) => {
                e.preventDefault();
            });

            column.addEventListener('drop', (e) => {
                const id = e.dataTransfer.getData('text/plain');
                const item = document.querySelector(`[data-id='${id}']`);
                column.appendChild(item);
                item.classList.remove('dragging');

                // Ažuriranje statusa automobila u realnom vremenu
                const newStatus = column.getAttribute('data-status');
                updateCarStatus(id, newStatus); // Funkcija za slanje AJAX zahteva
            });
        });

        const filters = document.querySelectorAll('#fuel-type, #transmission-type, #door-count');
        filters.forEach(filter => {
            filter.addEventListener('change', filterCars);
        });

        document.getElementById('search').addEventListener('input', filterCars);

        function filterCars() {
            const searchValue = document.getElementById('search').value.toLowerCase();
            const fuelType = document.getElementById('fuel-type').value;
            const transmissionType = document.getElementById('transmission-type').value;
            const doorCount = document.getElementById('door-count').value;
            const selectedYear = parseInt(yearRange.value);
            const selectedPrice = parseInt(priceRange.value);

            console.log("Door count selected:", doorCount);

            const items = document.querySelectorAll('.kanban-item');
            items.forEach(item => {
                const carFuel = item.getAttribute('data-fuel');
                const carTransmission = item.getAttribute('data-transmission');
                const carDoors = item.getAttribute('data-doors');
                const carYear = parseInt(item.getAttribute('data-year'), 10);
                const carPrice = parseInt(item.getAttribute('data-price'), 10);

                const matchesSearch = item.querySelector('.card-title').textContent.toLowerCase().includes(
                    searchValue);
                const matchesFuel = !fuelType || carFuel === fuelType;
                const matchesTransmission = !transmissionType || carTransmission === transmissionType;
                const matchesDoors = !doorCount || carDoors === doorCount;
                const matchesYear = carYear <= selectedYear;
                const matchesPrice = carPrice <= selectedPrice;

                if (matchesSearch && matchesFuel && matchesTransmission && matchesDoors && matchesYear &&
                    matchesPrice) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

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

        // Funkcija za ažuriranje statusa automobila koristeći AJAX
        function updateCarStatus(carId, newStatus) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/admin/cars/${carId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
@endsection
