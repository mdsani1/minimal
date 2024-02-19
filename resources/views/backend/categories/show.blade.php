<x-backend.layouts.master>
    <x-slot name="page_title">
        Categories
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Categories
            </x-slot>
            <x-slot name="add">
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
            <li class="breadcrumb-item active">Show</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
<div class="card mb-4">
    <div class="card-header ">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>Categories</span>
            <span>
                <a class="btn btn-primary text-left" href="{{ Route('categories.index') }}" role="button">List</a>
            </span>
        </div>
    </div>
    <div class="card-body">
        @if (isset($category->subcategory))
        <table id="" class="display table  table-bordered" style="padding-top:20px">
            <thead>
                <tr class="bg-success text-white">
                    <th>SL#</th>
                    <th class="text-center">Title</th>
                    <th class="text-center">Sub Category</th>
                </tr>
            </thead>
            <tbody>
            </tbody>      
            @foreach ($category->subcategory as $subcategory)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $subcategory->category->title }}</td>
                    <td class="text-center">{{ $subcategory->title }}</td>
                </tr>
            @endforeach
        </table>
        @endif
    </div>
</div>

</x-backend.layouts.master>



