
/* Filename: enquire.js
   Purpose : enhancemnet for enquire.html 
   Target html: enquire.html
   Author: Taniksha Dabral
   Date written: 19/09/2024
   revise :24/09/2024
*/

'use strict'; // U told in the lecture regarding variables 

// Update price based on the selected product
document.addEventListener("DOMContentLoaded", function() {
    let product = document.getElementById('product');
    
    // Event listener for product selection
    product.addEventListener('change', function () {
        updatePrice();
    });

    // Function to update price
    function updatePrice() {
        var productSelect = document.getElementById('product');
        var selectedOption = productSelect.options[productSelect.selectedIndex];
        var price = selectedOption.getAttribute('data-price');
        document.getElementById('productPrice').value = price;
        calculateTotal(); // Update total amount when product changes
    }

    // Calculate the total amount based on price and quantity
    let productQuantity = document.getElementById('productQuantity');
    productQuantity.addEventListener('change', function () {
        calculateTotal();
    });

    // Function to calculate total
    function calculateTotal() {
        var price = parseFloat(document.getElementById('productPrice').value) || 0; // Get price, default to 0
        var quantity = parseInt(document.getElementById('productQuantity').value) || 1; // Default quantity to 1
        var total = price * quantity;
        document.getElementById('totalAmount').value = total.toFixed(2); // Keep 2 decimal places
    }

    // Function to validate the enquiry form
    function validateEnquiryForm() {
        var firstname = document.getElementById('firstname').value;
        var lastname = document.getElementById('lastname').value;
        var email = document.getElementById('email').value;
        var street = document.getElementById('street').value;
        var suburb = document.getElementById('suburb').value;
        var state = document.getElementById('state').value;
        var postcode = document.getElementById('postcode').value;
        var phone = document.getElementById('phone').value;
        var errorMessages = [];

        // Validate required fields
        if (!firstname) errorMessages.push("First Name's gotta be in there, mate.");
        if (!lastname) errorMessages.push("Last Name's a must, mate.");
        if (!email) errorMessages.push("Don't forget the Email, alright?");
        if (!street) errorMessages.push("Street Address is needed, mate.");
        if (!suburb) errorMessages.push("Suburb/Town is a must, mate.");
        if (!state) errorMessages.push("State's gotta be sorted, mate.");
        if (!postcode) errorMessages.push("Postcode's gotta be there, mate.");
        if (!phone) errorMessages.push("Phone Number's essential, mate.");

        // Validate email format
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email && !emailPattern.test(email)) {
            errorMessages.push("Oi! Give us a proper email address.");
        }

        // Validate phone number format (10 digits)
        var phonePattern = /^\d{10}$/;
        if (phone && !phonePattern.test(phone)) {
            errorMessages.push("Phone Number's gotta be 10 digits, mate.");
        }

        // Define valid postcode prefixes for each state
        var validPostcodes = {
            VIC: ['3', '8'],
            NSW: ['1', '2'],
            QLD: ['4', '9'],
            NT: ['0'],
            WA: ['6'],
            SA: ['5'],
            TAS: ['7'],
            ACT: ['0']
        };

        // Validate postcode prefix against selected state
        if (state && postcode) {
            var postcodePrefix = postcode.charAt(0);
            if (!validPostcodes[state].includes(postcodePrefix)) {
                errorMessages.push("Check the above state; postcode doesn't match, mate.");
            }
        }

        // Display error messages if any
        if (errorMessages.length > 0) {
            document.getElementById('errorMessages').innerText = errorMessages.join("\n");
            return false; // Prevent form submission
        }

        return true; // Proceed with form submission
    }

    // Attach the validation function to the form's submit event
    document.getElementById('myForm').onsubmit = function(event) {
        if (!debug) return true;  //Disable js validation (debug is in header.inc)

        if (!validateEnquiryForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        } else {
            storeFormData(); // Store form data if validation is successful
        }
    };

    // Store form data to localStorage
    function storeFormData() {
        var formData = {
            firstname: document.getElementById('firstname').value,
            lastname: document.getElementById('lastname').value,
            email: document.getElementById('email').value,
            street: document.getElementById('street').value,
            suburb: document.getElementById('suburb').value,
            state: document.getElementById('state').value,
            postcode: document.getElementById('postcode').value,
            phone: document.getElementById('phone').value,
            contactMethod: document.querySelector('input[name="contact"]:checked')?.value, // Use optional chaining to avoid errors
            product: document.getElementById('product').value,
            quantity: document.getElementById('productQuantity').value,
            totalAmount: document.getElementById('totalAmount').value
        };

        // Save the form data to localStorage
        localStorage.setItem('enquiryFormData', JSON.stringify(formData));
    }

    // Initial call to set the price and total on page load
    updatePrice();
});
