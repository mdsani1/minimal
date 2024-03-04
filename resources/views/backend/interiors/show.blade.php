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
            <li class="breadcrumb-item"><a href="{{ route('interiors.index') }}">Items</a></li>
            <li class="breadcrumb-item active">Show</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
<div class="card mb-4">
    <div class="card-header ">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>Items</span>
            <span>
                <a class="btn btn-primary text-left" href="{{ Route('interiors.index') }}" role="button">List</a>
            </span>
        </div>
    </div>
    <div class="card-body">
        <p><b>Work Scope :</b> {{ $interior->category->title ?? '' }}</p>
        <p><b>Zone :</b> {{ $interior->subcategory->title ?? '' }}</p>
        <p><b>Item :</b> {{ $interior->item ?? '' }}</p>
        <p><b>Unit :</b> {{ $interior->unit ?? '' }}</p>
        <p><b>Rate :</b> {{ $interior->Rate ?? '' }}</p>
        <p><b>Length :</b> {{ $interior->length ?? '' }}</p>
        <p><b>Width :</b> {{ $interior->width ?? '' }}</p>
        <p><b>Feet :</b> {{ $interior->feet ?? '' }}</p>
        <p><b>Inche :</b> {{ $interior->inche ?? '' }}</p>
        <p><b>Specification 1 :</b> {{ $interior->specification1 ?? '' }}</p>
        <p><b>Specification 2 :</b> {{ $interior->specification2 ?? '' }}</p>
        <p><b>Specification 3 :</b> {{ $interior->specification3 ?? '' }}</p>

    </div>
</div>

</x-backend.layouts.master>



