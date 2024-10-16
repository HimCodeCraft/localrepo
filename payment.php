<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <title>4K Beast - Product Payment</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="description" content="Confirm your 4K Ultra HD TV purchase">
    <meta name="keywords" content="4K TV, Payment, Credit Card, Ultra HD, Smart TV">
    <meta name="author" content="Taniksha Dabral">
</head>

<body>
    <header>
        <nav class="NavBar">
            <a href="index.html" class="logo">
                <img src="images/4Klogo.png" alt="4K Beast Logo">
            </a>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="product.html">Products</a></li>
                <li><a href="enquire.html">Enquire</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="payment.html">Payement</a></li>
                <li><a href="enhancement.html">Enhancements</a></li>
            </ul>
        </nav>
    </header> -->
    <?php 
    include('header.inc'); 

    // Function to sanitize input
    function sanitizeInput($data)
    {
        $data = trim($data); // Remove leading and trailing spaces
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Extract and sanitize POST data
        $cardType = sanitizeInput($_POST['cardtype']);
        $cardName = sanitizeInput(trim($_POST['cardname']));
        $cardNumber = sanitizeInput(trim($_POST['cardnumber']));
        $expiryDate = sanitizeInput(trim($_POST['expirydate']));
        $cvv = sanitizeInput(trim($_POST['cvv']));

        // Validation flags
        $errors = [];

        // Validate card name
        if (!preg_match("/^[a-zA-Z ]{1,40}$/", $cardName)) {
            $errors[] = "Invalid name on card. Only letters and spaces allowed, up to 40 characters.";
        }

        // Validate card number
        if (!preg_match("/^\d{15,16}$/", $cardNumber)) {
            $errors[] = "Invalid card number. It must be 15 or 16 digits.";
        }

        // Validate expiry date
        if (!preg_match("/^(0[1-9]|1[0-2])-[0-9]{2}$/", $expiryDate)) {
            $errors[] = "Invalid expiry date. Format must be MM-YY.";
        }

        // Validate CVV
        if (!preg_match("/^\d{3}$/", $cvv)) {
            $errors[] = "Invalid CVV. It must be 3 digits.";
        }

        // Handle errors
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p style='color:red;'>$error</p>";
            }
            // Provide a link to go back to the payment page
            echo "<a href='payment.php'>Go back to payment page</a>";
            exit();
        }

        // If no errors, process the payment (here you would integrate with payment API)
        // ...

        echo "<h2>Payment processed successfully!</h2>";
        // Here you can display further confirmation or redirect to a success page.
        exit(); // Stop further execution after processing
    }
    ?>

    <main id="Page-payment">
        <h1>Payment Confirmation</h1>


        <!-- Display the stored form data -->
        <div>
            <h2>Order Summary</h2>
            <p>First Name: <span id="firstnameDisplay"></span></p>
            <p>Last Name: <span id="lastnameDisplay"></span></p>
            <p>Email: <span id="emailDisplay"></span></p>
            <p>Street Address: <span id="streetDisplay"></span></p>
            <p>Suburb/Town: <span id="suburbDisplay"></span></p>
            <p>State: <span id="stateDisplay"></span></p>
            <p>Postcode: <span id="postcodeDisplay"></span></p>
            <p>Phone Number: <span id="phoneDisplay"></span></p>
            <p>Preferred Contact Method: <span id="contactMethodDisplay"></span></p>
            <p>Product: <span id="productDisplay"></span></p>
            <p>Quantity: <span id="quantityDisplay"></span></p>
            <p>Total Amount: $<span id="totalAmountDisplay"></span></p>
        </div>

        <!-- Credit card payment details form -->
        <form id="paymentForm" action="https://mercury.swin.edu.au/it000000/formtest.php" method="post" novalidate="novalidate">
            <div id="errorMessages" style="color: red;"></div>
            <fieldset>
                <legend>Credit Card Payment</legend>

                <div class="OuterBoxes">
                    <label for="cardtype">Credit Card Type:</label>
                    <select id="cardtype" name="cardtype" required>
                        <option value="" disabled selected>Select Card Type</option>
                        <option value="visa">Visa</option>
                        <option value="mastercard">Mastercard</option>
                        <option value="amex">American Express</option>
                    </select>
                </div>

                <div class="OuterBoxes">
                    <label for="cardname">Name on Card:</label>
                    <input type="text" id="cardname" name="cardname" maxlength="40" required>
                </div>

                <div class="OuterBoxes">
                    <label for="cardnumber">Card Number:</label>
                    <input type="text" id="cardnumber" name="cardnumber" placeholder="Enter card number" required>
                </div>

                <div class="OuterBoxes">
                    <label for="expirydate">Expiry Date (MM-YY):</label>
                    <input type="text" id="expirydate" name="expirydate" placeholder="MM-YY" required>
                </div>

                <div class="OuterBoxes">
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" maxlength="3" required>
                </div>
            </fieldset>

            <div class="OuterBoxes">
                <input type="submit" value="Check-Out">
            </div>
        </form>

        <div class="OuterBoxes">
            <button onclick="window.location.href='index.html';">Cancel Order</button>
        </div>
    </main>
    <br><br>
    <?php include('footer.inc'); ?>


    <script src="scripts/payment.js"></script> <!-- Link to  new payment validation JS file -->
</body>

</html>