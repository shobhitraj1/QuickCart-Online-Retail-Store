<?php
if (isset ($_GET['edit_category']) and isset($_GET['admin_id'])) {
    $edit_id = $_GET['edit_category'];
    $admin_id = $_GET['admin_id'];

    $get_data = "SELECT * FROM productCategory WHERE categoryID = $edit_id;";
    $result_get = mysqli_query($con, $get_data);
    $row_data = mysqli_fetch_assoc($result_get);
    $category_id = $row_data["categoryID"];
    $category_name = $row_data["name"];
    $category_noofp = $row_data["noOfProducts"];
}
?>

<div class="container mt-3">
    <h2 class="text-center">Edit Category</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" name="category_name" id="category_name" value="<?php echo "$category_name"; ?>"
                class="form-control" placeholder="Enter Category Name" autocomplete="off" required="required">
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <input type="submit" name="edit_cat" class="btn btn-info mb-3 px-3" value="Update Category">
        </div>
    </form>
</div>

<!-- updating category's details in the database -->
<?php
if (isset ($_POST['edit_cat'])) {
    $cat_new_name = $_POST['category_name'];

    // checking all filled - empty condition
    if ($cat_new_name == '') {
        echo "<script> alert('Please fill all the available fields.')</script>";
        exit();
    } else {

        // update category's new details to table - SET safe mode OFF to update
        $safe_mode_query = "SET SQL_SAFE_UPDATES = 0;";
        $result_safe = mysqli_query($con, $safe_mode_query);
        if ($result_safe==0){
            echo "Couldn't turn safe mode OFF";
        }
        $update_query = "UPDATE productCategory SET name = '$cat_new_name' WHERE categoryID = '$category_id';";
        $result_query = mysqli_query($con, $update_query);
        if ($result_query) {
            echo "<script>alert('Category has been updated successfully.'); window.location.href = 'index.php?admin_id=" . $admin_id . "&view_category';</script>";
        }
    }
}
?>