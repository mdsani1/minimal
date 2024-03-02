// document.addEventListener('DOMContentLoaded', function() {
//     const table = document.getElementById('editableTable'); // Assuming your table has this ID

//     table.addEventListener('keydown', function(event) {
        
//         const target = event.target;
//         const key = event.key.toLowerCase();
//         const ctrlOrCmd = event.ctrlKey || event.metaKey; // Support for both Ctrl (Windows/Linux) and Cmd (Mac)

//         if (target.tagName === 'TD' || target.tagName === 'TH') {
//             if (key === 'Tab' && !event.shiftKey) {
//                 event.preventDefault(); // Prevent the default tab behavior
//                 moveFocus(target, 'next');
//             } else if (key === 'Tab' && event.shiftKey) {
//                 event.preventDefault(); // Prevent the default shift+tab behavior
//                 moveFocus(target, 'previous');
//             }
//         }

//         if (target.tagName !== 'TD' && target.tagName !== 'TH') return; // Ensure we're only applying styles to table cells

//         // Check for Shift + R to add a row, case-insensitively
//         if (event.shiftKey && key === 'r') {
//             event.preventDefault(); // Prevent any default action to ensure it triggers the addRow function only
//             addRow(); // Call the addRow function to add a new row at the bottom
//         }

//         // Check for Shift + C to add a column, case-insensitively
//         if (event.shiftKey && key === 'c') {
//             event.preventDefault(); // Prevent any default action to ensure it triggers the addColumn function only
//             addColumn(); // Call the addColumn function to add a new column at the end
//         }

//         // Check for Shift + T to scroll to the top, case-insensitively
//         if (event.shiftKey && key === 't') {
//             event.preventDefault(); // Prevent any default action
//             window.scrollTo({top: 0, behavior: 'smooth'}); // Scroll to the top of the page smoothly
//         }

//          // Check for Shift + P to open the PDF preview, case-insensitively
//          if (event.shiftKey && key === 'p') {
//             event.preventDefault(); // Prevent any default action
//             generateAndShowPdfPreview(); // Call the function to generate and show PDF preview
//         }

//         // Toggle bold
//         if (ctrlOrCmd && key === 'b') {
//             event.preventDefault(); // Prevent default browser behavior
//             toggleStyle(target, 'fontWeight', 'bold', 'normal');
//         }
//         // Toggle italic
//         else if (ctrlOrCmd && key === 'i') {
//             event.preventDefault(); // Prevent default browser behavior
//             toggleStyle(target, 'fontStyle', 'italic', 'normal');
//         }
//         // Toggle underline
//         else if (ctrlOrCmd && key === 'u') {
//             event.preventDefault(); // Prevent default browser behavior
//             toggleStyle(target, 'textDecoration', 'underline', 'none');
//         }
//     });

//     function moveFocus(currentCell, direction) {
//         const cells = Array.from(document.querySelectorAll('#editableTable td, #editableTable th'));
//         const currentIndex = cells.indexOf(currentCell);
//         if (direction === 'next') {
//             const nextCell = cells[currentIndex + 1] || cells[0];
//             nextCell.focus();
//         } else if (direction === 'previous') {
//             const prevCell = cells[currentIndex - 1] || cells[cells.length - 1];
//             prevCell.focus();
//         }
//     }

//     function addRow() {
//         const tableBody = document.querySelector('#editableTable tbody');
//         const columnCount = document.querySelector('#editableTable tr').children.length;
//         const newRow = document.createElement('tr');

//         for (let i = 0; i < columnCount; i++) {
//             const newCell = document.createElement('td');
//             newCell.contentEditable = 'true';
//             newCell.textContent = '-'; // or any default content you want
//             newRow.appendChild(newCell);
//         }

//         tableBody.appendChild(newRow);
//     }

//     // Function to add a new column to the table
//     function addColumn() {
//         const rows = document.querySelectorAll('#editableTable tr');
        
//         // Iterate over each row in the table to add a new cell
//         rows.forEach((row, index) => {
//             if (index === 0) { // Assuming the first row is the header
//                 const headerCell = document.createElement('th');
//                 headerCell.textContent = 'New Header'; // Set header text or leave blank
//                 headerCell.contentEditable = 'true';
//                 row.appendChild(headerCell);
//             } else {
//                 const newCell = document.createElement('td');
//                 newCell.contentEditable = 'true';
//                 newCell.textContent = '-'; // or any default content you want for new cells
//                 row.appendChild(newCell);
//             }
//         });
//     }

//     function toggleStyle(element, styleProperty, activeValue, inactiveValue) {
//         const currentStyle = window.getComputedStyle(element)[styleProperty];
//         element.style[styleProperty] = currentStyle !== activeValue ? activeValue : inactiveValue;
//     }
// });
