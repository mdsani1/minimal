<x-backend.layouts.master>
    <x-slot name="page_title">
        Users
    </x-slot>
    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Users
            </x-slot>
            <x-slot name="add">
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Users</a></li>
                <li class="breadcrumb-item active">Trash</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
<div class="card mb-4">
    <div class="card-header ">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>Users</span>
            <span>
                <a class="btn btn-primary text-left" href="{{ route('users.index') }}" role="button">List</a>
            </span>
        </div>
    </div>
    <div class="card-body">
        <x-backend.layouts.elements.message :message="session('message')"/>
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>SL#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                    @php
                        $sl = 0;
                    @endphp
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ ++$sl }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a onclick="return confirm('Are you sure want to restore ?')" class="btn btn-sm btn-primary mb-1" href="{{ route('users.restore', ['user' => $user->id]) }}" role="button">Restore</a>
                            <a onclick="return confirm('Are you sure want to permanentdelete ?')" class="btn btn-sm btn-danger" href="{{ route('users.delete', ['user' => $user->id]) }}" role="button">Permanent Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</x-backend.layouts.master>



