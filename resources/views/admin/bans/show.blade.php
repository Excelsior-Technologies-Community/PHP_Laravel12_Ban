{{-- resources/views/admin/bans/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Ban History - ' . $user->name)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Ban History for {{ $user->name }}</h3>
            </div>
            <div class="card-body">
                @if($banHistory->isEmpty())
                    <p class="text-center">No ban history found for this user.</p>
                @else
                    <div class="timeline">
                        @foreach($banHistory as $history)
                            <div class="card mb-3 @if(!$history->unbanned_at) border-danger @endif">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Ban Event #{{ $loop->iteration }}
                                        @if(!$history->unbanned_at)
                                            <span class="badge bg-danger float-end">Active Ban</span>
                                        @endif
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Banned By:</strong> {{ $history->bannedBy->name ?? 'Unknown' }}</p>
                                            <p><strong>Banned At:</strong> {{ $history->banned_at->format('Y-m-d H:i:s') }}</p>
                                            <p><strong>Ban Until:</strong> {{ $history->ban_until ? $history->ban_until->format('Y-m-d H:i:s') : 'Permanent' }}</p>
                                            <p><strong>Reason:</strong> {{ $history->ban_reason }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            @if($history->unbanned_at)
                                                <p><strong>Unbanned By:</strong> {{ $history->unbannedBy->name ?? 'Unknown' }}</p>
                                                <p><strong>Unbanned At:</strong> {{ $history->unbanned_at->format('Y-m-d H:i:s') }}</p>
                                                <p><strong>Unban Reason:</strong> {{ $history->unban_reason ?? 'No reason provided' }}</p>
                                            @else
                                                <p class="text-danger"><strong>Status:</strong> User is currently banned</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                
                <a href="{{ route('admin.bans.index') }}" class="btn btn-primary">Back to Banned Users</a>
            </div>
        </div>
    </div>
</div>
@endsection