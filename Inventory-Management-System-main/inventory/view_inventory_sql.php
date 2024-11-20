<?php
function getProducts() {
    include '../includes/db_connection.php';

    if (!$db) {
        die("Failed to connect to the database.");
    }

    $sql = "SELECT * FROM product
    JOIN 
        supplier ON product.supplier_id = supplier.supplier_id
    JOIN
        branch ON product.branch_id = branch.branch_id";

    $stmt = $db->prepare($sql);
    $result = $stmt->execute();

    if (!$result) {
        die("Error executing query: " . $db->lastErrorMsg());
    }

    $arrayResult = [];
    while ($row = $result->fetchArray()) {
        $arrayResult[] = $row;
    }

    $db->close();

    return $arrayResult;
}
?>

