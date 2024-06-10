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
                    <hr>
                    <h4>Quotation : {{ $quotation->ref }}</h4>
                    <h4>Category : {{ $category->title }}</h4>

                    <table id="dynamic-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th class="text-center">Zone</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $quotationZoneSubCategoryIds = collect($quotationZoneManage)->pluck('sub_category_id')->all();
                            @endphp

                            @foreach ($category->subcategory as $subcategory)
                                @if (!in_array($subcategory->id, $quotationZoneSubCategoryIds))
                                    <tr>
                                        <td class="text-center sl">1</td>
                                        <td class="text-center" style="width: 75%">
                                            <input type="text" class="form-control mt-2" name="title" placeholder="Enter Title" value="{{ old('title', $subcategory->title) }}" readonly>
                                        </td>
                                        <td class="text-center" style="width: 20%">
                                            <a href="{{ route('quotations-zone-manage.delete', [$quotation->id, $category->id, $subcategory->id]) }}" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>

                    <hr>
                    <h4>Delete Zone</h4>
                    <table id="dynamic-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th class="text-center">Zone</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quotationZoneManage as $value)
                            <tr>
                                <td class="text-center sl">1</td>
                                <td class="text-center" style="width: 75%">
                                    <input type="text" class="form-control mt-2" name="title" placeholder="Enter Title" value="{{ old('title', $value->subcategory->title) }}" readonly>
                                </td>
                                <td class="text-center" style="width: 20%">
                                    <a href="{{ route('quotations-zone-manage.restore', $value->id) }}" class="btn btn-danger" ><i class="fas fa-trash-alt"></i></a>
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