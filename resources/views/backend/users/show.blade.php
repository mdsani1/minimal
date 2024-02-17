<x-backend.layouts.master>
    <x-slot name="page_title">
        User
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                User
            </x-slot>
            <x-slot name="add">
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="text-decoration: none; color:#6c757d">Dashboard</a></li>
            <li class="breadcrumb-item active">Show</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

<div class="card mb-4">
    <div class="card-header bg-success text-white">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>User</span>
        </div>
    </div>
    <div class="card-body">
            <p>Role Name:{{ $user->role->name ?? '' }}</p>
            <p>Name :{{ $user->name ?? '' }}</p>
            <p>Email :{{ $user->email ?? '' }}</p>
    </div>
    <div class="card-footer text-center text-muted">
        <a class="btn btn-success text-white btn-sm" href="{{ Route('users.index') }}" role="button" style="border-radius: 50%"><i class="fas fa-list"></i></a>
    </div>
</div>

</x-backend.layouts.master>



