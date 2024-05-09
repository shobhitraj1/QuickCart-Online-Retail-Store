<?php
if (isset ($_GET['delete_product']) and isset($_GET['admin_id'])) {
    $delete_id = $_GET['delete_product'];
    $admin_id = $_GET['admin_id'];
    $get_data = "SELECT * FROM product WHERE productID = $delete_id;";
    $result_get = mysqli_query($con, $get_data);
    $row_data = mysqli_fetch_assoc($result_get);
    $product_stock = $row_data["stock"];
    $product_cat = $row_data["categoryID"];

    // -- Delete the product from the product table
    $delete_prod = "DELETE FROM product WHERE productID = $delete_id;";
    $result_delete = mysqli_query($con, $delete_prod);

    // Reducing the no of products in category table - this is now being done by deleteProductQty_trigger.php
    // $delete_stock = "UPDATE productCategory SET noOfProducts = noOfProducts - '$product_stock' WHERE categoryID = '$product_cat'";
    // $result_delete2 = mysqli_query($con, $delete_stock);


    if ($result_delete) {
        echo "<script>alert('Product has been deleted successfully.'); window.location.href = 'index.php?admin_id=" . $admin_id . "&view_product';</script>";
    }
}
?>