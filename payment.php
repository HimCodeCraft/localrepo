<?php
include('header.inc');
session_start();
if (isset($_GET['process'])) {
    session_destroy();
    header("Location: enquire.php");
    exit();
}

$enquire_data = isset($_SESSION['enquire_data']) ? $_SESSION['enquire_data'] : [];

if (isset($_SESSION['error'])) {
    $errors = $_SESSION['error'];
    unset($_SESSION['error']);
}

$payment_data = isset($_SESSION['payment_data']) ? $_SESSION['payment_data'] : [];

function sanitizeInput($array, $key, $defValue = '')
{
    if (isset($array[$key])) {
        // Remove leading/trailing whitespace, backslashes, and HTML control characters
        return htmlspecialchars(trim(stripslashes($array[$key])));
    }
    return $defValue;
}
?>

<main id="Page-payment">
    <h1>Payment Confirmation</h1>
    
    <!-- Display the stored form data -->
    <div>
        <h2>Order Summary</h2>
        <p>First Name: <span id="firstnameDisplay"><?php echo sanitizeInput($enquire_data, 'first_name') ?> </span></p>
        <p>Last Name: <span id="lastnameDisplay"><?php echo sanitizeInput($enquire_data, 'last_name') ?> </span></p>
        <p>Email: <span id="emailDisplay"><?php echo sanitizeInput($enquire_data, 'email') ?> </span></p>
        <p>Street Address: <span id="streetDisplay"><?php echo sanitizeInput($enquire_data, 'address') ?> </span></p>
        <p>Suburb/Town: <span id="suburbDisplay"><?php echo sanitizeInput($enquire_data, 'suburb') ?> </span></p>
        <p>State: <span id="stateDisplay"><?php echo sanitizeInput($enquire_data, 'state') ?> </span></p>
        <p>Postcode: <span id="postcodeDisplay"><?php echo sanitizeInput($enquire_data, 'postcode') ?> </span></p>
        <p>Phone Number: <span id="phoneDisplay"><?php echo sanitizeInput($enquire_data, 'phone') ?> </span></p>
        <p>Preferred Contact Method: <span id="contactMethodDisplay"><?php echo sanitizeInput($enquire_data, 'contact_method') ?> </span></p>
        <p>Product: <span id="productDisplay"><?php echo sanitizeInput($enquire_data, 'product') ?> </span></p>
        <p>Quantity: <span id="quantityDisplay"><?php echo sanitizeInput($enquire_data, 'quantity') ?> </span></p>
        <p>Total Amount: $<span id="totalAmountDisplay"><?php echo sanitizeInput($enquire_data, 'totalAmount') ?> </span></p>
    </div>

    <!-- Credit card payment details form -->
    <!-- <form id="paymentForm" action="https://mercury.swin.edu.au/it000000/formtest.php" method="post" novalidate="novalidate"> -->
    <form id="paymentForm" action="process_order.php" method="post" novalidate="novalidate">
        <div id="errorMessages" style="color: red;">
            <?php
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p style='color:red;'>$error</p>";
                }
            }
            ?>
        </div>
        <fieldset>
            <legend>Credit Card Payment</legend>

            <div class="OuterBoxes">
                <label for="cardtype">Credit Card Type:</label>
                <select id="cardtype" name="cardtype" required>
                    <!-- <option value="" disabled selected>Select Card Type</option> -->
                    <option value="visa">Visa</option>
                    <option value="mastercard">Mastercard</option>
                    <option value="amex">American Express</option>
                </select>
            </div>

            <div class="OuterBoxes">
                <label for="cardname">Name on Card:</label>
                <input type="text" id="cardname" name="cardname" maxlength="40" value="<?php echo sanitizeInput($payment_data, 'cardname') ?>" required>
            </div>

            <div class="OuterBoxes">
                <label for="cardnumber">Card Number:</label>
                <input type="text" id="cardnumber" name="cardnumber" placeholder="Enter card number" value="<?php echo sanitizeInput($payment_data, 'cardnumber') ?>" required>
            </div>

            <div class="OuterBoxes">
                <label for="expirydate">Expiry Date (MM-YY):</label>
                <input type="text" id="expirydate" name="expirydate" placeholder="MM-YY" value="<?php echo sanitizeInput($payment_data, 'expirydate') ?>" required>
            </div>

            <div class="OuterBoxes">
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" maxlength="3" value="<?php echo sanitizeInput($payment_data, 'cvv') ?>" required>
            </div>
        </fieldset>

        <div class="OuterBoxes">
            <input type="submit" value="Check-Out">
        </div>
    </form>

    <div class="OuterBoxes">
        <!-- <button onclick="window.location.href='payment.php?process=cancel';">Cancel Order</button> -->
        <a href="payment.php?process=cancel"><button>Cancel Order</button>
        </a>
    </div>
</main>
<br><br>

<script src="scripts/payment.js"></script> <!-- Link to  new payment validation JS file -->
<?php include('footer.inc'); ?>

