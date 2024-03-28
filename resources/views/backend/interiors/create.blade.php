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
            <li class="breadcrumb-item active">Create</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <div class="card mb-4">
        <div class="card-header ">
            
            <div class="d-flex justify-content-between">
                <span><i class="fas fa-table me-1"></i>Items</span>
                <span>
                    <a class="btn btn-primary text-left" href="{{ Route('interiors.index') }}" role="button">List</a>
                    <button type="button" class="btn btn-info text-left text-white" id="addSpecification">Add Specification</button>
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
                            <label for="item">Work Scope *</label>
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
                            <label for="sub_category_id">Zone</label>
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
                            <select class="form-control mt-2" name="unit" id="" required>
                                <option value="">Please Select</option>
                                <option value="sft">sft</option>
                                <option value="nos">nos</option>
                                <option value="job">job</option>
                                <option value="rft">rft</option>
                                <option value="mtr">mtr</option>
                                <option value="lumpsum">lumpsum</option>
                            </select>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="length_feet">Length</label>
                                    <input type="text" class="form-control mt-2" name="length_feet" placeholder="Enter Feet" value="{{ old('length_feet') }}">
                                    @error("length_feet")
                                        <span class="sm text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="length_inche"></label>
                                    <input type="text" class="form-control mt-2" name="length_inche" placeholder="Enter Inches" value="{{ old('length_inche') }}">
                                    @error("length_inche")
                                        <span class="sm text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="feet">Width</label>
                                    <input type="text" class="form-control mt-2" name="width_feet" placeholder="Enter Feet" value="{{ old('width_feet') }}">
                                    @error("width_feet")
                                        <span class="sm text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inche"></label>
                                    <input type="text" class="form-control mt-2" name="width_inche" placeholder="Enter Inches" value="{{ old('width_inche') }}">
                                    @error("width_inche")
                                        <span class="sm text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="height_feet">Height</label>
                                    <input type="text" class="form-control mt-2" name="height_feet" placeholder="Enter Feet" value="{{ old('height_feet') }}">
                                    @error("height_feet")
                                        <span class="sm text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="height_inche"></label>
                                    <input type="text" class="form-control mt-2" name="height_inche" placeholder="Enter Inches" value="{{ old('height_inche') }}">
                                    @error("height_inche")
                                        <span class="sm text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="description">Show</label>

                        <div class="form-group form-check mt-3">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="active" value="0" checked>
                            <label class="form-check-label" for="exampleCheck1">Yes</label>
                          </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row" id="specificationSection">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="description">Specification <span class="sl">1</span></label>
                                    <textarea class="form-control mt-2" name="specification1" id="" cols="30" rows="5"></textarea>
                                    @error("description")
                                        <span class="sm text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
        
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="description">Specification <span class="sl">2</span></label>
                                    <textarea class="form-control mt-2" name="specification2" id="" cols="30" rows="5"></textarea>
                                    @error("description")
                                        <span class="sm text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
        
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="description">Specification <span class="sl">3</span></label>
                                    <textarea class="form-control mt-2" name="specification3" id="" cols="30" rows="5"></textarea>
                                    @error("description")
                                        <span class="sm text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            let indexValue = 3;
            $(document).ready(function () {
                $('select').select2();
                $(document).on('change', '#category_id', loadSubCategory);
                $(document).on('click', '#addSpecification', addSpecification);
                $("#sub_category_id").prop('disabled', true);
                $(document).on('click', '.removeSpecification', function() {
                    $(this).closest('.col-md-4').remove();
                    slHandler();
                });
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

            function addSpecification()
            {
                let data = ``;
                data = `
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <label for="description">Specification <span class="sl"></span></label>
                            <button type="button" class="btn removeSpecification"><i class="fas fa-times-circle text-danger"></i></button>
                        </div>
                        <textarea class="form-control mt-2" name="specification[]" id="" cols="30" rows="5"></textarea>
                        @error("specification")
                            <span class="sm text-danger">{{ $message }}</span>
                        @enderror
                </div>`;
                $('#specificationSection').append(data);
                slHandler();
            }

            function slHandler()
            {
                let sls = $('.sl');

                $.each(sls, function(index,val){
                    $(val).html(index +1);
                });
            }
        </script>
    @endpush

</x-backend.layouts.master>