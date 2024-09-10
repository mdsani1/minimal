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
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="text-decoration: none; color:#6c757d">Dashboard</a></li>
            <li class="breadcrumb-item active">Users</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <div class="d-flex justify-content-between">
                <span><i class="fas fa-table me-1"></i>Users</span>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-1">
                <form action="{{ route('users.index') }}" method="GET">
                    <div class="d-flex">
                        <select name="role" class="form-select " style="width:220px; border-radius: 50px 0px 0px 50px">
                            <option value="" selected>Select Option</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $role->id==$req?'selected':'' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-success" style="border-radius: 0px 50px 50px 0px"><i class="fas fa-search"></i></button>
                    </div>
                </form>
                <div class="" style="margin-left: 10px">
                    <form action="{{ route('users.index') }}" method="GET">
                        <x-backend.form.search name="search" placeholder="Search" style="width: 220px;" />
                    </form>
                </div>
            </div>

            <x-backend.layouts.elements.message :message="session('message')" />
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>SL#</th>
                        <th class="text-center">Role Name</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $sl = 0;
                    @endphp
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ ++$sl }}</td>
                        <td class="text-center">{{ $user->role->name ?? ''}}</td>
                        <td class="text-center">{{ $user->name }}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-primary" href="{{ route('users.show', ['user'=>$user->id]) }}" role="button" style="border-radius: 50%"><i class="far fa-eye text-white"></i></a>
                            <a class="btn btn-sm btn-warning" href="{{ route('users.edit',['user' => $user->id]) }}" role="button" style="border-radius: 50%"><i class="fas fa-pen-nib text-white"></i></a>
                            <form style="display: inline;" action="{{ route('users.destroy', ['user'=>$user->id]) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button onclick="return confirm('Are you sure want to delete ?')" class="btn btn-sm btn-danger" type="submit" style="border-radius: 50%"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer text-center text-muted">
            {{-- <a class="btn btn-sm btn-danger text-left" href="{{ route('users.trash') }}" role="button" style="border-radius: 50%"><i class="fas fa-trash-restore"></i></a> --}}
            <a class="btn btn-sm btn-primary text-left" href="{{ route('users.excel') }}" role="button" style="border-radius: 50%"><i class="fas fa-file-excel"></i></a>
            <a class="btn btn-sm btn-success text-left" href="register" role="button" style="border-radius: 50%"><i class="fas fa-plus"></i></a>
            <a class="btn btn-sm btn-info text-left" href="{{ route('users.pdf') }}" role="button" style="border-radius: 50%"><i class="fas fa-file-pdf text-white"></i></a>
        </div>
    </div>

</x-backend.layouts.master>
