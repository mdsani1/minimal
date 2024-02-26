<x-backend.layouts.master>

    <x-slot name="page_title">
        Editable Table
    </x-slot>

    <x-slot name="breadcrumb">
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader">
                Editable Table
            </x-slot>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <div>
        <button class="btn btn-success" id="addRowBtn">Add Row</button>
        <button class="btn btn-info" id="addColumnBtn">Add Column</button>
        <!-- Button to trigger PDF preview -->
        <button class="btn btn-warning" id="pdfPreviewButton">Preview PDF</button>

        <!-- Button to download the PDF directly -->
        <button id="downloadPdfButton">Download PDF</button>

        <!-- Button for scroll-to-top -->
        <button id="scrollToTopButton" aria-label="Scroll to top" title="Scroll to top" style="display: none; position: fixed; bottom: 20px; right: 20px; z-index: 100;">
            <i class="fas fa-chevron-up"></i>
        </button>



        <!-- The Modal for PDF preview -->
        <div id="pdfPreviewModal" class="modal">
            <div class="modal-content">
            <span class="close">&times;</span> <!-- Close button -->
            <iframe id="pdfPreviewIframe" style="width:100%;height:100%;"></iframe>
            </div>
        </div>
        

        <div class="">
            <h1 class="mt-5">
                <input type="text" class="form-control" style="background: none; border:none; font-size:30px" value="Editable Table">
            </h1>
            <table class="table" id="editableTable" style="background: #fff">
                <thead>
                    <tr>
                        <th style="background-color: #198754; color:#fff">SL</th>
                        <th style="background-color: #198754; color:#fff">ITEM</th>
                        <th style="background-color: #198754; color:#fff">SPECIFICATION</th>
                        <th style="background-color: #198754; color:#fff">QTY</th>
                        <th style="background-color: #198754; color:#fff">UNIT</th>
                        <th style="background-color: #198754; color:#fff">RATE</th>
                        <th style="background-color: #198754; color:#fff">AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Gypsum Board Ceiling</td>
                        <td>Supply, fitting and fixing Gypsum board ceiling of 9mm thick board laminated by mechanical hot press with a milk white PVC membrane with Aluminium T-bar frame in natural anodized finish at 600 x 600 mm in grid suspended from ceiling ply wire fixed to the ceiling by rowel plug, screws, hooks, nails etc. all complete as per drawing, design and accepted by the Engineer.</td>
                        <td contenteditable="true">-</td>
                        <td>sft</td>
                        <td contenteditable="true">-</td>
                        <td contenteditable="true">-</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Seamless Decorative Ceiling (False Ceiling)</td>
                        <td>Supply fitting and fixing of Seamless Decorative Ceiling with suspended with modular coordinated arrangement from roof made of 2"x1" seasoned gorgion wood frame and 12mm plain board plaster board with cove lighting arrangement and plastic paint finish with modular coordinated arrangement.</td>
                        <td contenteditable="true">-</td>
                        <td>sft</td>
                        <td contenteditable="true">400</td>
                        <td contenteditable="true">-</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Decorative CNC Ceiling</td>
                        <td>Supply, fitting and fixing of Decorative CNC Ceiling with cove lighting arrangement suspended from roof by 2"x1" seasoned gorgion wood frame and made of 12mm MDF with cove lighting arrangement and Plastic paint finish, design pattern done by CNC Cutting and with modular coordinated arrangement fixed at the roof top with 2"x1" wood screw and rawl plug and other necessary accessories as per design and direction</td>
                        <td contenteditable="true">-</td>
                        <td>sft</td>
                        <td contenteditable="true">400</td>
                        <td contenteditable="true">-</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Decorative CNC Ceiling</td>
                        <td>Supply, fitting and fixing of Decorative CNC Ceiling with cove lighting arrangement suspended from roof by 2"x1" seasoned gorgion wood frame and made of 12mm MDF with cove lighting arrangement and Plastic paint finish, design pattern done by CNC Cutting and with modular coordinated arrangement fixed at the roof top with 2"x1" wood screw and rawl plug and other necessary accessories as per design and direction</td>
                        <td contenteditable="true">-</td>
                        <td>sft</td>
                        <td contenteditable="true">400</td>
                        <td contenteditable="true">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @push('css')
        <link rel="stylesheet" href={{asset("ui/dist/css/adminlte.min.css")}}>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @endpush

    @push('js')
        <!-- Include the JsPDF library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <!-- Include the html2canvas library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
        <script src="{{ asset('js/script.js') }}"></script>
        <script src="{{ asset('js/autosuggestions.js') }}"></script>
        <script src="{{ asset('js/tableManipulation.js') }}"></script>
        <script src="{{ asset('js/cellspliter.js') }}"></script>
        <script src="{{ asset('js/pdfHandler.js') }}"></script>
        <script src="{{ asset('js/scrollToTop.js') }}"></script>
        <script>
            $(document).ready(function(){
                // Function to add a new row
                $("#addRowBtn").click(function(){
                    // Clone the last row and append it to the table
                    $("#editableTable tbody tr:last").clone().appendTo("#editableTable tbody");
                });
            });
        </script>
    @endpush
</x-backend.layouts.master>