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
            <li class="breadcrumb-item"><a href="{{ route('terminfos.index') }}">Term Information</a></li>
            <li class="breadcrumb-item active">Show</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
<div class="card mb-4">
    <div class="card-header ">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>Term Information</span>
            <span>
                <a class="btn btn-primary text-left" href="{{ Route('terminfos.index') }}" role="button">List</a>
            </span>
        </div>
    </div>
    <div class="card-body">
        <p><b>Name :</b> {{ $terminfo->name ?? '' }}</p>
        <p><b>Email :</b> {{ $terminfo->email ?? '' }}</p>
        <p><b>Designation :</b> {{ $terminfo->designation ?? '' }}</p>
        <p><b>Note :</b> {{ $terminfo->note ?? '' }}</p>

    </div>
</div>

</x-backend.layouts.master>



