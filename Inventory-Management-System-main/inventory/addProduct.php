<?php
$errorpcategory = $errorpname = $errorpquantity = $errorbname = "";
$fields = true;

//error message if input is blank
if (isset($_POST['submit'])){
    include '../includes/dbConnection.php';
    if (empty($_POST['pcategory'])) {
        $errorpcategory = "You must select the Product Category";
        $fields = false;
    }
    if (empty($_POST['pname'])) {
        $errorbname = "You must select the Product Name";
        $fields = false;
    }
    if (empty($_POST['pquantity'])) {
        $errorbname = "You must select the Product Quantity";
        $fields = false;
    }
    if (empty($_POST['branch_id'])) {
        $errorbname = "You must select the Branch Name";
        $fields = false;
    }

    if ($fields){
        $stmt = $db->prepare('SELECT branch_id, branch_name FROM branch WHERE branch_id = bid');
        $stmt->bindValue(':bid', $_POST['branch_id'], SQLITE3_INTEGER);
        $result = $stmt->execute();
        $productDetails = $result->fetchArray(SQLITE3_ASSOC);

    if ($productDetails){
        $stmt = $db->prepare('INSERT INTO products (product_category, product_name, product_quantity, branch_id) VALUES (:pcategory, :pname, :pquantity, :bid)');
        $stmt->bindValue(':pcategory', $_POST['pcategory'], SQLITE3_TEXT);
        $stmt->bindValue(':pname', $_POST['pname'], SQLITE3_TEXT);
        $stmt->bindValue(':pquantity', $_POST['pquantity'], SQLITE3_INTEGER);
        $stmt->bindValue(':bid', $productDetails['branch_id'], SQLITE3_INTEGER);

///        $result_product = $stmt->execute();
//         $branch_id = $db->lastInsertRowID();
//         if ($_POST['branch'] == 'branchName') {
//             $stmt_branch = $db->prepare('INSERT INTO branch (branch_id) VALUES (:branch_id');
//             $stmt_branch->bindValue(':branch_id', $branch_id, SQLITE3_INTEGER);
//             $result_branch = $stmt_branch->execute();
//             if ($result_branch) {
//                 header("Location: ../inventory/productAddedSuccessfully.php?addProduct=success");
//                 exit();
//             } else {
//                 echo "Error adding product: " . $db->lastErrorMsg();
//             }
//         } else {
//             header("Location: ../inventory/productAddedSuccessfully.php?addProduct=success");
//             exit();
//         }
//     }
//             header("Location: productAddedSuccessfully.php: " . $db->lastErrorMsg());
//             exit();
// }
//     } else {
//         echo "error adding product: " . $db->lastErrorMsg();
    
     } } }
              
include '../includes/dbConnection.php';
$stmt_branches = $db->prepare('SELECT branch_id, branch_name FROM branch');
$result_branch = $stmt_branches->execute();
$branches = array();
while ($row = $result_branch->fetchArray(SQLITE3_ASSOC)){
    $branches[] = array(
        'branch_id' => $row['branch_id'],
        'branch_name' => $row['branch_name'] 
    );
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
    include("../includes/headerOne.php");
    ?>
    <main> 
        <h1>Add Stock </h1>
        <form method="post">
        <label>Product Category</label>
                <select id="productCategory" name="pCategory">
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
            <span class="emptyField"><?php echo $errorpquantity; ?></span>

            <label for="branch_id">Branch</label>
                <select id="branch_id" name="branch_id">
                    <option value="" disabled selected>Select Branch</option>
                    <?php foreach ($branches as $branch): ?>
                        <option value="<?php echo $branch['branch_id']; ?>">
                            <?php echo $branch['branch_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="emptyField"><?php echo $errorbname; ?></span>

            <input type="submit" value="Add Product" name="submit">
            <a href="inventory.php" class="back">Back</a>
        </form>
    </main>
    <script src="productCategory.js"></script>
</body>
</html>
