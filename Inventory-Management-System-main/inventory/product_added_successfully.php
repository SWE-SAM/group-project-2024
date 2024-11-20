<?php
    $result_product = isset($_GET['add_product']) ? $_GET['add_product'] : '';

    $message = ($result_product) ? "Product Added Successfully!" : "No Product was added!";

    $product_title = $message;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title><?php echo $product_title; ?></title>
</head>
<body>
    <div class="container">
        <?php
        $db = new SQLite3('C:\xampp\data\candyatlas.db');
        include("../includes/header_one.php");
        ?>  
        <main>
            <h1><?php echo $message; ?></h1>
            <form action="../inventory/inventory.php">
                <input type="submit" value="Back" />
            </form>
        </main>
        <?php
            $db->close();
        ?>
    </div>
</body>
</html>
