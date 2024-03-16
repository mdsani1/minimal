/**
 * Initializes event listeners on document load to enhance table functionality
 * with keyboard shortcuts for an editable class.
 */
document.addEventListener('DOMContentLoaded', () => {
    // Attaching keydown event listener to the whole document
    document.addEventListener('keydown', handleTableKeydown);
});

/**
 * Handles keydown events within the context of editable tables.
 * This function supports cell navigation, row/column addition, style toggling, and more, 
 * while avoiding conflicts with common text editing shortcuts.
 * 
 * @param {KeyboardEvent} event - The keydown event object.
 */
function handleTableKeydown(event) {
    const target = event.target;
    const key = event.key.toLowerCase();
    // Support for both Ctrl (Windows/Linux) and Cmd (Mac)
    const ctrlOrCmd = event.ctrlKey || event.metaKey;

    // Ensure the event originates from a cell within an editable table
    if (!target.matches('.editable td, .editable th')) return;

    switch (true) {
        // Navigate to the next or previous cell
        case key === 'tab' && !event.shiftKey:
        case key === 'tab' && event.shiftKey:
            event.preventDefault(); // Prevent default tab behavior
            const direction = event.shiftKey ? 'previous' : 'next';
            moveFocus(target, direction);
            break;
        
        // Add a new row with Alt + R
        case event.altKey && key === 'r':
            event.preventDefault();
            addRow(target.closest('.editable'));
            break;
        
        // Add a new column with Alt + C
        case event.altKey && key === 'c':
            event.preventDefault();
            addColumn(target.closest('.editable'));
            break;
        
        // Scroll to the top with Alt + T
        case event.altKey && key === 't':
            event.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            break;
        
        // Show PDF preview with Alt + P
        case event.altKey && key === 'p':
            event.preventDefault();
            generateAndShowPdfPreview();
            break;
        
        // Handle keydown events for Ctrl/Cmd + B, I, U
        case ctrlOrCmd && (key === 'b' || key === 'i' || key === 'u'):
            event.preventDefault(); // Prevent default browser behavior
            // Map the keys to the corresponding execCommand commands
            const commandMap = { 'b': 'bold', 'i': 'italic', 'u': 'underline' };
            const command = commandMap[key];
            // Execute the command for the selected text
            document.execCommand(command, false, null);
            break;

    }
}


/**
 * Moves the focus to the next or previous cell in an editable table.
 * @param {HTMLElement} currentCell - The currently focused table cell.
 * @param {String} direction - The direction to move ('next' or 'previous').
 */
function moveFocus(currentCell, direction) {
    const cells = Array.from(currentCell.closest('.editable').querySelectorAll('td, th'));
    const currentIndex = cells.indexOf(currentCell);
    const nextIndex = direction === 'next' ? (currentIndex + 1) % cells.length : (currentIndex - 1 + cells.length) % cells.length;
    cells[nextIndex].focus();
}

/**
 * Adds a new row to the specified table.
 * @param {HTMLElement} table - The table to which a row will be added.
 */
function addRow(table) {
    const tableBody = table.querySelector('tbody');
    const columnCount = table.querySelector('tr').children.length;
    const newRow = document.createElement('tr');

    for (let i = 0; i < columnCount; i++) {
        const newCell = document.createElement('td');
        newCell.contentEditable = 'true';
        newCell.textContent = '-';
        newRow.appendChild(newCell);
    }

    tableBody.appendChild(newRow);
}

/**
 * Adds a new column to the specified table.
 * @param {HTMLElement} table - The table to which a column will be added.
 */
function addColumn(table) {
    const rows = table.querySelectorAll('tr');
    
    rows.forEach((row, index) => {
        const newCell = document.createElement(index === 0 ? 'th' : 'td');
        newCell.contentEditable = 'true';
        newCell.textContent = index === 0 ? 'New Header' : '-';
        row.appendChild(newCell);
    });
}


function toggleStyle(element, styleProperty, activeValue, inactiveValue) {
    const currentStyle = window.getComputedStyle(element)[styleProperty];
    element.style[styleProperty] = currentStyle !== activeValue ? activeValue : inactiveValue;
}
