<x-backend.layouts.master>
    <x-slot name="page_title">
        Nav Items
    </x-slot>
    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Nav Items
            </x-slot>
            <x-slot name="add">
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="text-decoration: none; color:#6c757d">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('navitems.index') }}" style="text-decoration: none; color:#6c757d">Nav Items</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <div class="d-flex justify-content-between">
                <span><i class="fas fa-table me-1"></i>Nav Item Edit</span>
            </div>
        </div>
        <div class="card-body">
            <x-backend.layouts.elements.errors :errors="$errors"/>
            <form action="{{ route('navitems.update', ['navitem' => $navitem->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="row mb-3">

                    <div class="col-md-4 mb-2">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control mt-2" name="title" placeholder="Enter Title" value="{{ old('title', $navitem->title) }}" required>
                            @error("title")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 mb-2">
                        <div class="form-group">
                            <label for="url">Url</label>
                            <input type="text" class="form-control mt-2" name="url" placeholder="Enter Url" value="{{ old('url', $navitem->url) }}" required>
                            @error("url")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 mb-2">
                        <div class="form-group">
                            <label for="icon">Icon</label>
                            <input type="text" class="form-control mt-2" name="icon" placeholder="Enter Icon" value="{{ old('icon', $navitem->icon) }}" required>
                            @error("icon")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 mb-2">
                        <div class="form-group">
                            <label for="position">Position</label>
                            <input type="text" class="form-control mt-2" name="position" placeholder="Enter Position" value="{{ old('position', $navitem->position) }}" required>
                            @error("position")
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
        <div class="card-footer text-center text-muted">
            <a class="btn btn-success text-white btn-sm" href="{{ Route('navitems.index') }}" role="button" style="border-radius: 50%"><i class="fas fa-list"></i></a>
        </div>
    </div>

    @push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
    @endpush

</x-backend.layouts.master>
