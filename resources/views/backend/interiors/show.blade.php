<x-backend.layouts.master>
    <x-slot name="page_title">
        Interiors
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Interiors
            </x-slot>
            <x-slot name="add">
            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('interiors.index') }}">Interiors</a></li>
            <li class="breadcrumb-item active">Show</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
<div class="card mb-4">
    <div class="card-header ">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>Interiors</span>
            <span>
                <a class="btn btn-primary text-left" href="{{ Route('interiors.index') }}" role="button">List</a>
            </span>
        </div>
    </div>
    <div class="card-body">
        <p><b>Category :</b> {{ $interior->category->title ?? '' }}</p>
        <p><b>Sub Category :</b> {{ $interior->subcategory->title ?? '' }}</p>
        <p><b>Item :</b> {{ $interior->item ?? '' }}</p>
        <p><b>Unit :</b> {{ $interior->unit ?? '' }}</p>
        <p><b>Rate :</b> {{ $interior->Rate ?? '' }}</p>
        <p><b>Length :</b> {{ $interior->length ?? '' }}</p>
        <p><b>Width :</b> {{ $interior->width ?? '' }}</p>
        <p><b>Height :</b> {{ $interior->height ?? '' }}</p>
        <p><b>Detail :</b> {{ $interior->default_detail ?? '' }}</p>

    </div>
</div>

</x-backend.layouts.master>



