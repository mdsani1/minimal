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
            <li class="breadcrumb-item"><a href="{{ route('organizations.index') }}">Organizations</a></li>
            <li class="breadcrumb-item active">Show</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
<div class="card mb-4">
    <div class="card-header ">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>Organizations</span>
            <span>
                <a class="btn btn-primary text-left" href="{{ Route('organizations.index') }}" role="button">List</a>
            </span>
        </div>
    </div>
    <div class="card-body">
        <p><b>Address :</b> {!! $organization->address ?? '' !!}</p>
        <p><b>Phone :</b> {{ $organization->phone ?? '' }}</p>
        <p><b>Email :</b> {{ $organization->email ?? '' }}</p>
        <p><b>Facebook :</b> {{ $organization->facebook ?? '' }}</p>
        <p><b>Website :</b> {{ $organization->website ?? '' }}</p>
        <p><b>Image :</b> <img src="{{ asset('backend/images/organization/'.$organization->image ?? '') }}" alt="image"></p>

    </div>
</div>

</x-backend.layouts.master>



