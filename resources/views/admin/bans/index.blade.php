{{-- resources/views/admin/bans/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Banned Users Management')

@section('content')
<div class="container-fluid px-4">
    {{-- Header Section with Stats --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h1 class="text-white display-5 fw-bold mb-2">Banned Users</h1>
                            <p class="text-white-50 mb-0 lead">Manage and monitor all banned users in the system</p>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                            <button type="button" class="btn btn-light btn-lg rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#selectUserModal">
                                <i class="bi bi-person-plus-fill me-2"></i>Ban New User
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                                <i class="bi bi-person-x-fill text-danger fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Banned</h6>
                            <h3 class="mb-0 fw-bold">{{ $bannedUsers->total() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                <i class="bi bi-clock-history text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Temporary Bans</h6>
                            <h3 class="mb-0 fw-bold">
                                {{ $bannedUsers->filter(function($user) { return $user->banned_until; })->count() }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-secondary bg-opacity-10 p-3">
                                <i class="bi bi-infinity text-secondary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Permanent Bans</h6>
                            <h3 class="mb-0 fw-bold">
                                {{ $bannedUsers->filter(function($user) { return !$user->banned_until; })->count() }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                <i class="bi bi-people-fill text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Users</h6>
                            <h3 class="mb-0 fw-bold">{{ App\Models\User::count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-white border-0 py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-shield-shaded me-2 text-danger"></i>Banned Users List
                    </h5>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end mt-3 mt-md-0">
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text bg-light border-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control bg-light border-0" id="tableSearch" placeholder="Search in table...">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            @if($bannedUsers->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-shield-check display-1 text-muted"></i>
                    </div>
                    <h5 class="text-muted">No Banned Users Found</h5>
                    <p class="text-muted mb-3">There are currently no banned users in the system.</p>
                    <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#selectUserModal">
                        <i class="bi bi-person-plus me-2"></i>Ban Your First User
                    </button>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="bannedUsersTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="py-3">User</th>
                                <th class="py-3">Email</th>
                                <th class="py-3">Ban Reason</th>
                                <th class="py-3">Duration</th>
                                <th class="py-3">Banned By</th>
                                <th class="py-3">Date</th>
                                <th class="py-3 text-end px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bannedUsers as $user)
                                <tr>
                                    <td class="px-4 fw-semibold">#{{ $user->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-danger bg-opacity-10 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                <span class="text-danger fw-bold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                            </div>
                                            <span class="fw-semibold">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $user->email }}" class="text-decoration-none text-muted">
                                            <i class="bi bi-envelope me-1 small"></i>{{ $user->email }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill" title="{{ $user->ban_reason }}">
                                            {{ Str::limit($user->ban_reason, 30) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->banned_until)
                                            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">
                                                <i class="bi bi-clock me-1"></i>Until {{ $user->banned_until->format('M d, Y') }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">
                                                <i class="bi bi-infinity me-1"></i>Permanent
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->bannedBy)
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs bg-info bg-opacity-10 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 25px; height: 25px;">
                                                    <span class="text-info small fw-bold">{{ strtoupper(substr($user->bannedBy->name, 0, 1)) }}</span>
                                                </div>
                                                <span class="small">{{ $user->bannedBy->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted small">System</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="small text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>{{ $user->updated_at->format('M d, Y') }}
                                        </span>
                                    </td>
                                    <td class="text-end px-4">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('admin.bans.show', $user) }}" class="btn btn-sm btn-outline-info rounded-pill px-3" data-bs-toggle="tooltip" title="View History">
                                                <i class="bi bi-clock-history me-1"></i>History
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#unbanModal{{ $user->id }}" data-bs-toggle="tooltip" title="Unban User">
                                                <i class="bi bi-person-check me-1"></i>Unban
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Unban Modal --}}
                                <div class="modal fade" id="unbanModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-success text-white border-0">
                                                <h5 class="modal-title">
                                                    <i class="bi bi-person-check-fill me-2"></i>Unban User
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.bans.update', $user) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body p-4">
                                                    <div class="text-center mb-4">
                                                        <div class="avatar-lg bg-success bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                            <i class="bi bi-person-up fs-1 text-success"></i>
                                                        </div>
                                                        <h5 class="mb-1">{{ $user->name }}</h5>
                                                        <p class="text-muted small mb-0">{{ $user->email }}</p>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label for="reason{{ $user->id }}" class="form-label fw-semibold">Unban Reason (Optional)</label>
                                                        <textarea class="form-control" id="reason{{ $user->id }}" name="reason" rows="3" placeholder="Enter reason for unbanning..."></textarea>
                                                    </div>

                                                    <div class="alert alert-info bg-opacity-10 border-0" role="alert">
                                                        <i class="bi bi-info-circle-fill me-2"></i>
                                                        This user will be able to access the system again immediately.
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 bg-light">
                                                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                                        <i class="bi bi-x me-1"></i>Cancel
                                                    </button>
                                                    <button type="submit" class="btn btn-success rounded-pill px-4">
                                                        <i class="bi bi-check-lg me-1"></i>Confirm Unban
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <div class="text-muted small">
                        Showing {{ $bannedUsers->firstItem() ?? 0 }} to {{ $bannedUsers->lastItem() ?? 0 }} of {{ $bannedUsers->total() }} entries
                    </div>
                    <div>
                        {{ $bannedUsers->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Select User Modal --}}
<div class="modal fade" id="selectUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title">
                    <i class="bi bi-person-plus-fill me-2"></i>Select User to Ban
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control form-control-lg bg-light border-0" id="searchUsers" placeholder="Search users by name or email...">
                    </div>
                </div>

                <div class="users-list" id="usersList" style="max-height: 400px; overflow-y: auto;">
                    @php
                        $availableUsers = App\Models\User::where('is_banned', false)->orderBy('name')->get();
                    @endphp
                    
                    @forelse($availableUsers as $user)
                        <a href="{{ route('admin.bans.create', $user) }}" class="text-decoration-none">
                            <div class="user-item d-flex justify-content-between align-items-center p-3 mb-2 rounded-3 border" style="transition: all 0.2s;">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-md bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                        <span class="text-primary fw-bold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">{{ $user->name }}</h6>
                                        <p class="mb-0 small text-muted">
                                            <i class="bi bi-envelope me-1"></i>{{ $user->email }}
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-light text-dark me-2 rounded-pill px-3 py-2">ID: {{ $user->id }}</span>
                                    <i class="bi bi-chevron-right text-primary"></i>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-emoji-frown display-1 text-muted"></i>
                            </div>
                            <h5 class="text-muted">No Users Available</h5>
                            <p class="text-muted mb-0">All users are currently banned or no users exist in the system.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x me-1"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Search in table
    document.getElementById('tableSearch')?.addEventListener('keyup', function() {
        let searchValue = this.value.toLowerCase();
        let rows = document.querySelectorAll('#bannedUsersTable tbody tr');
        
        rows.forEach(function(row) {
            let text = row.textContent.toLowerCase();
            if (text.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Search in user selection modal
    document.getElementById('searchUsers')?.addEventListener('keyup', function() {
        let searchValue = this.value.toLowerCase();
        let items = document.querySelectorAll('.user-item');
        
        items.forEach(function(item) {
            let text = item.textContent.toLowerCase();
            if (text.includes(searchValue)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Auto focus search input when modal opens
    document.getElementById('selectUserModal')?.addEventListener('shown.bs.modal', function () {
        document.getElementById('searchUsers').focus();
    });
</script>
@endpush

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .avatar-sm {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-md {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .user-item {
        transition: all 0.2s ease;
        border-color: #e9ecef !important;
    }

    .user-item:hover {
        background-color: #f8f9fa;
        border-color: #667eea !important;
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .table > :not(caption) > * > * {
        padding: 1rem 0.5rem;
    }

    .pagination {
        margin-bottom: 0;
        gap: 5px;
    }

    .page-link {
        border-radius: 8px !important;
        border: none;
        padding: 0.5rem 1rem;
        color: #6c757d;
        transition: all 0.2s;
    }

    .page-link:hover {
        background-color: #667eea;
        color: white;
        transform: translateY(-2px);
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .badge {
        font-weight: 500;
    }

    .modal-content {
        border-radius: 15px;
    }

    .btn-outline-info, .btn-outline-success {
        border-width: 2px;
    }

    .btn-outline-info:hover, .btn-outline-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .table-responsive {
            border-radius: 10px;
        }
        
        .d-flex.gap-2 {
            flex-direction: column;
        }
        
        .btn-sm {
            width: 100%;
        }
    }
</style>
@endpush