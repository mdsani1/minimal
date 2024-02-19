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
            <li class="breadcrumb-item"><a href="{{ route('quotations.index') }}">Quotations</a></li>
            <li class="breadcrumb-item active">Show</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>
    
<div class="card mb-4">
    <div class="card-header ">
        <div class="d-flex justify-content-between">
            <span><i class="fas fa-table me-1"></i>Quotations</span>
            <span>
                <a class="btn btn-primary text-left" href="{{ Route('quotations.index') }}" role="button">List</a>
            </span>
        </div>
    </div>
    <div class="card-body">
        <p><b>Ref:</b> {{ $quotation->ref }}</p>
        <p><b>Name:</b> {{ $quotation->name }}</p>
        <p><b>Address:</b> {{ $quotation->address }}</p>
        <p><b>Date:</b> {{ $quotation->date }}</p>

        <hr>
        <h3>Quotation Items</h3>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Work Scope</th>
                    <th class="text-center">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quotation->quotationItems as $quotationItem)
                    <tr>
                        <td class="text-center">{{ $quotationItem->category->title }}</td>
                        <td class="text-center">{{ $quotationItem->amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</x-backend.layouts.master>



