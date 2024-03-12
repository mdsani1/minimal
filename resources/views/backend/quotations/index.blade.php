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
        <x-backend.layouts.elements.errors :errors="$errors"/>


        <table id="myTable" class="display table  table-bordered" style="padding-top:20px">
            <thead>
                <tr class="bg-success text-white">
                    <th>SL#</th>
                    <th class="text-center" style="width: 25%">Ref</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Created By</th>
                    <th class="text-center">Sheet</th>
                    <th class="text-center">To</th>
                    <th class="text-center" style="width: 10%">Action</th>
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
                            (
                            @foreach ($quotation->sheets as $sheet)
                                
                                <a href="{{ route('go-to-sheet-edit', $sheet->id) }}">{{ $sheet->version }} </a>
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                            )
                        </td>
                        <td class="text-center">{{ $quotation->name ?? '' }}</td>
                        <td class="text-center">{{ $quotation->address ?? '' }}</td>
                        <td class="text-center">{{ $quotation->date ?? '' }}</td>
                        <td class="text-center">{{ $quotation->user->name ?? '' }}</td>
                        <td class="text-center d-flex justify-content-center pt-3 pb-3">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle bg-success text-white p-2" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                    All Sheet
                                  </a>
                                  @if (!empty($quotation->sheets))
                                  <div class="dropdown-menu">
                                    @foreach ($quotation->sheets as $sheet)
                                        <a class="dropdown-item" href="{{ route('go-to-sheet-edit', $sheet->id) }}">{{ $sheet->title }}</a>
                                    @endforeach
                                  </div>
                                  @endif
                                </li>
                              </ul>

                              <ul class="navbar-nav mr-auto" style="margin-left:5px">
                                <li class="nav-item dropdown ">
                                    <a class="nav-link dropdown-toggle bg-primary text-white p-2" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                    V <i class="fas fa-copy"></i>
                                    </a>
                                    @if (!empty($quotation->sheets))
                                    <div class="dropdown-menu">
                                    @foreach ($quotation->sheets as $sheet)
                                        <a class="dropdown-item" href="{{ route('version-copy', $sheet->id) }}">{{ $sheet->version }}</a>
                                    @endforeach
                                    </div>
                                    @endif
                                </li>
                            </ul>

                            <ul class="navbar-nav mr-auto" style="margin-left:5px">
                                <li class="nav-item dropdown ">
                                    <a class="nav-link dropdown-toggle bg-warning text-white p-2" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                    Q <i class="fas fa-copy"></i>
                                    </a>
                                    @if (!empty($quotation->sheets))
                                    <div class="dropdown-menu">
                                    @foreach ($quotation->sheets as $sheet)
                                        <a class="dropdown-item" href="{{ route('quotations.duplicate',['id' => $sheet->id]) }}">{{ $sheet->quotation->ref }} ({{ $sheet->version }})</a>
                                    @endforeach
                                    </div>
                                    @endif
                                </li>
                            </ul>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-info text-white m-1" href="{{ route('quotation-to-sheet',['id' => $quotation->id]) }}" role="button">Quotaion To Sheet</a>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-primary" href="{{ route('quotations.show', ['quotation'=>$quotation->id]) }}" role="button" style="border-radius: 50%"><i class="far fa-eye text-white"></i></a>
                            <a class="btn btn-sm btn-warning" href="{{ route('quotations.edit',['quotation' => $quotation->id]) }}" role="button" style="border-radius: 50%"><i class="fas fa-pen-nib text-white"></i></a>
                            <a class="btn btn-sm btn-info text-white" href="{{ route('quotations.pdf',['id' => $quotation->id]) }}" role="button" style="border-radius: 50%"><i class="fas fa-file-pdf"></i></a>
                            {{-- <a class="btn btn-sm btn-success text-white" title="Duplicate" href="{{ route('quotations.duplicate',['id' => $quotation->id]) }}" role="button" style="border-radius: 50%"><i class="fas fa-copy"></i></a> --}}

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



