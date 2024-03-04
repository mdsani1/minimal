<x-backend.layouts.master>
    <x-slot name="page_title">
        Items
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Items
            </x-slot>
            <x-slot name="add">
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Items</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
<div class="card mb-4">
    <div class="card-header ">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>Items</span>
            <span>
                <a class="btn btn-sm btn-primary text-left" href="{{ Route('interiors.create') }}" role="button">Add</a>
                <a class="btn btn-sm btn-danger text-left" href="{{ route('interiors.trash') }}" role="button">Trash</a>
                <a class="btn btn-sm btn-info text-left" href="{{ route('interiors.excel') }}" role="button">Excel</a>
                <a class="btn btn-sm btn-info text-left" href="{{ route('interiors.pdf') }}" role="button">Pdf</a>
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
                    <th class="text-center">Created By</th>
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
                        <td class="text-center">{{ $interior->user->name ?? '' }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-primary" href="{{ route('interiors.show', ['interior'=>$interior->id]) }}" role="button" style="border-radius: 50%"><i class="far fa-eye text-white"></i></a>
                            <a class="btn btn-sm btn-warning" href="{{ route('interiors.edit',['interior' => $interior->id]) }}" role="button" style="border-radius: 50%"><i class="fas fa-pen-nib text-white"></i></a>
                            <form style="display: inline;" action="{{ route('interiors.destroy', ['interior'=>$interior->id]) }}" method="POST">
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



