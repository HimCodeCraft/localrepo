<?php
// Start the session
session_start();

// Initialize an array to hold error messages
$errors = [];

// Function to sanitize input
function sanitizeInput($data) {
    // Remove leading/trailing whitespace, backslashes, and HTML control characters
    return htmlspecialchars(trim(stripslashes($data)));
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    echo '<pre>';
    print_r($_POST);
    die;
    // Check if the form fields are set and sanitize
    $first_name = isset($_POST['first_name']) ? sanitizeInput($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? sanitizeInput($_POST['last_name']) : '';
    $state = isset($_POST['state']) ? sanitizeInput($_POST['state']) : '';
    $postcode = isset($_POST['postcode']) ? sanitizeInput($_POST['postcode']) : '';
    $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
    $address = isset($_POST['address']) ? sanitizeInput($_POST['address']) : '';
    $suburb = isset($_POST['suburb']) ? sanitizeInput($_POST['suburb']) : '';
    $phone = isset($_POST['phone']) ? sanitizeInput($_POST['phone']) : '';
    $contact_method = isset($_POST['contact_method']) ? sanitizeInput($_POST['contact_method']) : '';
    $product = isset($_POST['product']) ? sanitizeInput($_POST['product']) : '';
    $product_features = isset($_POST['product_features']) ? $_POST['product_features'] : [];
    $comments = isset($_POST['comments']) ? sanitizeInput($_POST['comments']) : '';
    $quantity = isset($_POST['quantity']) ? sanitizeInput($_POST['quantity']) : '';

    // Validate inputs
    // First Name
    if (empty($first_name) || !preg_match("/^[a-zA-Z]{1,25}$/", $first_name)) {
        $errors[] = "First name must be alphabetical and a maximum of 25 characters.";
    }

    // Last Name
    if (empty($last_name) || !preg_match("/^[a-zA-Z]{1,25}$/", $last_name)) {
        $errors[] = "Last name must be alphabetical and a maximum of 25 characters.";
    }

    // State and Postcode validation
    if (!in_array($state, ['VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT'])) {
        $errors[] = "Please select a valid state.";
    }

    if (!preg_match("/^\d{4}$/", $postcode) || !isPostcodeValid($postcode, $state)) {
        $errors[] = "Postcode must be exactly 4 digits and match the selected state.";
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email address is not in a valid format.";
    }

    // Address validation
    if (empty($address) || strlen($address) > 40) {
        $errors[] = "Street address must be a maximum of 40 characters.";
    }

    // Suburb validation
    if (empty($suburb) || strlen($suburb) > 20) {
        $errors[] = "Suburb must be a maximum of 20 characters.";
    }

    // Phone validation
    if (!preg_match("/^\d{1,10}$/", $phone)) {
        $errors[] = "Phone number must be a maximum of 10 digits.";
    }

    // Quantity validation
    if (!filter_var($quantity, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
        $errors[] = "Product quantity must be a positive integer.";
    }

    // If there are no errors, store data in session and redirect
    if (empty($errors)) {

        /*$_SESSION['user_data'] = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'state' => $state,
            'postcode' => $postcode,
            'email' => $email,
            'address' => $address,
            'suburb' => $suburb,
            'phone' => $phone,
            'contact_method' => $contact_method,
            'product' => $product,
            'product_features' => $product_features,
            'comments' => $comments,
            'quantity' => $quantity,
        ];


        // Redirect to payment.php
        header("Location: payment.php");
        exit(); */
    }
}

// Function to validate postcode against the state
function isPostcodeValid($postcode, $state) {
    $postcode_first_digit = substr($postcode, 0, 1);
    switch ($state) {
        case 'VIC':
            return in_array($postcode_first_digit, ['3', '8']);
        case 'NSW':
            return in_array($postcode_first_digit, ['1', '2']);
        case 'QLD':
            return in_array($postcode_first_digit, ['4', '9']);
        case 'NT':
            return $postcode_first_digit === '0';
        case 'WA':
            return $postcode_first_digit === '6';
        case 'SA':
            return $postcode_first_digit === '5';
        case 'TAS':
            return $postcode_first_digit === '7';
        case 'ACT':
            return $postcode_first_digit === '0';
        default:
            return false;
    }
}
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <title>4K Beast - Product Enquiry</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="description" content="Submit an enquiry for your desired 4K Ultra HD TV.">
    <meta name="keywords" content="4K TV, Ultra HD, Smart TV, LED TV, Product Enquiry, 4K Beast">
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
<?php include('./header.inc');
 ?>

    <main id="Page-enquiry">
        <h1>Product Enquiry Form</h1>
        
        <form id="myForm" action="payment.php" method="post" novalidate="novalidate">

            <div class="OuterBoxes">
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" maxlength="25" pattern="[A-Za-z]+" required>
            </div>
        

            
            <div class="OuterBoxes">
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" maxlength="25" pattern="[A-Za-z]+" required>
            </div>

            <div class="OuterBoxes">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <fieldset>
                <legend>Address</legend>
                
                <div class="OuterBoxes">
                    <label for="street">Street Address:</label>
                    <input type="text" id="street" name="street" maxlength="40" required>
                </div>
                
                <div class="OuterBoxes">
                    <label for="suburb">Suburb/Town:</label>
                    <input type="text" id="suburb" name="suburb" maxlength="20" required>
                </div>
                
                <div class="OuterBoxes">
                    <label for="state">State:</label>
                    <select id="state" name="state" required>
                        <option value="" disabled selected>Select your state</option>
                        <option value="VIC" data-postcode="3">VIC</option>
                        <option value="NSW" data-postcode="2">NSW</option>
                        <option value="QLD" data-postcode="4">QLD</option>
                        <option value="NT" data-postcode="0">NT</option>
                        <option value="WA" data-postcode="6">WA</option>
                        <option value="SA" data-postcode="5">SA</option>
                        <option value="TAS" data-postcode="7">TAS</option>
                        <option value="ACT" data-postcode="2">ACT</option>
                    </select>
                    
                </div>
                
                <div class="OuterBoxes">
                    <label for="postcode">Postcode:</label>
                    <input type="text" id="postcode" name="postcode" pattern="\d{4}" maxlength="4" required>
                </div>
            </fieldset>

            <div class="OuterBoxes">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" pattern="\d{10}" maxlength="10" placeholder="e.g. 0422229218" required>
            </div>

            <div class="OuterBoxes">
                <label>Preferred Contact Method:</label>
                <div>
                    <input type="radio" id="contact-email" name="contact" value="email" required>
                    <label for="contact-email">Email</label>
                </div>
                <div>
                    <input type="radio" id="contact-post" name="contact" value="post">
                    <label for="contact-post">Post</label>
                </div>
                <div>
                    <input type="radio" id="contact-phone" name="contact" value="phone">
                    <label for="contact-phone">Phone</label>
                </div>
            </div>

            <div class="OuterBoxes">
                <label for="product">Product:</label> <!-- Time to choose which ripper TV they want to buy -->

                <select id="product" name="product" required> <!---->
                    <option value="" disabled selected>Select a product</option> 
                    <option value="ultra-tv" data-price="1200" >Ultra 4K TV - $1,200</option>
                    <option value="led-tv" data-price="800">LED TV - $800</option>
                    <option value="smart-tv" data-price="950">Smart TV - $950</option>
                </select>
            </div>

            <div class="OuterBoxes">
                <label for="quantity" >Quantity:</label> <!---How many of our special do they want? Chucking the number in here -->

                <input type="number" id="productQuantity" name="quantity" min="1" value="1" required>
            </div>
            <div class="OuterBoxes">+
                <label for="quantity" >Product price</label> <!--How many of our special do they want? Chucking the number in here -->

                <input type="number" id="totalAmount" name="totalAmount" readonly required>
                <input type="hidden" id="productPrice" name="productPrice" >
            </div>





            <div class="OuterBoxes">
                <label>Product Features:</label> <!-- Selecting the extra bells and whistles my client want -->

                <div>
                    <input type="checkbox" id="feature-1" name="features" value="hdmi">
                    <label for="feature-1">HDMI Ports</label>
                </div>
                <div>
                    <input type="checkbox" id="feature-2" name="features" value="wifi">
                    <label for="feature-2">WiFi Connectivity</label>
                </div>
                <div>
                    <input type="checkbox" id="feature-3" name="features" value="smart">
                    <label for="feature-3">Smart Features</label>
                </div>
            </div>
<hr>


            <div class="OuterBoxes">
                <label>Additional Options:</label> <!-- Want extra warranty, installation, or delivery? Tick these boxes, mate -->

                <div>
                    <input type="checkbox" id="warranty" data-price="150"name="options" value="extended-warranty">
                    <label for="warranty">Extended Warranty (+$150)</label>
                </div>
                <div>
                    <input type="checkbox" id="installation" data-price="100"name="options" value="installation">
                    <label for="installation">Professional Installation (+$100)</label>
                </div>
                <div>
                    <input type="checkbox" id="delivery" data-price="50"name="options" value="delivery">
                    <label for="delivery">Home Delivery (+$50)</label>
                </div>
            </div>

            <div class="OuterBoxes">
                <label for="comments">Comments:</label>
                <textarea id="comments" name="comments" placeholder="Any specific requirement you are interested in"></textarea>
            </div>
            <div id="errorMessages" style="color: #c50000;"></div>
            <div class="OuterBoxes">
                <input type="submit" id="payButton" value="Pay Now"> <!-- Updated type to submit and id to payButton -->
            </div>
            
        </form>
    </main>
<br><br>
<?php include('footer.inc'); ?>
</body>
<script src="scripts/enquire.js"></script>
</html>
