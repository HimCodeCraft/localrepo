<a href="index.php"><button>Back to home page</button>
<?php

session_start();
if(!isset($_SESSION['oredr_id'])){
    header("Location: payment.php");
    exit();
}
session_destroy();

include('./setting.php');

$order_id=$_SESSION['oredr_id'];

$select_order = 'SELECT * FROM orders WHERE order_id="'.$order_id.'"';

$result = $conn->query($select_order);
$orderDetails=[];
if ($result->num_rows > 0) {
    // Fetch the user data
    $orderDetails = $result->fetch_assoc();
} else{
    die('something whent wrong');
}

?>

<table>
<thead>
    <tr>
        <th>column</th>
        <th>Value</th>
    </tr>
</thead>
<tbody>
<?php 
foreach ($orderDetails as $field => $value): ?>
        <tr>
            <td><?php echo htmlspecialchars($field); ?></td>
            <td><?php echo htmlspecialchars($value); ?></td>
        </tr>
        <?php endforeach; ?>

</tbody>
</table>