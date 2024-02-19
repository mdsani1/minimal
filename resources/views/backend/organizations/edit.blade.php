<x-backend.layouts.master>
    <x-slot name="page_title">
        Organizations
    </x-slot>
    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Organizations
            </x-slot>
            <x-slot name="add">  
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('organizations.index') }}">Organizations</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <div class="card mb-4">
        <div class="card-header ">
            <div class="d-flex justify-content-between">
                <span><i class="fas fa-table me-1"></i>Organizations</span>
                <span>
                    <a class="btn btn-primary text-left" href="{{ Route('organizations.index') }}" role="button">List</a>
                </span>
            </div>
        </div>
        <div class="card-body">
            <x-backend.layouts.elements.errors :errors="$errors"/>
            <form action="{{ route('organizations.update', ['organization' => $organization->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="row mb-3">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="phone">Phone *</label>
                            <input type="text" class="form-control mt-2" name="phone" placeholder="Enter Phone" value="{{ old('phone', $organization->phone) }}" required>
                            @error("phone")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="text" class="form-control mt-2" name="email" placeholder="Enter Email" value="{{ old('email', $organization->email) }}" required>
                            @error("email")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="facebook">Facebook *</label>
                            <input type="text" class="form-control mt-2" name="facebook" placeholder="Enter Facebook" value="{{ old('facebook', $organization->facebook) }}" required>
                            @error("facebook")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="text" class="form-control mt-2" name="website" placeholder="Enter Website" value="{{ old('website', $organization->website) }}">
                            @error("website")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control mt-2" name="image" placeholder="Enter Image" value="{{ old('image') }}">
                            @error("image")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Address *</label>
                            <textarea class="form-control mt-2" name="address" placeholder="Address" cols="30" rows="6" id="mytextarea">{!! $organization->address !!}</textarea>
                            @error("description")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4 mb-0 d-flex justify-content-end">
                    <button onclick="return confirm('Are you sure want to update ?')" type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script src="https://cdn.tiny.cloud/1/3dymgiuzyi2o390gh5jgcv47chk7fkpd04eci1k99gdwoai7/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            // Initialize TinyMCE
            tinymce.init({
            selector: '#mytextarea',  // CSS selector of textarea element
            plugins: 'advlist autolink lists link image charmap print preview anchor',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image',
            height: 400 // Set a height for the editor
            });
        </script>
    @endpush

</x-backend.layouts.master>