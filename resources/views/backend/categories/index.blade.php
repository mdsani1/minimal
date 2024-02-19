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
                <li class="breadcrumb-item active">Categories</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
<div class="card mb-4">
    <div class="card-header ">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>Categories</span>
            <span>
                <a class="btn btn-sm btn-primary text-left" href="{{ Route('categories.create') }}" role="button">Add</a>
                <a class="btn btn-sm btn-danger text-left" href="{{ route('categories.trash') }}" role="button">Trash</a>
                <a class="btn btn-sm btn-info text-left" href="{{ route('categories.excel') }}" role="button">Excel</a>
                <a class="btn btn-sm btn-info text-left" href="{{ route('categories.pdf') }}" role="button">Pdf</a>
            </span>
        </div>
    </div>
    <div class="card-body">
        <x-backend.layouts.elements.message :message="session('message')"/>

        <table id="myTable" class="display table  table-bordered" style="padding-top:20px">
            <thead>
                <tr class="bg-success text-white">
                    <th>SL#</th>
                    <th class="text-center">Title</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Created By</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sl = 0;
                @endphp
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ ++$sl }}</td>
                        <td class="text-center">{{ $category->title ?? '' }}</td>
                        <td class="text-center">{{ $category->description ?? '' }}</td>
                        <td class="text-center">{{ $category->user->name ?? '' }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-primary" href="{{ route('categories.show', ['category'=>$category->id]) }}" role="button" style="border-radius: 50%"><i class="far fa-eye text-white"></i></a>
                            <a class="btn btn-sm btn-warning" href="{{ route('categories.edit',['category' => $category->id]) }}" role="button" style="border-radius: 50%"><i class="fas fa-pen-nib text-white"></i></a>
                            <form style="display: inline;" action="{{ route('categories.destroy', ['category'=>$category->id]) }}" method="POST">
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
</div>

</x-backend.layouts.master>



