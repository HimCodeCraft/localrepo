<!DOCTYPE html>
<html lang="en">

<head>
    <title>4K Beast - The Ultimate 4K Experience</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="description" content="Explore 4K Ultra HD TVs, with stunning clarity and immersive features.">
    <meta name="keywords" content="4K TV, Ultra HD, Smart TV, LED TV, 4K Beast">
    <meta name="author" content="Taniksha Dabral">
</head>

<body>

    <header>
        <a href="index.php"><button>Back to home page</button> </a>
    </header>
    
    <?php
    session_start();
    if (!isset($_SESSION['oredr_id'])) {
        header("Location: payment.php");
        exit();
    }
    // session_destroy();  // please uncomment it

    include('./setting.php');

    $order_id = $_SESSION['oredr_id'];

    $select_order = 'SELECT * FROM orders WHERE order_id="' . $order_id . '"';

    $result = $conn->query($select_order);
    $orderDetails = [];
    if ($result->num_rows > 0) {
        // Fetch the user data
        $orderDetails = $result->fetch_assoc();
    } else {
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
</body>

</html>