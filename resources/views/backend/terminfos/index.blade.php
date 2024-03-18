<x-backend.layouts.master>
    <x-slot name="page_title">
        Term Information
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Term Information
            </x-slot>
            <x-slot name="add">
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Term Information</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
<div class="card mb-4">
    <div class="card-header ">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>Term Information</span>
            <span>
                @if ($terminfos->count() == 0)
                    <a class="btn btn-sm btn-primary text-left" href="{{ Route('terminfos.create') }}" role="button">Add</a>
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
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Designation</th>
                    <th class="text-center">Note</th>
                    <th class="text-center">Created By</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sl = 0;
                @endphp
                @foreach ($terminfos as $terminfo)
                    <tr>
                        <td>{{ ++$sl }}</td>
                        <td class="text-center">{!! $terminfo->name ?? '' !!}</td>
                        <td class="text-center">{{ $terminfo->email ?? '' }}</td>
                        <td class="text-center">{{ $terminfo->designation ?? '' }}</td>
                        <td class="text-center">{{ $terminfo->note ?? '' }}</td>
                        <td class="text-center">{{ $terminfo->user->name ?? '' }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-primary" href="{{ route('terminfos.show', ['terminfo'=>$terminfo->id]) }}" role="button" style="border-radius: 50%"><i class="far fa-eye text-white"></i></a>
                            <a class="btn btn-sm btn-warning" href="{{ route('terminfos.edit',['terminfo' => $terminfo->id]) }}" role="button" style="border-radius: 50%"><i class="fas fa-pen-nib text-white"></i></a>
                            <form style="display: inline;" action="{{ route('terminfos.destroy', ['terminfo'=>$terminfo->id]) }}" method="POST">
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



