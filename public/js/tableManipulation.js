$(document).ready(function() {
    // Attach the event listener for the "Add Row" button click
    $('.addRowBtn').click(function() {
        // Find the closest .tab-pane and then find the .editableTable inside it
        let editableTable = $(this).closest('.tab-pane').find('.editableTable');
        addRow(editableTable);
    });

    $('.addColumnBtn').click(function() {
        let editableTable = $(this).closest('.tab-pane').find('.editableTable');
        var lastThId = editableTable.find('.saveData.extracolumn:last').attr('id');

        let columnNo;
        if(lastThId == null || lastThId == undefined) {
            console.log('in');
            columnNo = 1;
        } else {
            var modifiedString = lastThId.replace(/^column/, '');
            console.log(parseInt(modifiedString) + 1);
            columnNo = parseInt(modifiedString) + 1;
        }

        addColumn(editableTable, columnNo);
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
                newCell = $('<td class="sl"></td>').addClass(thValue); // Add class from th to td
            } else {
                console.log(thValue);
                if(i > 6) {
                    newCell = $(`<td class="saveData" contenteditable="true">
                    <input type="hidden" class="quoteItemValue" value="${thValueId}">
                    </td>`).addClass(thValue); // Add class from th to td
                } else {
                    newCell = $('<td class="saveData" contenteditable="true"></td>').addClass(thValue); // Add class from th to td
                }
            }
            newRow.append(newCell); // Append each new cell to the row
        }

        // Append the newly created row to the table
        table.find('tbody').append(newRow);
        slHandler(table); // Call slHandler to update sl values
    }

    // Function to dynamically add a new column to the end of all rows in the editable table
    // This function iterates through each row, appending a new cell to ensure the column is added uniformly across the table.

    function addColumn(table, columnNo) {
        // Iterate over each row in the table
        table.find('tr').each(function() {
            // For header row, add a <th> element; for other rows, add a <td> element
            if ($(this).find('th').length) {
                $(this).append(`<th style="background-color: #198754; color:#fff" contenteditable="true" class="newcloumnHeader saveData extracolumn" id="column${columnNo}">New Header</th>`);
            } else {
                $(this).append(`<td class="NewHeader newHeader${columnNo} saveData" contenteditable="true">
                <input type="hidden" class="quoteItemValue" value="column${columnNo}">
                </td>`);
            }
        });

        columnNo++;
    }


    // Function to update sl values
    function slHandler(table) {
        let sls = table.find('.sl');

        $.each(sls, function(index,val){
            $(val).html(index+1);
        });
    }
});
