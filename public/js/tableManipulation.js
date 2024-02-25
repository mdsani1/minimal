// Function to add a new row to the table
function addRow() {
    const table = document.getElementById('editableTable');
    const newRow = table.insertRow();
    const columns = table.rows[0].cells.length;

    for (let i = 0; i < columns; i++) {
        const newCell = newRow.insertCell();
        newCell.contentEditable = 'true';
        addCellEventListeners(newCell); // Add event listeners to the new cell
    }
}

function addColumn() {
    const table = document.getElementById('editableTable');
    const rows = table.rows;
    const newCellIndex = rows[0].cells.length;
    const columnWidths = ['300px', '600px', '100px']; // Widths for the columns, adjust as needed

    for (let i = 0; i < rows.length; i++) {
        const newCell = rows[i].insertCell(newCellIndex);
        newCell.contentEditable = 'true';
        
        // Set column width
        if (newCellIndex === 1) {
            newCell.style.width = '300px'; // Width for the second column
        } else {
            newCell.style.width = columnWidths[newCellIndex] || '100px'; // Default width for other columns
        }

        // Set generic header name for new columns
        if (i === 0) {
            const columnHeader = 'Column ' + (newCellIndex + 1);
            newCell.innerText = columnHeader;
        }

        addCellEventListeners(newCell); // Add event listeners to the new cell
    }
}



// Function to add event listeners to a cell
function addCellEventListeners(cell) {
    cell.addEventListener('mouseenter', () => {
        cell.contentEditable = 'true';
    });

    cell.addEventListener('mouseleave', () => {
        cell.contentEditable = 'false';
        saveTableCellContent(cell);
        hideSuggestions(cell); // Hide suggestions when mouse leaves the cell
    });

    cell.addEventListener('input', () => {
        const inputValue = cell.innerText.trim().toLowerCase();
        const suggestions = getSuggestions(inputValue);

        if (suggestions.length > 0) {
            showSuggestions(cell, suggestions);
        } else {
            hideSuggestions(cell);
        }
    });

    cell.addEventListener('click', () => {
        hideSuggestions(cell);
    });

    cell.addEventListener('keydown', (event) => {
        if (event.ctrlKey && event.shiftKey && cell.contentEditable === 'true') {
            event.preventDefault();
            showDropdown(cell);
        } else if (event.key === 'Tab') {
            event.preventDefault();
            moveCursor(cell);
        } else if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form submission or newline insertion
            selectSuggestion(cell);
        } else if (event.key === 'Escape') {
            hideSuggestions(cell); // Hide suggestions when Esc key is pressed
        }
    });

    cell.addEventListener('keypress', (event) => {
        if (cell.querySelector('select')) {
            const dropdownMenu = cell.querySelector('select');
            const input = String.fromCharCode(event.which);
            const selectedIndex = parseInt(input) - 1;

            if (!isNaN(selectedIndex) && selectedIndex >= 0 && selectedIndex < dropdownMenu.options.length) {
                dropdownMenu.selectedIndex = selectedIndex;
                dropdownMenu.dispatchEvent(new Event('change'));
            }
        }
    });
}





