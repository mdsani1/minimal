<x-backend.layouts.master>
    <x-slot name="page_title">
        Roles
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Roles
            </x-slot>
            <x-slot name="add">

            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="text-decoration: none; color:#6c757d">Dashboard</a></li>
            <li class="breadcrumb-item active">Roles</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

<div class="card mb-4">
    <div class="card-header bg-success text-white">

        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>{{ $role->name }}</span>
        </div>
    </div>
    <div class="card-body">
        <table class="table border">
            <thead>
                <tr>
                    <th>SL#</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($role->users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer text-center text-muted">
        <a class="btn btn-info text-white    text-left btn-sm" href="{{ Route('roles.index') }}" role="button" style="border-radius: 50%"><i class="fas fa-list"></i></a>
    </div>
</div>

</x-backend.layouts.master>



