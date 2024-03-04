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
                        <td class="text-center">
                            {{ $quotation->ref ?? '' }} <br>
                            ( V1.0 
                            @foreach ($quotation->changeHistories as $item)
                                , {{ $item->version }}
                            @endforeach
                            )
                        </td>
                        <td class="text-center">{{ $quotation->name ?? '' }}</td>
                        <td class="text-center">{{ $quotation->address ?? '' }}</td>
                        <td class="text-center">{{ $quotation->date ?? '' }}</td>
                        <td class="text-center">{{ $quotation->user->name ?? '' }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-info text-white m-1" href="{{ route('editableTable',['id' => $quotation->id]) }}" role="button">Quotaion To Sheet</a>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop{{ $quotation->id }}">
                                Change Histories
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop{{ $quotation->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Change Histories</h5>
                                    <button class="btn" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('change-histories', $quotation->id) }}" method="post">
                                            @csrf
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 50%">Version</th>
                                                        <th class="text-center" style="width: 50%">Change</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="version" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="change" class="form-control">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-success">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-primary" href="{{ route('quotations.show', ['quotation'=>$quotation->id]) }}" role="button" style="border-radius: 50%"><i class="far fa-eye text-white"></i></a>
                            <a class="btn btn-sm btn-warning" href="{{ route('quotations.edit',['quotation' => $quotation->id]) }}" role="button" style="border-radius: 50%"><i class="fas fa-pen-nib text-white"></i></a>
                            <a class="btn btn-sm btn-info text-white" href="{{ route('quotations.pdf',['id' => $quotation->id]) }}" role="button" style="border-radius: 50%"><i class="fas fa-file-pdf"></i></a>
                            <a class="btn btn-sm btn-success text-white" title="Duplicate" href="{{ route('quotations.duplicate',['id' => $quotation->id]) }}" role="button" style="border-radius: 50%"><i class="fas fa-copy"></i></a>

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

@push('css')
    <style>
        .modal.show .modal-dialog {
            max-width: 60%;
        }
    </style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
@endpush

</x-backend.layouts.master>



