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
            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}" style="text-decoration: none; color:#6c757d">Roles</a></li>
            <li class="breadcrumb-item active">Create</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">

            <div class="d-flex justify-content-between">
                <span><i class="fas fa-table me-1"></i>Role Create</span>
            </div>
        </div>
        <div class="card-body">
            <x-backend.layouts.elements.errors :errors="$errors"/>
            <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <label for="name">Role</label>
                            <input type="text" class="form-control mt-2" name="name" placeholder="Enter Role Name" value="{{ old('name') }}" required>
                            @error("name")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4 mb-0 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center text-muted">
            <a class="btn btn-success text-white btn-sm" href="{{ Route('roles.index') }}" role="button" style="border-radius: 50%"><i class="fas fa-list"></i></a>
        </div>
    </div>

</x-backend.layouts.master>
