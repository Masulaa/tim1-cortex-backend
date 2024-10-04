@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $userToEdit->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $userToEdit->email }}"
                        placeholder="Enter new email">
                </div>

                <div class="form-group">
                    <label for="password">New Password:</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Enter new password (leave blank to keep current)">
                </div>

                <button type="submit" class="btn btn-primary">Update User</button>
            </form>

            <form action="{{ route('admin.users.setadmin', $userToEdit->id) }}" method="POST" style="margin-top: 10px;">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm" @if ($userToEdit->is_admin) disabled @endif>Set
                    to Admin</button>
            </form>
            <form action="{{ route('admin.users.removeadmin', $userToEdit->id) }}" method="POST" style="margin-top: 10px;">
                @csrf
                <button type="submit" class="btn btn-warning btn-sm"
                    @unless ($userToEdit->is_admin) disabled @endunless>Remove Admin</button>
            </form>
        </div>
    </div>
@stop
