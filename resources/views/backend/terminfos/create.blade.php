<x-backend.layouts.master>
    <x-slot name="page_title">
        Term Information
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Term Information
            </x-slot>
            <x-slot name="add">
                
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('terminfos.index') }}">Term Information</a></li>
            <li class="breadcrumb-item active">Create</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <div class="card mb-4">
        <div class="card-header ">
            
            <div class="d-flex justify-content-between">
                <span><i class="fas fa-table me-1"></i>Term Information</span>
                <span>
                    <a class="btn btn-primary text-left" href="{{ Route('terminfos.index') }}" role="button">List</a>
                </span>
            </div>
        </div>
        <div class="card-body">
            <x-backend.layouts.elements.errors :errors="$errors"/>
            <form action="{{ route('terminfos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control mt-2" name="name" placeholder="Enter Name" value="{{ old('name') }}" required>
                            @error("name")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control mt-2" name="email" placeholder="Enter Email" value="{{ old('email') }}">
                            @error("email")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="designation">Designation *</label>
                            <input type="text" class="form-control mt-2" name="designation" placeholder="Enter Designation" value="{{ old('designation') }}" required>
                            @error("designation")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="note">Note *</label>
                            <textarea class="form-control mt-2" name="note" placeholder="Note" cols="30" rows="6"></textarea>
                            @error("note")
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
    </div>

    @push('js')
        <script src="https://cdn.tiny.cloud/1/3dymgiuzyi2o390gh5jgcv47chk7fkpd04eci1k99gdwoai7/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @endpush

</x-backend.layouts.master>