<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inventory</title>
        <link rel="stylesheet" href="../css/styles.css">
        <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>  
    </head>
    <body>
        <?php
            include("../inventory/view_inventory_sql.php");
            $products = getProducts();
            include("../includes/header_one.php");
        ?>
    <main>
        <h1>Welcome to the Inventory Catalogue</h1>
        
        <div class="toolbar">
            <h2>Database Product Listing</h2>
            
            <!--icons from Icons8 website-->
            <img src="../images/download_icon.png" alt="download icon" class="icon">
            <img src="../images/print_icon.png" alt="print icon" class="icon">
        </div>

        <!--Button-->
        <form action="addProduct.php">
            <input type="submit" value="Add New Product">
        </form>

        <div class="table-container">
            <table>
                <!--table headers-->
                <thead>
                    <tr>
                        <th>Product No.</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Supplier</th>
                        <th>Branch</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <!--table body-->
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['product_id']; ?></td>
                            <td><?php echo $product['product_name']; ?></td>
                            <td><?php echo $product['product_category']; ?></td>
                            <td><?php echo $product['quantity']; ?></td>
                            <td><?php echo $product['supplier_name']; ?></td>
                            <td><?php echo $product['branch_name']; ?></td>
                            <td class="actions">
                                <a href="order_product.php">Order</a>
                                <a href="edit_product.php?productID=<?php echo $product['product_id']; ?>">Edit</a>
                                <a href="remove_product.php">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <p class="number-records">Displaying <?php echo count($products); ?> of <?php echo count($products); ?> Records</p>

    </main>
    </body>
</html>