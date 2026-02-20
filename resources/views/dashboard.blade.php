{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Dashboard</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <h3>Welcome, {{ auth()->user()->name }}!</h3>
                <p>You are logged in successfully.</p>
                
                @if(auth()->user()->is_admin)
                    <div class="alert alert-info">
                        You are an admin. <a href="{{ route('admin.bans.index') }}" class="alert-link">Go to Ban Management</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection