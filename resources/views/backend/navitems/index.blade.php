<x-backend.layouts.master>
    <x-slot name="page_title">
        Nav Items
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Nav Items
            </x-slot>
            <x-slot name="add">
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="text-decoration: none; color:#6c757d">Dashboard</a></li>
                <li class="breadcrumb-item active">Nav Items</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

<div class="card mb-4">
    <div class="card-header bg-success text-white">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>Nav Items</span>
        </div>
    </div>
    <div class="card-body">
        <x-backend.layouts.elements.message :message="session('message')"/>

        <table id="myTable" class="display table  table-bordered" style="padding-top:20px">
            <thead>
                <tr class="bg-success text-white">
                    <th>SL#</th>
                    <th class="text-center">Title</th>
                    <th class="text-center">Url</th>
                    <th class="text-center">Icon</th>
                    <th class="text-center">Position</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sl = 0;
                @endphp
                @foreach ($navitems as $navitem)
                    <tr>
                        <td>{{ ++$sl }}</td>
                        <td class="text-center">{{ $navitem->title }}</td>
                        <td class="text-center">{{ $navitem->url }}</td>
                        <td class="text-center">{!! $navitem->icon !!}</td>
                        <td class="text-center">{{ $navitem->position }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-warning" href="{{ route('navitems.edit',['navitem' => $navitem->id]) }}" role="button" style="border-radius: 50%"><i class="fas fa-pen-nib text-white"></i></a>
                            <form style="display: inline;" action="{{ route('navitems.destroy', ['navitem'=>$navitem->id]) }}" method="POST">
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
    <div class="card-footer text-center text-muted">
        <a class="btn btn-sm btn-success text-left" href="{{ Route('navitems.create') }}" role="button" style="border-radius: 50%"><i class="fas fa-plus"></i></a>
    </div>
</div>

</x-backend.layouts.master>



