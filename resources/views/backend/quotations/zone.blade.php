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
            <li class="breadcrumb-item active">Edit</li>
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
            <x-backend.layouts.elements.errors :errors="$errors"/>
            <div class="row mb-3">

                
                <div class="col-md-12 mt-3">
                    <h2>{{ $quotation->ref }}</h2>
                    <table id="dynamic-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th class="text-center">Work Scope</th>
                                {{-- <th class="text-center">Amount</th> --}}
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quotation->quotationItems as $quotationItem)
                            <tr>
                                <input type="hidden" name="quotationItemId[]" value="{{ $quotationItem->id }}">
                                <td class="text-center sl">1</td>
                                <td class="text-center" style="width: 75%">
                                    <select data-placeholder="{{ ('please Select') }}" name="work_scope[]" value="{{ old('work_scope') }}" class="form-control work_scope mt-2">
                                        <option value="">Please Select</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $quotationItem->work_scope ? 'selected' : '' }}>{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="text-center" style="width: 20%">
                                    <a href="{{ route('quotations-zone-manage', [$quotation->id, $quotationItem->work_scope]) }}" class="btn btn-success">Zone</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    @push('css')
        <style>
            .select2-container {
                margin-top: 10px;
            }
            .select2-container--default .select2-selection--single {
                height: 36px;
            }
            .select2-container .select2-selection--single .select2-selection__rendered {
                padding-top: 2px;
            }
        </style>
    @endpush

    @push('js')
    <script>
        $(document).ready(function () {
            $('.work_scope').prop("disabled", true);
        });
    </script>
    @endpush

</x-backend.layouts.master>