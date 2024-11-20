<?php
$errorpcategory = $errorpname = $errorpquantity = "";
$fields = true;

//error message if input is blank
if (isset($_POST['submit'])){
    include '../includes/db_connection.php';
    if (empty($_POST["pcategory"])) {
        $errorpcategory = "You must select the Product Category";
        $fields = false;
    }
    if (empty($_POST['pname'])) {
        $errorpname = "You must select the Product Name";
        $fields = false;
    }
    if (empty($_POST['pquantity'])) {
        $errorpquantity = "You must select the Product Quantity";
        $fields = false;
    }

    if ($fields){
        $stmt = $db->prepare('INSERT INTO product (product_category, product_name, quantity, supplier_id, branch_id) VALUES (:pcategory, :pname, :pquantity, :supplier_id, :branch_id)');
        $stmt->bindValue(':pcategory', $_POST['pcategory'], SQLITE3_TEXT);
        $stmt->bindValue(':pname', $_POST['pname'], SQLITE3_TEXT);
        $stmt->bindValue(':pquantity', $_POST['pquantity'], SQLITE3_INTEGER);
        $stmt->bindValue(':supplier_id', 1, SQLITE3_INTEGER);
        $stmt->bindValue(':branch_id', 1, SQLITE3_INTEGER);


       $result_product = $stmt->execute();


        if ($result_product) {
            header("Location: ../inventory\product_added_successfully.php?add_product=success");
          
            exit();
            } else {
                echo "Error adding product. ";
            }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>  
</head>
<body>
        <?php
            include("../includes/header_one.php");
        ?>
    <main> 
        <h1>Add Stock </h1>
        <form method="post">
        <label>Product Category</label>
                <select id="productCategory" name="pcategory">
                    <option value="" disabled selected>Select Category</option>
                    <option value="hardBoiledCandy">Hard-Boiled Candy</option>
                    <option value="gummyCandy">Gummy Candy</option>
                    <option value="lollipops">Lollipops</option>
                    <option value="nerds">Nerds</option>
                    <option value="sourCandy">Sour Candy</option>
                </select>
                <span class="emptyField"><?php echo $errorpcategory; ?></span>

        <label>Product</label>
                <select id="productName" name="pname">
                    <option value="" disabled selected>Select Product</option>
                </select>
                <span class="emptyField"><?php echo $errorpname; ?></span>

            <label>Quantity</label>
            <input type="number" name="pquantity" value="<?php echo isset($_POST['pquantity']) ? $_POST['pquantity'] : ''; ?>">
            <span class="emptyField"><?php echo $errorpquantity; ?></span> <br><br> 
             
            <input type="hidden" name="supplier_id" value="1">
            <input type="hidden" name="branch_id" value="1">


            <input type="submit" value="Add Product" name="submit">
            <a href="inventory.php" class="back">Back</a>
        </form>
    </main>
    <script src="product_category.js"></script>
</body>
</html>
