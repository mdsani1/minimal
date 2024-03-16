function showSuggestions(cell, suggestions) {
    const existingDropdown = cell.querySelector('.autosuggestion-dropdown');
    if (existingDropdown) {
        existingDropdown.remove(); // Ensure only one dropdown is present at a time
    }

    const dropdown = createDropdown(cell, suggestions);

    // Position the dropdown beneath the cell
    const cellRect = cell.getBoundingClientRect();

    // Show the dropdown
    dropdown.style.display = 'block';

    // Keyboard navigation
    let currentIndex = -1; // Initialize with no item focused

    // Ensure event listeners are not duplicated
    cell.removeEventListener('keydown', handleCellKeydown);
    cell.addEventListener('keydown', handleCellKeydown);

    function handleCellKeydown(event) {
        const items = dropdown.querySelectorAll('li');
        // Check if the key pressed is a number and corresponds to the suggestions list
        if (!isNaN(event.key) && event.key > 0 && event.key <= items.length) {
            event.preventDefault(); // Prevent the default action
            const index = parseInt(event.key, 10) - 1; // Convert key number to index
            const selectedItem = items[index];
            if (selectedItem) {
                selectedItem.click(); // Trigger the click event on the item
            }
        } else {
            switch (event.key) {
                case 'ArrowDown':
                    event.preventDefault(); // Prevent scrolling
                    currentIndex = (currentIndex + 1) % items.length; // Loop to first
                    updateFocus(items, currentIndex);
                    break;
                case 'ArrowUp':
                    event.preventDefault(); // Prevent scrolling
                    currentIndex = (currentIndex - 1 + items.length) % items.length; // Loop to last
                    updateFocus(items, currentIndex);
                    break;
                case 'Enter':
                    if (currentIndex >= 0) {
                        event.preventDefault(); // Prevent form submission
                        items[currentIndex].click(); // Simulate a click on the focused item
                    }
                    break;
                // Add additional cases if needed
            }
        }
    }
}

// Function to create a dropdown for suggestions
function createDropdown(cell, suggestions) {
    const dropdown = document.createElement('div');
    dropdown.classList.add('autosuggestion-dropdown');

    // Set the width of the dropdown to match the cell width
    const cellWidth = cell.offsetWidth;
    dropdown.style.width = `${cellWidth}px`;

    // Create and append suggestion list
    const suggestionList = document.createElement('ul');
    suggestions.forEach(suggestion => {
        const suggestionItem = document.createElement('li');
        suggestionItem.textContent = suggestion;
        suggestionItem.addEventListener('click', () => {
            // Update the content of the cell with the selected suggestion
            cell.innerText = suggestion;
            // Hide suggestions dropdown
            hideSuggestions(cell);

            // If the cell corresponds to the "ITEM" column, show suggestions for "SPECIFICATION" column
            if (cell.cellIndex === 1) {
                const specificationCell = cell.parentElement.querySelector('.specification');
                const specificationSuggestions = getSpecificationSuggestions(suggestion); // You need to implement this function
                showSuggestions(specificationCell, specificationSuggestions);
            }
        });
        suggestionList.appendChild(suggestionItem);
    });

    dropdown.appendChild(suggestionList);
    cell.appendChild(dropdown);
    return dropdown;
}

// Function to get suggestions for specification based on the selected item
function getSpecificationSuggestions(selectedItem) {
    // Here you would implement your logic to fetch suggestions for specifications based on the selected item
    // For demonstration, let's assume you have a predefined map of items to specifications
    const itemToSpecifications = {
        "Item 1": ["Spec 1", "Spec 2", "Spec 3"],
        "Item 2": ["Spec A", "Spec B", "Spec C"]
        // Add more mappings as needed
    };

    // Return the specifications for the selected item
    return itemToSpecifications[selectedItem] || [];
}
