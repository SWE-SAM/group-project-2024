<?php
session_start();

include '../includes/db_connection.php';
$errorProductName = $errorCategory = $errorQuantity = $errorSupplierID = $errorBranchID = "";
$allFields = true;

if (isset($_POST['submit'])) {

    if (empty($_POST['productName'])) {
        $errorProductName = "Product Name is mandatory";
        $allFields = false;
    }
    if (empty($_POST['category'])) {
        $errorCategory = "Product Category is mandatory";
        $allFields = false;
    }
    if (empty($_POST['quantity'])) {
        $errorQuantity = "Quantity is mandatory";
        $allFields = false;
    }
    if (empty($_POST['supplierID'])) {
        $errorSupplierID = "Supplier ID is mandatory";
        $allFields = false;
    }
    if (empty($_POST['branchID'])) {
        $errorBranchID = "Branch ID is mandatory";
        $allFields = false;
    }

    if ($allFields) {

        $stmt = $db->prepare("UPDATE product SET product_name = :productName, product_category = :category, quantity = :quantity, supplier_id = :supplierID, branch_id = :branchID WHERE product_id = :productID");
        $stmt->bindValue(':productID', $_POST['productID'], SQLITE3_INTEGER);
        $stmt->bindValue(':productName', $_POST['productName'], SQLITE3_TEXT);
        $stmt->bindValue(':category', $_POST['category'], SQLITE3_TEXT);
        $stmt->bindValue(':quantity', $_POST['quantity'], SQLITE3_TEXT);
        $stmt->bindValue(':supplierID', $_POST['supplierID'], SQLITE3_TEXT);
        $stmt->bindValue(':branchID', $_POST['branchID'], SQLITE3_TEXT);
        
        $result = $stmt->execute();

        if ($result) {
            header('Location: edit_product_success.php?updated=true');
            exit;
        } else {
            echo "Error updating product.";
        }
    }
}

if (isset($_GET['productID'])) {
    $stmt = $db->prepare('SELECT * FROM product WHERE product_id = :productID');
    $stmt->bindParam(':productID', $_GET['productID'], SQLITE3_INTEGER);
    $result = $stmt->execute();
    $product = $result->fetchArray(SQLITE3_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/styles.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <title>Edit Product</title>
</head>
<body>
    <?php
        include("../includes/header_one.php");
    ?>  
    <main>
        <h1>Edit Product</h1>
        <form method="post">
            <?php if (isset($product)): ?>
                <input type="hidden" name="productID" value="<?php echo $product['product_id']; ?>">
            <?php endif; ?>
            <label>Product Name</label>
            <input type="text" name="productName" value="<?php echo isset($product['product_name']) ? $product['product_name'] : ''; ?>">
            <span class="blank-error"><?php echo $errorProductName; ?></span>
            
            <label>Product Category</label>
            <select name="category">
                <option value="">Select Category</option>
                <option value="hard-boiled candy" <?php echo (isset($product['product_category']) && $product['product_category'] == "hard-boiled candy") ? "selected" : ""; ?>>Hard-Boiled Candy</option>
                <option value="gummy candy" <?php echo (isset($product['product_category']) && $product['product_category'] == "gummy candy") ? "selected" : ""; ?>>Gummy Candy</option>
                <option value="lollipops" <?php echo (isset($product['product_category']) && $product['product_category'] == "lollipops") ? "selected" : ""; ?>>Lollipops</option>
                <option value="nerds candy" <?php echo (isset($product['product_category']) && $product['product_category'] == "nerds candy") ? "selected" : ""; ?>>Nerds</option>
                <option value="sour candy" <?php echo (isset($product['product_category']) && $product['product_category'] == "sour candy") ? "selected" : ""; ?>>Sour Candy</option>
            </select>
            <span class="blank-error"><?php echo $errorCategory; ?></span>

            <label>Quantity</label>
            <input type="number" name="quantity" value="<?php echo isset($product['quantity']) ? $product['quantity'] : ''; ?>">
            <span class="blank-error"><?php echo $errorQuantity; ?></span>

            <label>Supplier ID</label>
            <input type="number" name="supplierID" value="<?php echo isset($product['supplier_id']) ? $product['supplier_id'] : ''; ?>">
            <span class="blank-error"><?php echo $errorSupplierID; ?></span>

            <label>Branch ID</label>
            <input type="number" name="branchID" value="<?php echo isset($product['branch_id']) ? $product['branch_id'] : ''; ?>">
            <span class="blank-error"><?php echo $errorBranchID; ?></span>

            <input type="submit" value="Update Product" name="submit">
            <a href="inventory.php" class="back-button">Back</a>
        </form>
    </main>
</body>
</html>