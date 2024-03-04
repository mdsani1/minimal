<x-backend.layouts.master>
    <x-slot name="page_title">
        Work Scope 
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Work Scope 
            </x-slot>
            <x-slot name="add">
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Work Scope </a></li>
                <li class="breadcrumb-item active">Trash</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
<div class="card mb-4">
    <div class="card-header ">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>Work Scope </span>
            <span>
                <a class="btn btn-primary text-left" href="{{ route('categories.index') }}" role="button">List</a>
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
                        <td class="text-center">{{ $category->title }}</td>
                        <td class="text-center">{{ $category->description }}</td>
                        <td class="text-center">
                            <a onclick="return confirm('Are you sure want to restore ?')" class="btn btn-sm btn-primary mb-1" href="{{ route('categories.restore', ['category' => $category->id]) }}" role="button">Restore</a>
                            <a onclick="return confirm('Are you sure want to permanentdelete ?')" class="btn btn-sm btn-danger" href="{{ route('categories.delete', ['category' => $category->id]) }}" role="button">Permanent Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</x-backend.layouts.master>



