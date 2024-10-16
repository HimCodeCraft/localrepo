/* Filename: payment.js
   Purpose :  java script reffere payment.html 
   Target html: payment.html
   Author: Taniksha Dabral
   Date written: 19/09/2024
   revise :24/09/2024
*/
'use strict';
document.addEventListener('DOMContentLoaded', function () {
    // Show the stored form data from localStorage, mate
    var storedData = localStorage.getItem('enquiryFormData');
    if (storedData) {
        var formData = JSON.parse(storedData);
        document.getElementById('firstnameDisplay').textContent = formData.firstname; // Depict first name
        document.getElementById('lastnameDisplay').textContent = formData.lastname; // Depict last name
        document.getElementById('emailDisplay').textContent = formData.email; // Show email
        document.getElementById('streetDisplay').textContent = formData.street; // Depictstreet address
        document.getElementById('suburbDisplay').textContent = formData.suburb; // Depict suburb
        document.getElementById('stateDisplay').textContent = formData.state; // Depict state
        document.getElementById('postcodeDisplay').textContent = formData.postcode; // Show postcode
        document.getElementById('phoneDisplay').textContent = formData.phone; // Show phone number
        document.getElementById('contactMethodDisplay').textContent = formData.contactMethod; // Depict contact method
        document.getElementById('productDisplay').textContent = formData.product; // Show product
        document.getElementById('quantityDisplay').textContent = formData.quantity; // Show quantity
        document.getElementById('totalAmountDisplay').textContent = formData.totalAmount; // Show total amount
    }

    // Set up the submit event listener for the payment form, righto
    document.getElementById('paymentForm').addEventListener('submit', function (event) {
        var errorMessages = validateCreditCard(); // Run the credit card validation, no worries
        var errorContainer = document.getElementById('errorMessages');
        errorContainer.innerHTML = ''; // Clear any old error messages, mate

        if (errorMessages.length > 0) {
            event.preventDefault(); // Don't let the form go through if there are errors
            errorMessages.forEach(function (msg) {
                var errorMsg = document.createElement('p');
                errorMsg.textContent = msg; // Add the error message to the container
                errorContainer.appendChild(errorMsg);
            });
        }
    });
});

// Function tooo validate credit crd details, give it a go
function validateCreditCard() {
    var cardType = document.getElementById('cardtype').value; // Get the card type
    var cardNumber = document.getElementById('cardnumber').value; // Get the card number
    var cardName = document.getElementById('cardname').value; // Get the namee on the caard
    var expiry = document.getElementById('expirydate').value; // Get the expiiiiry date
    var cvv = document.getElementById('cvv').value; // Get the CVV
    var errorMessages = []; // Set up an array for any error messages

    // Validate card number based on card type, mate
    if (cardType === "visa") {
        if (cardNumber.length !== 16 || !cardNumber.startsWith("4")) {
            errorMessages.push("isssue with your no., mate.");
        }
    } else if (cardType === "mastercard") {
        if (cardNumber.length !== 16 || !/^[5][1-5]/.test(cardNumber)) {
            errorMessages.push("isssue with your no., alright?");
        }
    } else if (cardType === "amex") {
        if (cardNumber.length !== 15 || !/^(34|37)/.test(cardNumber)) {
            errorMessages.push("isssue with your no., cheers.");
        }
    }

    // Validate name on the card, keep it clean
    if (!/^[A-Za-z\s]{1,40}$/.test(cardName)) {
        errorMessages.push("check please your cardname, mate.");
    }

    // Validate expiry date (MM-YY), don't muck it up
    if (!/^\d{2}-\d{2}$/.test(expiry)) {
        errorMessages.push("your format is not correct bro it should be MM-YY format, got it?");
    }

    // Validate CVV (3 digits), simple as that
    if (!/^\d{3}$/.test(cvv)) {
        errorMessages.push("cVV invalid, mate.");
    }

    return errorMessages; // Return any validation messages
}
