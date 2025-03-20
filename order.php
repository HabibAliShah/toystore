<?php
    // Include the database connection script
    require 'includes/database-connection.php';

    /*
     * Function to retrieve ALL customer and order info from the database based on email and order number.
     */
    function get_order_info(PDO $pdo, string $email, string $orderNum) {
        // SQL query to retrieve ALL customer and order info based on email and order number
        $sql = "SELECT c.cname, c.username, o.ordernum, o.quantity, o.date_ordered, o.date_deliv
                FROM customer c
                JOIN orders o ON c.custnum = o.custnum
                WHERE c.email = :email AND o.ordernum = :orderNum;";

        // Execute the SQL query using the pdo function and fetch the result
        $order_info = pdo($pdo, $sql, ['email' => $email, 'orderNum' => $orderNum])->fetch();

        // Return the order info
        return $order_info;
    }

    // Initialize the variable to hold order information
    $order_info = null;

    // Check if the request method is POST (i.e., form submitted)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the value of the 'email' field from the POST data
        $email = $_POST['email'];

        // Retrieve the value of the 'orderNum' field from the POST data
        $orderNum = $_POST['orderNum'];

        // Retrieve info about the order from the db using provided PDO connection
        $order_info = get_order_info($pdo, $email, $orderNum);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toys R URI</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-left">
            <div class="logo">
                <img src="imgs/logo.png" alt="Toy R URI Logo">
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Toy Catalog</a></li>
                    <li><a href="about.php">About</a></li>
                </ul>
            </nav>
        </div>
        <div class="header-right">
            <ul>
                <li><a href="order.php">Check Order</a></li>
            </ul>
        </div>
    </header>

    <main>
        <div class="order-lookup-container">
            <div class="order-lookup-container">
                <h1>Order Lookup</h1>
                <form action="order.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="orderNum">Order Number:</label>
                        <input type="text" id="orderNum" name="orderNum" required>
                    </div>

                    <button type="submit">Lookup Order</button>
                </form>
            </div>
            
            <!-- Check if the variable holding order info is not empty -->
            <?php if (!empty($order_info)): ?>
                <div class="order-details">
                    <h1>Order Details</h1>
                    <p><strong>Name: </strong> <?= $order_info['cname'] ?></p>
                    <p><strong>Username: </strong> <?= $order_info['username'] ?></p>
                    <p><strong>Order Number: </strong> <?= $order_info['ordernum'] ?></p>
                    <p><strong>Quantity: </strong> <?= $order_info['quantity'] ?></p>
                    <p><strong>Date Ordered: </strong> <?= $order_info['date_ordered'] ?></p>
                    <p><strong>Delivery Date: </strong> <?= $order_info['date_deliv'] ?></p>
                </div>
            <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                <div class="order-details">
                    <p>No order found for the provided email and order number.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>