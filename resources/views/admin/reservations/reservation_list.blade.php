@extends('adminlte::page')

@section('title', 'Reservations')

@section('content_header')
    <h1>Reservations</h1>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pending Reservations</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>User</th>
                        <th>Car</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations->where('status', 'pending') as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>{{ $reservation->user->name }}</td>
                            <td>{{ $reservation->car->make }} {{ $reservation->car->model }}</td>
                            <td>{{ $reservation->start_date }}</td>
                            <td>{{ $reservation->end_date }}</td>
                            <td>
                                <form action="{{ route('admin.reservations.accept', $reservation->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Accept
                                    </button>
                                </form>

                                <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Reject
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Reservations</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>User</th>
                        <th>Car</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations->where('status', '!=', 'pending') as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>{{ $reservation->user->name }}</td>
                            <td>{{ $reservation->car->make }} {{ $reservation->car->model }}</td>
                            <td>{{ $reservation->start_date }}</td>
                            <td>{{ $reservation->end_date }}</td>
                            <td>{{ $reservation->status }}</td>
                            <td>
                                <a href="{{ route('admin.reservations.edit', $reservation->id) }}"
                                    class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to cancel this reservation?');">
                                        Delete
                                    </button>
                                </form>

                                @if ($reservation->status === 'returned')
                                    <a href="{{ route('admin.reservations.invoice', ['id' => $reservation->id, 'download' => 1]) }}"
                                        class="btn btn-success btn-sm">Download PDF</a>
                                    <button
                                        onclick="window.open('{{ route('admin.reservations.invoice', $reservation->id) }}', '_blank')"
                                        class="btn btn-primary btn-sm">Print Invoice</button>
                                @else
                                    <button class="btn btn-success btn-sm" disabled>Download Invoice</button>
                                    <button class="btn btn-primary btn-sm" disabled>Print Invoice</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
