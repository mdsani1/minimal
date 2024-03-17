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
            <li class="breadcrumb-item active">Create</li>
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
            <form action="{{ route('quotations.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Purpose</label>
                            <select name="purpose" class="form-control mt-2" id="purposeSelect">
                                <option value="">Please Select</option>
                                <option value="Residential (R)">Residential (R)</option>
                                <option value="Commercial (C)">Commercial (C)</option>
                                <option value="Architectural (A)">Architectural (A)</option>
                            </select>
                            @error("purpose")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" class="form-control mt-2" id="typeSelect">
                                <!-- Options will be added dynamically by JavaScript -->
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control mt-2" name="name" placeholder="Enter Name" value="{{ old('name') }}" required>
                            @error("name")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="area">Area</label>
                            <input type="text" class="form-control mt-2" name="area" placeholder="Enter Address" value="{{ old('area') }}" required>
                            @error("area")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control mt-2" name="address" placeholder="Enter Address" value="{{ old('address') }}" required>
                            @error("address")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control mt-2" name="city" placeholder="Enter Address" value="{{ old('city') }}" required>
                            @error("city")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="active_bank">Bank Information Show</label>

                            <select class="form-control mt-2" name="active_bank" id="">
                                <option value="0" selected>Show</option>
                                <option value="1">OFF</option>
                            </select>

                            @error("active_bank")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    
                    <div class="col-md-12 mt-3">
                        <hr>
                        <h2>Quotation Items</h2>
                        <table id="dynamic-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th class="text-center">Work Scope</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    <td class="text-center sl">1</td>
                                    <td class="text-center" style="width: 75%">
                                        <select data-placeholder="{{ ('please Select') }}" name="work_scope[]" value="{{ old('work_scope') }}" class="form-control mt-2 work_scope" required readonly>
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        </select>
                                    </td>
                                    <td class="text-center" style="width: 20%">
                                        <button type="button" class="btn btn-success add-row"><i class="fas fa-plus-circle"></i></button>
                                        <button class="btn btn-danger delete-row"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                loadcategory();
                $('#typeSelect').prop('disabled', true);
                $(document).on('change', '.work_scope', doubleCheck);
                $(document).on('change', '#purposeSelect', loadType);

                $('.add-row').click(function() {
                    $('#dynamic-table tbody').append(`<tr>
                        <td class="text-center sl">1</td>
                        <td class="text-center" style="width: 75%">
                            <select data-placeholder="{{ ('please Select') }}" name="work_scope[]" value="{{ old('work_scope') }}"  class="form-control mt-2 work_scope" required>
                                <option value="">Please Select</option>
                            </select>
                        </td>
                        <td class="text-center" style="width: 20%">
                            <button type="button" class="btn btn-success add-row"><i class="fas fa-plus-circle"></i></button>
                            <button class="btn btn-danger delete-row"><i class="fas fa-trash-alt"></i></button>
                        </td>
                        </tr>`);
                    slHandler();
                    loadcategory();
                });

                $(document).on('click', '.delete-row', function() {
                    $(this).closest('tr').remove();
                    slHandler();
                });
            });

            function loadcategory()
            {
                $.ajax({
                    url      : `/api/get-category`,
                    method   : "GET",
                    dataType : "JSON",
                    success     : function (res)
                    {
                        $(".work_scope").select2({
                            data: res,
                            placeholder: "Please Select",
                            allowClear: true
                        })
                        $(".work_scope").prop('disabled', false);
                    },
                    error(err){
                        $(".work_scope").select2({
                            data: ""
                        });
                        $(".work_scope").prop('disabled', true);
                    }
                }); 
            }

            function slHandler()
            {
                let sls = $('.sl');

                $.each(sls, function(index,val){
                    $(val).html(index+1);
                });
            }

            const doubleCheck = (event)=>{
                let
                    el = event.target,
                    select  = $(document).find('.work_scope');

                item = [];
                $.each(select, function(index, v){
                    if($(v).val() != null){
                        if(v != el){
                            item.push($(v).val());
                        }
                    }
                });

                if(item.includes($(el).val())){
                    Swal.fire({
                        text: 'Already Selected',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    $(el).val(null).change();
                }
                    
            }

            function loadType(event) 
            {
                let el = event.target;

                var typeSelect = document.getElementById('typeSelect');
        
                // Clear previous options
                typeSelect.innerHTML = '';
                
                if ($(el).val() === 'Residential (R)') {
                    // Add options for Residential
                    var types = ["Basic (B)", "Premium (P)", "Compact Luxury (C)", "Luxury (L)"];
                    types.forEach(function(type) {
                        var option = document.createElement('option');
                        option.text = type;
                        option.value = type;
                        typeSelect.add(option);
                    });
                    $('#typeSelect').prop('disabled', false);
                } else {
                    $('#typeSelect').prop('disabled', true);
                }
            }

        </script>
    @endpush

</x-backend.layouts.master>