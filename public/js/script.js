document.addEventListener("DOMContentLoaded", function () {
    initializeTableCells();
});


function initializeTableCells() {
    const tableCells = document.querySelectorAll('#editableTable td');

    tableCells.forEach(cell => {
        cell.addEventListener('mouseenter', () => {
            cell.contentEditable = 'true';
        });

        cell.addEventListener('mouseleave', () => {
            cell.contentEditable = 'false';
            saveTableCellContent(cell);
            hideSuggestions(cell); // Hide suggestions when mouse leaves the cell
        });

        cell.addEventListener('input', () => {
            const inputValue = cell.innerHTML.trim().toLowerCase();
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
                getSuggestions(cell);
            } else if (event.key === 'Escape') {
                hideSuggestions(cell); // Hide suggestions when Esc key is pressed
            } else if (event.shiftKey && (event.key.toLowerCase() === 'r' || event.key.toLowerCase() === 'c')) {
                  event.preventDefault();
                  if (event.key.toLowerCase() === 'r') {
                      increaseRow(cell);
                  } else {
                      increaseColumn(cell);
                  }
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
    });
}

// Call the function whenever needed
// For example:
// initializeTableCells();



function moveCursor(cell) {
  const table = cell.closest('table');
  const allCells = Array.from(table.querySelectorAll('td'));
  const editableCells = allCells.filter(cell => cell.contentEditable === 'true');

  if (editableCells.length === 0) {
      const firstCell = table.querySelector('tr:first-child td:first-child');
      firstCell.contentEditable = 'true';
      firstCell.focus();
  } else {
      const currentIndex = allCells.indexOf(cell);
      const totalCells = allCells.length;

      let nextCellIndex;

      if (currentIndex === totalCells - 1) {
          const nextRow = cell.parentNode.nextElementSibling;
          if (nextRow) {
              nextCellIndex = nextRow.querySelector('td').cellIndex;
              nextRow.querySelector('td').contentEditable = 'true';
              nextRow.querySelector('td').focus();
          }
      } else {
          nextCellIndex = currentIndex + 1;
          allCells[nextCellIndex].contentEditable = 'true';
          allCells[nextCellIndex].focus();
      }

      if (nextCellIndex === undefined) {
          const firstRow = table.querySelector('tr');
          const firstCell = firstRow.querySelector('td');
          firstCell.contentEditable = 'true';
          firstCell.focus();
      }
  }
}


function saveTableCellContent(cell) {
  const rowIndex = cell.parentNode.rowIndex;
  const cellIndex = cell.cellIndex;
  const newValue = cell.innerHTML;
}

function increaseRow(cell) {
  const rowIndex = cell.parentNode.rowIndex;
  const newRow = cell.parentNode.parentNode.rows[rowIndex + 1];
  if (newRow) {
      const newCell = newRow.cells[cell.cellIndex];
      if (newCell) {
          newCell.focus();
      }
  }
}

function increaseColumn(cell) {
  const cellIndex = cell.cellIndex;
  const newRow = cell.parentNode;
  const newCell = newRow.cells[cellIndex + 1];
  if (newCell) {
      newCell.focus();
  }
}

