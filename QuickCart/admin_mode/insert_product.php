<?php
include ('../includes/connect.php'); // Connect file to MySQL
if (isset ($_POST['insert_prod'])) {
    $prod_name = $_POST['product_name'];
    $prod_price = $_POST['price'];
    $prod_stock = $_POST['stock'];
    $prod_brand = $_POST['brand'];
    $prod_desc = $_POST['desc'];
    $prod_category = $_POST['product_category'];
    // getting & accessing image
    $prod_image = $_FILES['product_image']['name'];
    // getting & accessing temp image
    $temp_image = $_FILES['product_image']['tmp_name'];

    // checking all filled - empty condition
    if ($prod_name == '' or $prod_price == '' or $prod_stock == '' or $prod_brand == '' or $prod_desc == '' or $prod_category == '' or $prod_image == '') {
        echo "<script> alert('Please fill all the available fields.')</script>";
        exit();
    } else {
        move_uploaded_file($temp_image, '../images/' . $prod_image);

        // Selecting data from table to check if product already exists
        $select_query = "SELECT * FROM product WHERE name='$prod_name' AND brand='$prod_brand';";
        $select_result = mysqli_query($con, $select_query);
        $number = mysqli_num_rows($select_result);
        if ($number > 0) {
            echo '<script>alert("This product is already present in Quickcart.")</script>';
        } else {
            // insert product to table
            $insert_query = "INSERT INTO product (name, price, stock, brand, qty_bought, description, prod_image, categoryID) VALUES ('$prod_name','$prod_price','$prod_stock','$prod_brand',DEFAULT,'$prod_desc','$prod_image','$prod_category');";
            $result_query = mysqli_query($con, $insert_query);
            if ($result_query) {
                echo "<script>alert('Product has been inserted successfully.')</script>";
            }
        }
    }
}
?>

<h2 class="text-center">Insert Product</h2>
<!-- form -->
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-outline mb-4 w-50 m-auto">
        <label for="product_name" class="form-label">Product Name</label>
        <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter Product Name"
            autocomplete="off" required="required">
    </div>
    <div class="form-outline mb-4 w-50 m-auto">
        <label for="price" class="form-label">Product Price</label>
        <input type="number" name="price" id="price" class="form-control" placeholder="Enter Product Price"
            autocomplete="off" required="required" step="0.01" min="0">
    </div>
    <div class="form-outline mb-4 w-50 m-auto">
        <label for="stock" class="form-label">Product Stock</label>
        <input type="number" name="stock" id="stock" class="form-control" placeholder="Enter Product Stock"
            autocomplete="off" required="required" min="0">
    </div>
    <div class="form-outline mb-4 w-50 m-auto">
        <label for="brand" class="form-label">Product Brand</label>
        <input type="text" name="brand" id="brand" class="form-control" placeholder="Enter Brand Name"
            autocomplete="off" required="required">
    </div>
    <div class="form-outline mb-4 w-50 m-auto">
        <label for="desc" class="form-label">Product Description</label>
        <input type="text" name="desc" id="desc" class="form-control" placeholder="Enter Product Description"
        autocomplete="off" required="required">
    </div>
    <div class="form-outline mb-4 w-50 m-auto">
        <select name="product_category" id="" class="form-select" required="required">
            <option value="">Select a Category</option>
            <?php
            $select_query = "SELECT * FROM productCategory;";
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
        <input type="file" name="product_image" id="product_image" class="form-control" required="required">
    </div>
    <div class="form-outline mb-4 w-50 m-auto">
        <input type="submit" name="insert_prod" class="btn btn-info mb-3 px-3" value="Insert Products">
    </div>
</form>