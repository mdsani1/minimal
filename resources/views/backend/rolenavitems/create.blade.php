<x-backend.layouts.master>
    <x-slot name="page_title">
        Role Nav Items
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Role Nav Items
            </x-slot>
            <x-slot name="add">

            </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="text-decoration: none; color:#6c757d">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('rolenavitems.index') }}" style="text-decoration: none; color:#6c757d">Role Nav Items</a></li>
            <li class="breadcrumb-item active">Create</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">

            <div class="d-flex justify-content-between">
                <span><i class="fas fa-table me-1"></i>Role Nav Item Create</span>
            </div>
        </div>
        <div class="card-body">
            <x-backend.layouts.elements.errors :errors="$errors"/>
            <x-backend.layouts.elements.message :message="session('message')"/>
            <form action="{{ route('rolenavitems.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role_id" class="form-control mt-2" required>
                                <option value="">Please Select</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error("title")
                                <span class="sm text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <h4 class="col-12">Nav Items</h4>
                    <div class="col-md-6 row" id="navitems-col-1">

                    </div>

                    <div class="col-md-6 row" id="navitems-col-2">

                    </div>
                </div>

                <div class="mt-4 mb-0 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
        {{-- <div class="card-footer text-center text-muted">
            <a class="btn btn-success text-white btn-sm" href="{{ Route('rolenavitems.index') }}" role="button" style="border-radius: 50%"><i class="fas fa-list"></i></a>
        </div> --}}
    </div>

    @push('css')
    <style>
        .select2-container--default .select2-selection--single {
            height: 37px;
        }
    </style>
    @endpush

    @push('js')
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

    <script>
        (function($){
            $(document).ready(()=>{
                $('select').select2();
                $(document).on('change','#role_id',loadnavitems);
            });
        })(jQuery)

        const loadnavitems = (event)=>{
            let el = event.target;

            roleId = $(el).val();

            $("#navitems").html('');
            if(roleId != null){
                $.ajax({
                    url      : `/api/get-role-navitems-with-selected/${roleId}`,
                    method   : "GET",
                    dataType : "JSON",
                    success     : function (res)
                    {
                        let contentHolderCol1 = '';
                        let contentHolderCol2 = '';
                        $.each(res[0],function(index,val){
                            if(val.isSelected != 0){
                                contentHolderCol1 += `<div class="col-md-12 h5"><input type="checkbox" value="1" checked name=navitems[${val.id}] id=${val.id}> <label class="mr-4 ml-2" for=${val.id}>${val.title}</label></div>`;
                            }else
                            {
                                contentHolderCol1 += `<div class="col-md-12 h5"><input type="checkbox" value="1" name=navitems[${val.id}] id=${val.id}> <label class="mr-4 ml-2" for=${val.id}>${val.title}</label></div>`;
                            }
                        });

                        $.each(res[1],function(index,val){
                            if(val.isSelected != 0){
                                contentHolderCol2 += `<div class="col-md-12 h5"><input type="checkbox" value="1" checked name=navitems[${val.id}] id=${val.id}> <label class="mr-4 ml-2" for=${val.id}>${val.title}</label></div>`;
                            }else
                            {
                                contentHolderCol2 += `<div class="col-md-12 h5"><input type="checkbox" value="1" name=navitems[${val.id}] id=${val.id}> <label class="mr-4 ml-2" for=${val.id}>${val.title}</label></div>`;
                            }
                        });

                        $("#navitems-col-1").html(contentHolderCol1);
                        $("#navitems-col-2").html(contentHolderCol2);

                    },
                    error(err){
                        $("#navitems-col-1").html('');
                    }
                });
            }
        }

    </script>
@endpush

</x-backend.layouts.master>
