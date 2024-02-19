<x-backend.layouts.master>
    <x-slot name="page_title">
        Interiors
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Interiors
            </x-slot>
            <x-slot name="add">
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('interiors.index') }}">Interiors</a></li>
                <li class="breadcrumb-item active">Trash</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
<div class="card mb-4">
    <div class="card-header ">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>Interiors</span>
            <span>
                <a class="btn btn-primary text-left" href="{{ route('interiors.index') }}" role="button">List</a>
            </span>
        </div>
    </div>
    <div class="card-body">
        <x-backend.layouts.elements.message :message="session('message')"/>
        <table id="myTable" class="display table  table-bordered" style="padding-top:20px">
            <thead>
                <tr class="bg-success text-white">
                    <th>SL#</th>
                    <th class="text-center">Category</th>
                    <th class="text-center">Sub Category</th>
                    <th class="text-center">Item</th>
                    <th class="text-center">Unit</th>
                    <th class="text-center">Rate</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                    @php
                        $sl = 0;
                    @endphp
                    @foreach ($interiors as $interior)
                    <tr>
                        <td>{{ ++$sl }}</td>
                        <td class="text-center">{{ $interior->category->title ?? '' }}</td>
                        <td class="text-center">{{ $interior->subcategory->title ?? '' }}</td>
                        <td class="text-center">{{ $interior->item ?? '' }}</td>
                        <td class="text-center">{{ $interior->unit ?? '' }}</td>
                        <td class="text-center">{{ $interior->rate ?? '' }}</td>
                        <td class="text-center">
                            <a onclick="return confirm('Are you sure want to restore ?')" class="btn btn-sm btn-primary mb-1" href="{{ route('interiors.restore', ['interior' => $interior->id]) }}" role="button">Restore</a>
                            <a onclick="return confirm('Are you sure want to permanentdelete ?')" class="btn btn-sm btn-danger" href="{{ route('interiors.delete', ['interior' => $interior->id]) }}" role="button">Permanent Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</x-backend.layouts.master>



