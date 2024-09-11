// autosuggestions.js
let specificationData = [];

// Function to show suggestions in a dropdown
function showSuggestions(cell, suggestions) {
    const existingDropdown = cell.querySelector('.autosuggestion-dropdown');
    if (existingDropdown) {
        existingDropdown.remove(); // Ensure only one dropdown is present at a time
    }

    const dropdown = createDropdown(cell, suggestions);

    // Position the dropdown beneath the cell
    // const cellRect = cell.getBoundingClientRect();
    // dropdown.style.top = `10px`;
    // dropdown.style.top = `${cellRect.bottom}px`;
    // dropdown.style.left = `${cellRect.left}px`;

    // Calculate and set the position of the dropdown
    const cellRect = cell.getBoundingClientRect();
    dropdown.style.position = 'absolute';
    dropdown.style.left = `${cellRect.right + window.scrollX}px`;
    dropdown.style.top = `${cellRect.top + window.scrollY}px`;

    // Show the dropdown
    dropdown.style.zIndex = '1000'; // Ensure the dropdown appears above other elements

    // Show the dropdown using visibility
    dropdown.style.visibility = 'visible';
    dropdown.style.opacity = '1';
    dropdown.style.pointerEvents = 'auto';

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

// Function to hide suggestions dropdown
function hideSuggestions(cell) {
    const dropdown = cell.querySelector('.autosuggestion-dropdown');
    if (dropdown) {
        dropdown.remove(); // Remove the dropdown
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
        suggestionItem.innerHTML = suggestion;
        suggestionItem.addEventListener('click', () => {
            cell.innerHTML = suggestion;
            hideSuggestions(cell);
            loadSpecificationData(cell);
        });
        suggestionList.appendChild(suggestionItem);
    });

    dropdown.appendChild(suggestionList);
    cell.appendChild(dropdown);
    return dropdown;
}

// Function to visually indicate and scroll to the focused suggestion item
function updateFocus(items, index) {
    items.forEach(item => {
        item.classList.remove('focused'); // Remove focus from all items
    });

    const focusedItem = items[index];
    focusedItem.classList.add('focused');
    focusedItem.scrollIntoView({ block: 'nearest', behavior: 'smooth' }); // Ensure the focused item is visible
}

function getSuggestions(inputValue, cellIndex) {
    // Define suggestion lists for each column
    const suggestionsForColumn = {
        1: suggestionData,
        // Add suggestions for the third column if needed
        2: specificationData
    };

    // Get suggestions based on the cell index
    let columnSuggestions = suggestionsForColumn[cellIndex] || [];

    // Filter suggestions based on the input value
    // let filteredSuggestions = columnSuggestions.filter(item => 
    //     item.toLowerCase().startsWith(inputValue.toLowerCase())
    // );

    let filteredSuggestions = columnSuggestions.filter(item => 
        item.toLowerCase().includes(inputValue.toLowerCase())
    );

    return filteredSuggestions;
}


function selectSuggestionByNumber(number, items) {
    // Convert the key to a 0-based index
    const index = parseInt(number, 10) - 1;
    const selectedItem = items[index];
    if (selectedItem) {
        selectedItem.click(); // Select the corresponding suggestion
    }
}

function loadSpecificationData(cell) {
    const parentTR = $(cell).closest('tr'); 
    const parentTbody = $(cell).closest('tbody'); 
    $.ajax({
        method: "GET",
        url: "/api/get/specification/" + cell.innerText.trim(),
        dataType: "json",
        async: false, // Make the AJAX request synchronous
        success: function (response) {
            if (response.suggestions.length > 1) {
                specificationData = response.suggestions;
            } else {
                // Set the dimensionText to the .specification element of the parentTR
                parentTR.find('.specification').html(response.suggestions[0]);
            }

            // Retrieve dimensions from response
            let lengthFeet = parseFloat(response.interior.length_feet);
            let lengthInches = parseFloat(response.interior.length_inche);
            let widthFeet = parseFloat(response.interior.width_feet);
            let widthInches = parseFloat(response.interior.width_inche);

            // Check if any of the values are NaN (Not a Number)
            // Convert dimensions to inches
            let lengthTotalInches = lengthFeet * 12 + lengthInches;
            let widthTotalInches = widthFeet * 12 + widthInches;

            // Calculate the area in square inches
            let areaInSquareInches = lengthTotalInches * widthTotalInches;

            // Convert square inches to square feet
            let areaInSquareFeet = areaInSquareInches / 144;

            let amount = (areaInSquareFeet * parseFloat(response.interior.rate)).toFixed(2);

            if (isNaN(areaInSquareFeet)) {
                parentTR.find('.qty').text();
                parentTR.find('.rate').text(response.interior.rate);
                parentTR.find('.unit').text(response.interior.unit);
            }else{
                parentTR.find('.qty').text(areaInSquareFeet.toFixed(2));
                parentTR.find('.rate').text(response.interior.rate);
                parentTR.find('.unit').text(response.interior.unit);
                parentTR.find('.amount').text(amount);
            }

            // Calculate and update grand total
            let grandTotal = 0;
            $(parentTbody).find('.amount').each(function() {
                if (!isNaN(parseFloat($(this).text()))) {
                    grandTotal += parseFloat($(this).text());
                }
            });

            // Update the grand total in the footer
            $(parentTbody).closest('table').find('.grandTotal').text(grandTotal.toFixed(2));

        },
        error: function (xhr, status, error) {
            // Handle errors
            console.error('Error:', error);
        }
    });
}

function getCellTextWithoutDropdown(cell) {
    let text = '';
    cell.childNodes.forEach(node => {
        if (node.nodeType === Node.TEXT_NODE) {
            text += node.textContent.trim();
        }
    });
    return text.toLowerCase();
}

$(document).ready(function () {

    // Declare specificationData variable

    $.ajax({
        method: "GET",
        url: "/api/suggestions",
        dataType: "json",
        async: false, // Make the AJAX request synchronous
        success: function (response) {
            suggestionData = response;
        },
        error: function (xhr, status, error) {
            // Handle errors
            console.error('Error:', error);
        }
    });

    // Attach event listener to the table, delegating to the 'td' elements
    $('.editableTable').on('input click', 'td', function() {
        const cell = this; // 'this' refers to the 'td' element that received the input
        const inputValue = getCellTextWithoutDropdown(cell);
        const cellIndex = cell.cellIndex; // cellIndex is 0-based
        const suggestions = getSuggestions(inputValue, cellIndex);
        if(inputValue.length > 0){
            if (suggestions.length > 0) {
                
                showSuggestions(cell, suggestions);
            } else {
                hideSuggestions(cell);
            }
        }else {
            hideSuggestions(cell);
        }
    });

    // ... other initialization code ...
});



