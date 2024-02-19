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
            <form action="{{ route('quotations.update', ['quotation' => $quotation->id]) }}" method="POST">
                @csrf
                @method('patch')
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control mt-2" name="name" placeholder="Enter Name" value="{{ old('name', $quotation->name) }}" required>
                            @error("name")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control mt-2" name="address" placeholder="Enter Address" value="{{ old('address', $quotation->address) }}" required>
                            @error("address")
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
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quotation->quotationItems as $quotationItem)
                                <tr>
                                    <input type="hidden" name="quotationItemId[]" value="{{ $quotationItem->id }}">
                                    <td class="text-center sl">1</td>
                                    <td class="text-center" style="width: 35%">
                                        <select data-placeholder="{{ ('please Select') }}" name="work_scope[]" value="{{ old('work_scope') }}" class="form-control mt-2" required>
                                            <option value="">Please Select</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ $category->id == $quotationItem->work_scope ? 'selected' : '' }}>{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="text-center" style="width: 35%">
                                        <input type="number" class="form-control mt-2" name="amount[]" placeholder="Enter Amount" value="{{ old('amount', $quotationItem->amount) }}" required>
                                    </td>
                                    <td class="text-center" style="width: 20%">
                                        <button type="button" class="btn btn-success add-row"><i class="fas fa-plus-circle"></i></button>
                                        <button class="btn btn-danger delete" data-id="{{ $quotationItem->id }}"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="mt-4 mb-0 d-flex justify-content-end">
                    <button onclick="return confirm('Are you sure want to update ?')" type="submit" class="btn btn-success">Update</button>
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
                $(document).on('change', '.work_scope', doubleCheck);

                $('.add-row').click(function() {
                    $('#dynamic-table tbody').append(`<tr>
                        <input type="hidden" name="quotationItemId[]" value="{{ null }}">
                        <td class="text-center sl">1</td>
                        <td class="text-center" style="width: 35%">
                            <select data-placeholder="{{ ('please Select') }}" name="work_scope[]" value="{{ old('work_scope') }}"  class="form-control mt-2 work_scope" required>
                                <option value="">Please Select</option>
                            </select>
                        </td>
                        <td class="text-center" style="width: 35%">
                            <input type="number" class="form-control mt-2" name="amount[]" placeholder="Enter Amount" value="{{ old('amount') }}" required>
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

                $('.delete').click(function(e) {
                    e.preventDefault(); // Prevent the default action of the link/button
                    
                    var id = $(this).data('id'); // Get the ID of the quotation item to delete
                    
                    // Send an AJAX request to delete the quotation item
                    $.ajax({
                        url: '/api/quotationitem-delete/' + id,
                        type: 'GET',
                        success: function(response) {
                            // If deletion is successful, remove the quotation item from the DOM
                            $(e.target).closest('tr').remove();
                            
                            // Display a success message using Swal
                            Swal.fire({
                                text: response.message,
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle errors if any
                            console.error(xhr.responseText);
                            Swal.fire({
                                text: 'An error occurred while deleting the quotation item.',
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    });
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

        </script>
    @endpush

</x-backend.layouts.master>