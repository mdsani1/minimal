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
            @if(Session::has('message'))
            <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif
        </div>
        <div class="card-body">

            <form action="{{ route('users.update',['user' => $user->id]) }}" method="POST">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" value="{{ $user->name }}" readonly>
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Role</label><br>
                            <select name="role_id" class="form-select">
                                <option value="" style="border: 1px solid #DCDCDC;">Select One</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id==$role->id?'selected':'' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-4 mb-0 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center text-muted">
            <a class="btn btn-info text-white btn-sm" href="{{ Route('users.index') }}" role="button" style="border-radius: 50%"><i class="fas fa-list"></i></a>
        </div>
    </div>

</x-backend.layouts.master>
