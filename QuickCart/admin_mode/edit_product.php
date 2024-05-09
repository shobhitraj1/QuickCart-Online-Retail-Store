<?php
if (isset ($_GET['edit_product']) and isset($_GET['admin_id'])) {
    $edit_id = $_GET['edit_product'];
    $admin_id = $_GET['admin_id'];
    $get_data = "SELECT * FROM product WHERE productID = $edit_id;";
    $result_get = mysqli_query($con, $get_data);
    $row_data = mysqli_fetch_assoc($result_get);
    $product_id = $row_data["productID"];
    $product_name = $row_data["name"];
    $product_image = $row_data["prod_image"];
    $product_price = $row_data["price"];
    $product_stock = $row_data["stock"];
    $product_brand = $row_data["brand"];
    $product_desc = $row_data["description"];
    $product_bought = $row_data["qty_bought"];
    $product_cat = $row_data["categoryID"];

    // fetching category name for the select dropdown
    $select_query = "SELECT * FROM productCategory WHERE categoryID = $product_cat;";
    $result_query = mysqli_query($con, $select_query);
    $row = mysqli_fetch_assoc($result_query);
    $cat_id = $row['categoryID'];
    $cat_name = $row['name'];
    // echo "$cat_id";
    // echo "$cat_name";
}
?>

<div class="container mt-3">
    <h2 class="text-center">Edit Product</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" name="product_name" id="product_name" value="<?php echo "$product_name"; ?>"
                class="form-control" placeholder="Enter Product Name" autocomplete="off" required="required">
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="price" class="form-label">Product Price</label>
            <input type="number" name="price" id="price" value="<?php echo "$product_price"; ?>" class="form-control"
                placeholder="Enter Product Price" autocomplete="off" required="required" step="0.01" min="0">
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="stock" class="form-label">Product Stock</label>
            <input type="number" name="stock" id="stock" value="<?php echo "$product_stock"; ?>" class="form-control"
                placeholder="Enter Product Stock" autocomplete="off" required="required" min="0">
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="brand" class="form-label">Product Brand</label>
            <input type="text" name="brand" id="brand" value="<?php echo "$product_brand"; ?>" class="form-control"
                placeholder="Enter Brand Name" autocomplete="off" required="required">
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="bought" class="form-label">Quantity Bought</label>
            <input type="number" name="bought" id="bought" value="<?php echo "$product_bought"; ?>" class="form-control"
                placeholder="Enter Quantity Bought" autocomplete="off" required="required" min="0">
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="desc" class="form-label">Product Description</label>
            <input type="text" name="desc" id="desc" value="<?php echo "$product_desc"; ?>" class="form-control"
                placeholder="Enter Product Description" autocomplete="off" required="required">
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <select name="product_category" id="" class="form-select" required="required">
                <option value='<?php echo $cat_id; ?>'>
                    <?php echo "$cat_name"; ?>
                </option>
                <?php
                $select_query = "SELECT * FROM productCategory WHERE categoryID != $product_cat";
                $result_query = mysqli_query($con, $select_query);
                while ($row = mysqli_fetch_assoc($result_query)) {
                    $cat_name = $row['name'];
                    $cat_id = $row['categoryID'];
                    echo "<option value='$cat_id'> $cat_name </option>";
                }
                ?>
            </select>
        </div>
        <!-- image -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="product_image" class="form-label">Product Image</label>
            <div class="d-flex">
                <input type="file" name="product_image" id="product_image" class="form-control w-90 m-auto"
                    required="required">
                <img src="../images/<?php echo "$product_image"; ?>" alt="<?php $product_name ?> image"
                    class="edit_image">
            </div>
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <input type="submit" name="edit_prod" class="btn btn-info mb-3 px-3" value="Update Product">
        </div>
    </form>
</div>

<!-- updating product's details in the database -->
<?php
if (isset ($_POST['edit_prod'])) {
    $prod_name = $_POST['product_name'];
    $prod_price = $_POST['price'];
    $prod_stock = $_POST['stock'];
    $prod_brand = $_POST['brand'];
    $prod_bought = $_POST['bought'];
    $prod_desc = $_POST['desc'];
    $prod_category = $_POST['product_category'];
    // echo "$prod_category";
    // getting & accessing image
    $prod_image = $_FILES['product_image']['name'];
    // getting & accessing temp image
    $temp_image = $_FILES['product_image']['tmp_name'];

    // checking all filled - empty condition
    if ($prod_name == '' or $prod_price == '' or $prod_stock == '' or $prod_brand == '' or $prod_desc == '' or $prod_bought == '' or $prod_category == '' or $prod_image == '') {
        echo "<script> alert('Please fill all the available fields.')</script>";
        exit();
    } else {
        move_uploaded_file($temp_image, '../images/' . $prod_image);

        // update product to table - SET safe mode OFF to update
        $safe_mode_query = "SET SQL_SAFE_UPDATES = 0;";
        $result_safe = mysqli_query($con, $safe_mode_query);
        if ($result_safe==0){
            echo "Couldn't turn safe mode OFF";
        }
        $update_query = "UPDATE product SET name = '$prod_name', price = '$prod_price', stock = '$prod_stock', brand = '$prod_brand', qty_bought = '$prod_bought', description = '$prod_desc', categoryID = '$prod_category', prod_image = '$prod_image' WHERE productID = '$product_id';";
        $result_query = mysqli_query($con, $update_query);
        if ($result_query) {
            echo "<script>alert('Product has been updated successfully.'); window.location.href = 'index.php?admin_id=" . $admin_id . "&view_product';</script>";
        }
    }
}
?>