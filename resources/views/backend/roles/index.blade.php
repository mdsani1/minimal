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
            <li class="breadcrumb-item"><a style="text-decoration: none; color:#6c757d" href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Roles</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">

            <div class="d-flex justify-content-between">
                <span><i class="fas fa-table me-1"></i>Roles</span>
            </div>
        </div>
        <div class="card-body">
            <x-backend.layouts.elements.message :message="session('message')"/>


            <table id="myTable" class="display table  table-bordered" style="padding-top:20px">
                <thead>
                    <tr>
                        <th style="border-top:1px solid #ddd !important">SL#</th>
                        <th class="text-center" style="border-top:1px solid #ddd !important">Name</th>
                        <th class="text-center" style="border-top:1px solid #ddd !important">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $sl = 0;
                    @endphp
                    @foreach ($roles as $role)
                    <tr>
                        <td>{{ ++$sl }}</td>
                        <td class="text-center">{{ $role->name }}</td>
                        <td class="text-center">
                            <a href="{{ route('roles.show', ['role' => $role->id]) }}" class="btn btn-sm bg-success border-2 border-success" style="border-radius: 50%"><i class="far fa-eye text-white"></i>
                                <div class="legitRipple-ripple" style="left: 55.613%; top: 50.5827%; transform: translate3d(-50%, -50%, 0px); transition-duration: 0.15s, 0.5s; width: 282.962%;">
                                </div>
                            </a>
                            <a class="btn btn-sm btn-warning" href="{{ route('roles.edit',['role' => $role->id]) }}" role="button" style="border-radius: 50%"><i class="fas fa-pen-nib text-white"></i></a>
                            <form style="display: inline;" action="{{ route('roles.destroy', ['role'=>$role->id]) }}" method="POST">
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
            <a class="btn btn-sm btn-success text-left" href="{{ Route('roles.create') }}" role="button" style="border-radius: 50%"><i class="fas fa-plus"></i></a>
        </div>
    </div>

</x-backend.layouts.master>
