<x-backend.layouts.master>
    <x-slot name="page_title">
        Banks 
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Banks 
            </x-slot>
            <x-slot name="add">
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Banks </li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
<div class="card mb-4">
    <div class="card-header ">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>Banks </span>
            <span>
                @if ($banks->count() == 0)
                    <a class="btn btn-sm btn-primary text-left" href="{{ Route('banks.create') }}" role="button">Add</a>
                @endif
            </span>
        </div>
    </div>
    <div class="card-body">
        <x-backend.layouts.elements.message :message="session('message')"/>

        <table id="myTable" class="display table  table-bordered" style="padding-top:20px">
            <thead>
                <tr class="bg-success text-white">
                    <th>SL#</th>
                    <th class="text-center">Bank Name</th>
                    <th class="text-center">Branch Name</th>
                    <th class="text-center">Account Name</th>
                    <th class="text-center">Account Number</th>
                    <th class="text-center">Created By</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sl = 0;
                @endphp
                @foreach ($banks as $bank)
                    <tr>
                        <td>{{ ++$sl }}</td>
                        <td class="text-center">{{ $bank->bank_name ?? '' }}</td>
                        <td class="text-center">{{ $bank->branch_name ?? '' }}</td>
                        <td class="text-center">{{ $bank->account_name ?? '' }}</td>
                        <td class="text-center">{{ $bank->account_number ?? '' }}</td>
                        <td class="text-center">{{ $bank->user->name ?? '' }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-warning" href="{{ route('banks.edit',['bank' => $bank->id]) }}" role="button" style="border-radius: 50%"><i class="fas fa-pen-nib text-white"></i></a>
                            <form style="display: inline;" action="{{ route('banks.destroy', ['bank'=>$bank->id]) }}" method="POST">
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



