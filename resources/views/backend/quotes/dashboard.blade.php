<x-backend.layouts.master>


    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-7">
                <div class=" mt-3 input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend" style="background-color: #fff; border: 1px solid #ced4da; border-radius: 0.25rem; border-right:none !important;">
                        <div class="input-group-text" style="background-color: #fff; border: none;"><i class="fas fa-search mt-1"></i></div>
                    </div>
                    <input type="text" class="form-control" id="searchInput" placeholder="Search" style=" border-left:none !important;">
                </div>
            </div>
        </div>
        

        <div class="mt-4">
            <p style="font-size: 18px">Sheet</p>

            <div class="row">

                @foreach ($templates as $template)
                <div class="col-md-2">
                    <a href="{{ route('template-edit', $template->id) }}">
                        <div class="card" style="height: 150px">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <i class="fas fa-database" style="font-size: 40px"></i>
                            </div>
                        </div>
                        <p class="text-center" style="font-size: 18px">{{ $template->title }}</p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="table-responsive" style="background-color: #fff; height:60vh">
        <div class="container table-responsive">
            <div class="pt-3">
                <x-backend.layouts.elements.message :message="session('message')"/>
            </div>
            <div class="pt-2 ">
                <table class="table" id="quotesTableData">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th class="text-center">Date</th>
                            <th style="text-align: right">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <style>
            a {
                text-decoration: none;
                color: #000
            }
            .container-fluid {
                padding: 0px !important;
            }
            .dropdown-toggle::after {
                content: none;
            }
            .remove-btn:hover {
                background-color: #ddd;
                border-radius: 0px;
            }
            .dropdown-item:hover {
                background-color: #ddd
            }
        </style>
    @endpush


    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
                $('#sidebarToggle').trigger('click');
                $(document).on('change || keyup', '#searchInput', loadData);
                loadData();
            });

            function loadData()
            {
                $.ajax({
                    method: "GET",
                    url: "/api/sheet/list",
                    data: {'search' : $('#searchInput').val()},
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        let data = ``;
                        $.each(response, function (arrayIndex, elementValue) { 
                             data += `
                             <tr>
                                <td>${elementValue.title}</td>
                                <td class="text-center">${elementValue.date}</td>
                                <td style="text-align: right">
                                    <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" target="_blank" href="/sheet-pdf/${elementValue.id}">Pdf</a>
                                        <a class="dropdown-item" href="/template/edit/${elementValue.id}">Edit</a>
                                        <button type="button" class="dropdown-item copyLink" target="_blank" href="/sheet-pdf/${elementValue.id}">Copy</button>
                                        <form style="display: inline;" action="/sheet-delete/${elementValue.id}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button onclick="return confirm('Are you sure want to delete ?')" class="btn remove-btn" type="submit" style="width:100%; text-align:left; padding-left: 22px !important;">Remove</button>
                                        </form>
                                    </div>
                                    </div>    
                                </td>
                            </tr>`;
                        });

                        $('#quotesTableData tbody').html('');
                        $('#quotesTableData tbody').append(data);
                    }
                });
            }
        </script>
        <script>
            $(document).ready(function() {
                // Function to handle click event on PDF button
                $(document).on('click', '.copyLink', function() {
                    // Retrieve the base URL
                    let baseUrl = window.location.origin;
                    let pdfUrl = $(this).attr('href');
                    
                    // Concatenate base URL and PDF URL
                    let fullUrl = baseUrl + pdfUrl;
                    
                    // Notify the user that the full URL has been copied
                    navigator.clipboard.writeText(fullUrl)
                        .then(function() {
                            // Notify the user that the URL has been copied
                            Swal.fire({
                                icon: "success",
                                title: 'Copy Link', // Show error message
                                showConfirmButton: false,
                                timer: 1500
                            });
                        })
                        .catch(function(error) {
                            console.error('Failed to copy full URL: ', error);
                        });
                    
                    // Prevent default link behavior
                    return false;
                });
            });
        </script>
    @endpush
</x-backend.layouts.master>