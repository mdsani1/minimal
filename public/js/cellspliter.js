$(document).ready(function () {
    var table = $('#editableTable'); // Adjust if your table has a different ID

    table.on('keydown', 'td', function(event) {
        if (event.ctrlKey && event.key === 'q') { // Ctrl+Q to add a new row
            event.preventDefault();
            addRowAndAdjustRowspan($(this));
        } else if (event.ctrlKey && event.key === 'z') { // Ctrl+Z to undo
            event.preventDefault();
            undoRowAddition();
        }
    });

    var undoStack = [];

    function addRowAndAdjustRowspan($cell) {
        // Store current state for undo
        undoStack.push(table.html());

        var rowIndex = $cell.closest('tr').index();
        var $newRow = $('<tr>');

        // Adjust the rowspan of all cells in the current row
        $cell.closest('tr').find('td').each(function () {
            var $currentCell = $(this);
            var currentRowSpan = $currentCell.attr('rowspan') || 1;
            $currentCell.attr('rowspan', parseInt(currentRowSpan, 10) + 1);

            // Add a new cell to the new row only if the cell above doesn't span into it
            if (currentRowSpan == 1) {
                $newRow.append('<td>&nbsp;</td>'); // Insert a non-breaking space
            }
        });

        // Append the new row to the table
        if (rowIndex === table.find('tr').length - 1) {
            table.append($newRow); // Append as the last row
        } else {
            $newRow.insertAfter(table.find('tr').eq(rowIndex)); // Insert after the current row
        }
    }

    function undoRowAddition() {
        if (undoStack.length === 0) return;

        // Restore the table to its previous state
        table.html(undoStack.pop());
    }
});
