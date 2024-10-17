<?php
include './setting.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Redirect to an error page or homepage
    header('Location: payment.php');
    exit();
}

if (!isset($_SESSION['enquire_data'])) {
    header("Location: payment.php");
    exit();
}

function sanitizeInput($array, $key, $defValue = '')
{
    if (isset($array[$key])) {
        // Remove leading/trailing whitespace, backslashes, and HTML control characters
        return htmlspecialchars(trim(stripslashes($array[$key])));
    }
    return $defValue;
}

$enquire_data = isset($_SESSION['enquire_data']) ? $_SESSION['enquire_data'] : [];
$payment_data = $_POST;

$first_name = sanitizeInput($enquire_data, 'first_name');
$last_name = sanitizeInput($enquire_data, 'last_name');
$state = sanitizeInput($enquire_data, 'state');
$postcode = sanitizeInput($enquire_data, 'postcode');
$email = sanitizeInput($enquire_data, 'email');
$street = sanitizeInput($enquire_data, 'address');
$suburb = sanitizeInput($enquire_data, 'suburb');
$phone = sanitizeInput($enquire_data, 'phone');
$contact_method = sanitizeInput($enquire_data, 'contact_method');
$product = sanitizeInput($enquire_data, 'product');
// $product_features = sanitizeInput($enquire_data, 'product_features');
// $comments = sanitizeInput($enquire_data, 'comments');
$totalAmount = sanitizeInput($enquire_data, 'totalAmount');
$productPrice = sanitizeInput($enquire_data, 'productPrice');


$cardName = sanitizeInput($payment_data, 'cardname');
$cardtype = sanitizeInput($payment_data, 'cardtype');
$expirydate = sanitizeInput($payment_data, 'expirydate');
$cvv = sanitizeInput($payment_data, 'cvv');
$cardNumber = sanitizeInput($payment_data, 'cardnumber');


$customer_name = $first_name . ' ' . $last_name;
$customer_email = sanitizeInput($enquire_data, 'email');
$product_name = sanitizeInput($enquire_data, 'product');
$quantity = sanitizeInput($enquire_data, 'quantity');
$order_cost = sanitizeInput($enquire_data, 'totalAmount');
$order_status = sanitizeInput($enquire_data, 'status', 'PENDING');

//validate all fields
$error = [];

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
if (empty($street) || $street == null || strlen($street) > 40) {
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


// Validate card name
if (!preg_match("/^[a-zA-Z ]{1,40}$/", $cardName)) {
    $errors[] = "Invalid name on card. Only letters and spaces allowed, up to 40 characters.";
}

// Validate card number
if (!preg_match("/^\d{15,16}$/", $cardNumber)) {
    $errors[] = "Invalid card number. It must be 15 or 16 digits.";
}

// Validate expiry date
if (!preg_match("/^(0[1-9]|1[0-2])-[0-9]{2}$/", $expirydate)) {
    $errors[] = "Invalid expiry date. Format must be MM-YY.";
}

// Validate CVV
if (!preg_match("/^\d{3}$/", $cvv)) {
    $errors[] = "Invalid CVV. It must be 3 digits.";
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

if(empty($errors)){
    

    // SQL to create 'orders' table if it doesn't exist
    $table_sql = "CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255),
    customer_email VARCHAR(255),
    product_name VARCHAR(255),
    product_quantity INT,
    payment_method VARCHAR(50),
    order_cost DECIMAL(10, 2) NOT NULL,
    order_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    order_status ENUM('PENDING', 'FULFILLED', 'PAID', 'ARCHIVED') DEFAULT 'PENDING' )";

// Execute the SQL to create the table
if ($conn->query($table_sql) !== TRUE) {
    // die("Error creating table: " . $conn->error);
}

$inset_order = "INSERT INTO orders (customer_name, customer_email, product_name, product_quantity, payment_method, order_cost, order_status)
VALUES ('" . $customer_name . "', '" . $customer_email . "', '" . $product_name . "', " . $quantity . ", '" . $cardtype . "', " . $order_cost . ", '" . $order_status . "');";

$data = $conn->query($inset_order);

$last_id = $conn->insert_id;

$conn->close();
$_SESSION['oredr_id']=$last_id;
header("Location: receipt.php");
exit();


}else{
    // echo '<pre>';
    // print_r($errors);
    foreach($error as $rr){
        echo $err;
        echo '<br>';
    }
    
    $_SESSION['error']=$errors;
    $_SESSION['payment_data']=$payment_data;
    // header("Location: payment.php");
    // exit();
    
} ?>
<a href="payment.php"><button>Back to payment page</button>