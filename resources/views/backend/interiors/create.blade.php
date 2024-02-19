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
            <li class="breadcrumb-item active">Create</li>
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
            <x-backend.layouts.elements.errors :errors="$errors"/>
            <form action="{{ route('interiors.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="item">Category *</label>
                            <select class="form-control mt-2" name="category_id" id="category_id" required>
                                <option value="">Please Select</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                            @error("item")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sub_category_id">Sub Category</label>
                            <select data-placeholder="{{ ('please Select') }}" name="sub_category_id" value="{{ old('sub_category_id') }}"  id="sub_category_id" class="form-control mt-2">
                                <option value="">Please Select</option>
                            </select>
                            @error("sub_category_id")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="item">Item *</label>
                            <input type="text" class="form-control mt-2" name="item" placeholder="Enter Item" value="{{ old('item') }}" required>
                            @error("item")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="unit">Unit *</label>
                            <input type="text" class="form-control mt-2" name="unit" placeholder="Enter Unit" value="{{ old('unit') }}" required>
                            @error("unit")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="rate">Rate *</label>
                            <input type="text" class="form-control mt-2" name="rate" placeholder="Enter Rate" value="{{ old('rate') }}" required>
                            @error("rate")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="length">Length</label>
                            <input type="text" class="form-control mt-2" name="length" placeholder="Enter Length" value="{{ old('length') }}">
                            @error("length")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="width">Width</label>
                            <input type="text" class="form-control mt-2" name="width" placeholder="Enter Width" value="{{ old('width') }}">
                            @error("width")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="height">Height</label>
                            <input type="text" class="form-control mt-2" name="height" placeholder="Enter Height" value="{{ old('height') }}">
                            @error("height")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Detail *</label>
                            <textarea class="form-control mt-2" name="default_detail" id="" cols="30" rows="10"></textarea>
                            @error("description")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4 mb-0 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
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
                $('select').select2();
                $(document).on('change', '#category_id', loadSubCategory);
                $("#sub_category_id").prop('disabled', true);
            });

            function loadSubCategory()
            {
                $("#sub_category_id").prop('disabled', true);
                $("#sub_category_id").empty();
                $("#sub_category_id").html(`<option value="">Please Select</option>`);

                let category_id      = $('#category_id').val();

                if(category_id != null){
                    $.ajax({
                        url      : `/api/get-sub-category/${$('#category_id').val()}`,
                        method   : "GET",
                        dataType : "JSON",
                        success     : function (res)
                        {
                            $("#sub_category_id").select2({
                                data: res,
                                placeholder: "Please Select",
                                allowClear: true
                            })
                            $("#sub_category_id").prop('disabled', false);
                        },
                        error(err){
                            $("#sub_category_id").select2({
                                data: ""
                            });
                            $("#sub_category_id").prop('disabled', true);
                        }
                    }); 
                }
            }
        </script>
    @endpush

</x-backend.layouts.master>