<x-backend.layouts.master>
    <x-slot name="page_title">
        Sub Categories
    </x-slot>
    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Sub Categories
            </x-slot>
            <x-slot name="add">  
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Sub Categories</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <div class="card mb-4">
        <div class="card-header ">
            <div class="d-flex justify-content-between">
                <span><i class="fas fa-table me-1"></i>Sub Categories</span>
                <span>
                    <a class="btn btn-primary text-left" href="{{ Route('sub-categories.index') }}" role="button">List</a>
                </span>
            </div>
        </div>
        <div class="card-body">
            <x-backend.layouts.elements.errors :errors="$errors"/>
            <form action="{{ route('sub-categories.update', ['sub_category' => $subcategory->id]) }}" method="POST">
                @csrf
                @method('patch')
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <x-backend.form.select name="category_id" label="Category" :option="$categories" select="{{ $subcategory->category_id }}"/>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control mt-2" name="title" placeholder="Enter Title" value="{{ old('title', $subcategory->title) }}" required>
                            @error("title")
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

</x-backend.layouts.master>