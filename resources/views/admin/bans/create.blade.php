{{-- resources/views/admin/bans/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Ban User')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Ban User: {{ $user->name }} (ID: {{ $user->id }})</div>

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.bans.store', ['user' => $user->id]) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="reason" class="form-label">Ban Reason</label>
                        <textarea class="form-control @error('reason') is-invalid @enderror" 
                                  id="reason" name="reason" rows="3" required>{{ old('reason') }}</textarea>
                        @error('reason')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ban_until" class="form-label">Ban Until (Leave empty for permanent ban)</label>
                        <input type="datetime-local" class="form-control @error('ban_until') is-invalid @enderror" 
                               id="ban_until" name="ban_until" value="{{ old('ban_until') }}">
                        @error('ban_until')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">Format: YYYY-MM-DD HH:MM</small>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-danger">Ban User</button>
                        <a href="{{ route('admin.bans.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection