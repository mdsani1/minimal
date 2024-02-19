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
            <li class="breadcrumb-item active">Show</li>
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
        <p><b>Title : </b> {{ $subcategory->title }}</p>
    </div>
</div>

</x-backend.layouts.master>



