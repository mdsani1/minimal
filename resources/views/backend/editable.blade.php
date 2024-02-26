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
            <div class="table-responsive">
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
            $(document).ready(function() {

                // Add row button click event handler
                $("#addRowBtn").click(function() {
                    // Create a new empty row
                    var newRow = $("<tr></tr>");

                    // Add cells to the new row based on the number of existing columns
                    var existingColumns = $("#editableTable thead th").length;
                    for (var i = 0; i < existingColumns; i++) {
                        newRow.append("<td></td>"); // Add an empty cell for each column
                    }

                    // Append the new row to the table body
                    $("#editableTable tbody").append(newRow);
                    initializeTableCells();
                });

                // Add column button click event handler
                $("#addColumnBtn").click(function() {
                    // Get all rows
                    var rows = $("#editableTable tbody tr");

                    // Create a new header cell with a double-click event listener
                    var newHeaderCell = $("<th></th>").text("New Column").css({"background-color": "#198754", "color": "#fff"});
                    newHeaderCell.dblclick(function() {
                        var currentName = $(this).text(); // Store current name

                        // Create an input field for editing
                        var editInput = $('<input type="text" class="edit-column-name form-control" value="' + currentName + '" style="background: none; border: none; font-size: 15px;">');

                        // Replace cell content with the input field
                        $(this).html(editInput);

                        // Set focus to the input field for immediate editing
                        editInput.focus();

                        // Add blur event listener to the input field for confirmation
                        editInput.blur(function() {
                        var newName = $(this).val();

                        // Validate new name (optional: check for emptiness or other criteria)
                        if (newName.trim() !== "") {
                            $(this).parent().text(newName); // Update header cell text
                        } else {
                            // Revert to original name if validation fails or is empty
                            $(this).parent().text(currentName);
                        }

                        // Remove the input field after confirmation
                        $(this).remove();
                        });
                    });

                    // Append the header cell to the table head
                    $("#editableTable thead tr").append(newHeaderCell);

                    // Add an empty cell to each existing row
                    rows.each(function() {
                        $(this).append("<td></td>");
                    });
                    initializeTableCells();
                });

            });
        </script>
    @endpush
</x-backend.layouts.master>