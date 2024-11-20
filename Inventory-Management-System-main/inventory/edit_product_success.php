<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/styles.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <title>Product Update</title>
</head>
<body>
        <?php
            include("../includes/header_one.php");

            $updated = isset($_GET['updated']) && $_GET['updated'] === 'true';

            $message = ($updated) ? "Product Updated Successfully!" : "Product Update Failed!";
        ?>  
        <main>
            <h1><?php echo $message; ?></h1>
            <form action="inventory.php">
                <input type="submit" value="Back" />
            </form>
        </main>
</body>
</html>