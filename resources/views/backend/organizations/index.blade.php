<x-backend.layouts.master>
    <x-slot name="page_title">
        Organizations
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Organizations
            </x-slot>
            <x-slot name="add">
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Organizations</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
<div class="card mb-4">
    <div class="card-header ">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>Organizations</span>
            <span>
                @if ($organizations->count() == 0)
                    <a class="btn btn-sm btn-primary text-left" href="{{ Route('organizations.create') }}" role="button">Add</a>
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
                    <th class="text-center">Address</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">website</th>
                    <th class="text-center">Created By</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sl = 0;
                @endphp
                @foreach ($organizations as $organization)
                    <tr>
                        <td>{{ ++$sl }}</td>
                        <td class="text-center">{!! $organization->address ?? '' !!}</td>
                        <td class="text-center">{{ $organization->phone ?? '' }}</td>
                        <td class="text-center">{{ $organization->email ?? '' }}</td>
                        <td class="text-center">{{ $organization->website ?? '' }}</td>
                        <td class="text-center">{{ $organization->user->name ?? '' }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-primary" href="{{ route('organizations.show', ['organization'=>$organization->id]) }}" role="button" style="border-radius: 50%"><i class="far fa-eye text-white"></i></a>
                            <a class="btn btn-sm btn-warning" href="{{ route('organizations.edit',['organization' => $organization->id]) }}" role="button" style="border-radius: 50%"><i class="fas fa-pen-nib text-white"></i></a>
                            <form style="display: inline;" action="{{ route('organizations.destroy', ['organization'=>$organization->id]) }}" method="POST">
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



