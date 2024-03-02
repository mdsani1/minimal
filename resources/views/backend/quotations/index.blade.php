<x-backend.layouts.master>
    <x-slot name="page_title">
        Quotations
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Quotations
            </x-slot>
            <x-slot name="add">
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Quotations</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
<div class="card mb-4">
    <div class="card-header ">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>Quotations</span>
            <span>
                <a class="btn btn-sm btn-primary text-left" href="{{ Route('quotations.create') }}" role="button">Add</a>
                <a class="btn btn-sm btn-danger text-left" href="{{ route('quotations.trash') }}" role="button">Trash</a>
            </span>
        </div>
    </div>
    <div class="card-body">
        <x-backend.layouts.elements.message :message="session('message')"/>

        <table id="myTable" class="display table  table-bordered" style="padding-top:20px">
            <thead>
                <tr class="bg-success text-white">
                    <th>SL#</th>
                    <th class="text-center">Ref</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Created By</th>
                    <th class="text-center">Sheet</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sl = 0;
                @endphp
                @foreach ($quotations as $quotation)
                    <tr>
                        <td>{{ ++$sl }}</td>
                        <td class="text-center">{{ $quotation->ref ?? '' }}</td>
                        <td class="text-center">{{ $quotation->name ?? '' }}</td>
                        <td class="text-center">{{ $quotation->address ?? '' }}</td>
                        <td class="text-center">{{ $quotation->date ?? '' }}</td>
                        <td class="text-center">{{ $quotation->user->name ?? '' }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-info text-white" href="{{ route('editableTable',['id' => $quotation->id]) }}" role="button">Quotaion To Sheet</a>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-primary" href="{{ route('quotations.show', ['quotation'=>$quotation->id]) }}" role="button" style="border-radius: 50%"><i class="far fa-eye text-white"></i></a>
                            <a class="btn btn-sm btn-warning" href="{{ route('quotations.edit',['quotation' => $quotation->id]) }}" role="button" style="border-radius: 50%"><i class="fas fa-pen-nib text-white"></i></a>
                            <a class="btn btn-sm btn-info text-white" href="{{ route('quotations.pdf',['id' => $quotation->id]) }}" role="button" style="border-radius: 50%"><i class="fas fa-file-pdf"></i></a>
                            <form style="display: inline;" action="{{ route('quotations.destroy', ['quotation'=>$quotation->id]) }}" method="POST">
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



