$(document).ready(function() {
    // Attach the event listener for the "Add Row" button click
    $('.addRowBtn').click(function() {
        // Find the closest .tab-pane and then find the .editableTable inside it
        let table = $(this).closest('.category').find('.tab-pane.zone.fade.show.active .editableTable');
        let editableTable;
        if(table.length > 0) {
            editableTable = table;
        } else {
            editableTable = $(this).closest('.tab-pane').find('.editableTable');
        }
        addRow(editableTable);
    });

    $('.addColumnBtn').click(function() {
        // let editableTable = $(this).closest('.tab-pane').find('.editableTable');
        let table = $(this).closest('.category').find('.tab-pane.zone.fade.show.active .editableTable');
        let editableTable;
        if(table.length > 0) {
            editableTable = table;
        } else {
            editableTable = $(this).closest('.tab-pane').find('.editableTable');
        }
        
        var lastThId = editableTable.find('.saveDataTd.extracolumnTd:last').attr('id');

        let columnNo;
        if(lastThId == null || lastThId == undefined) {
            columnNo = 1;
        } else {
            console.log('in2');
            var modifiedString = lastThId.replace(/^column/, '');
            columnNo = parseInt(modifiedString) + 1;
        }
        addColumn(editableTable, columnNo);
    });

    $(document).on('click', '.removeColumn', function() {
        let table

        if($('#myTabContent .category.active.show .zone.active.show').find('.editableTable').length > 0) {
            table = $('#myTabContent .category.active.show .zone.active.show').find('.editableTable');
        } else {
            table = $('#myTabContent .category.active.show').find('.editableTable');
        }

        let headerId = $(this).closest('th').attr('id');

        $.ajax({
            method: "post",
            url: "/api/column/delete",
            data: {
                quote_title: $('.quote_title').val(),
                quotationId: $('.quotationId').val(),
                category_id: table.find('.categoryId').val(),
                sub_category_id: table.find('.subCategoryId').val(),
                headerId: headerId,
            },
            headers: {
                "X-CSRF-TOKEN": $(document).find('[name="_token"]').val()
            },
            dataType: "json",
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
        
        table.find('tr').each(function() {
            // Remove the column with the matching headerId
            $(this).find(`th[id='${headerId}'], td.${headerId}`).remove();
        });
    });
    
    
    $(document).on('click', '.rowColumn', function() {
        let table

        if($('#myTabContent .category.active.show .zone.active.show').find('.editableTable').length > 0) {
            table = $('#myTabContent .category.active.show .zone.active.show').find('.editableTable');
        } else {
            table = $('#myTabContent .category.active.show').find('.editableTable');
        }
        
        $(this).closest('tr').remove();
        slHandler(table);
        triggerCreate();
    });

    // Function to dynamically add a new row to the editable table
    // This function calculates the number of columns in the first row of the table
    // to ensure consistency in the number of cells across all rows.
    function addRow(table) {
        // Get the number of columns in the first row
        const columnCount = table.find('tr:first th').length || table.find('tr:first td').length;
      
        // Create a new row element
        let newRow = $('<tr></tr>');
      
        // Append the appropriate number of cells to the new row
        for (let i = 0; i < columnCount; i++) {
            // Declare and initialize thValue inside the loop
            let thValue = table.find('thead th').eq(i).text(); // Get the class value of the corresponding th
            let thValueId = table.find('thead th').eq(i).attr('id');
            thValue = thValue.replace(/\s+/g, '_').toLowerCase(); // Should now log the correct class values

            let newCell;
            if (i === 0) {
                newCell = $(`<td>
                    <span class="slNo"></span>
                    <button class="btn rowColumn text-danger" style="position: relative; top: -12px; right: 5px;">X</button>
                </td>`).addClass(thValue); // Add class from th to td
            } else {
                if(i > 6) {
                    newCell = $(`<td class="saveData" contenteditable="true">
                    <input type="hidden" class="quoteItemValue" value="${thValueId}">
                    </td>`).addClass(thValue); // Add class from th to td
                }else if(i == 6){
                    newCell = $('<td class="saveData"></td>').addClass(thValue); // Add class from th to td
                }
                 else {
                    newCell = $('<td class="saveData" contenteditable="true"></td>').addClass(thValue); // Add class from th to td
                }
            }
            newRow.append(newCell); // Append each new cell to the row
        }
        // Append the newly created row to the table
        table.find('tbody').append(newRow);
        slHandler(table); // Call slHandler to update sl values
    }

    function addColumn(table, columnNo) {
        if(columnNo == 2){
            columnNo = 3;
        }

        // Iterate over each row in the table
        table.find('tr').each(function() {
            // For header row, add a <th> element; for other rows, add a <td> element
            if ($(this).find('th').length) {
                $(this).append(`<th style="background-color: #198754; color:#fff" class="saveDataTd extracolumnTd"  id="column${columnNo}">
                <span contenteditable="true" class="newcloumnHeader saveData extracolumn" style="background-color: #198754; color:#fff">New Header</span>
                <button class="btn text-danger removeColumn" style="position: relative; top: -12px; right: 5px;">X</button>
                </th>`);
            } else {
                $(this).append(`<td class="NewHeader newHeader${columnNo} saveData column${columnNo}" contenteditable="true">
                <input type="hidden" class="quoteItemValue" value="column${columnNo}">
                </td>`);
            }
        });
        columnNo++;
    }


    // Function to update sl values
    function slHandler(table) {
        let sls = table.find('.sl');

        $.each(sls, function(index, val){
            $(val).find('.slNo').html(index+1);
        });
    }
});
