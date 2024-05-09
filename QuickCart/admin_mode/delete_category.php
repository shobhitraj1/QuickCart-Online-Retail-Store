<?php
if (isset ($_GET['delete_category']) and isset($_GET['admin_id'])) {
    $delete_id = $_GET['delete_category'];
    $admin_id = $_GET['admin_id'];

    // -- Delete the product from the product table
    $delete_cat = "DELETE FROM productCategory WHERE categoryID = $delete_id;";
    $result_delete = mysqli_query($con, $delete_cat);
    // As DELETE CASCASE in product table, so products automatically deleted

    if ($result_delete) {
        echo "<script>alert('Category has been deleted successfully.'); window.location.href = 'index.php?admin_id=" . $admin_id . "&view_category';</script>";
    }
}
?>