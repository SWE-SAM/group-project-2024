<?php
    $result = isset($_GET['addProduct']) ? $_GET['addProduct'] : '';

    $message = ($result) ? "Product Added Successfully!" : "No Product was added!";

    $title = $message;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title><?php echo $message; ?></title>
</head>
<body>
    <div class="container">
        <?php
        include("../includes/headerOne.php");

        $db = new SQLite3('C:\xampp\data\candyatlas.db');
        ?>  
        <main>
            <h1><?php echo $message; ?></h1>
            <form action="inventory.php">
                <input type="submit" value="Back" />
            </form>
        </main>
        <?php
            $db->close();
        ?>
    </div>
</body>
</html>
