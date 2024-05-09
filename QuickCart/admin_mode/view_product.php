<?php
include ('deleteProductQty_trigger.php');

if (isset ($_GET['admin_id'])) {
    $admin_id = $_GET['admin_id'];
}
$fetch_products = "SELECT * FROM product;";
$result_fetch = mysqli_query($con, $fetch_products);
$num_of_rows = mysqli_num_rows($result_fetch);
if ($num_of_rows == 0) {
    echo "<h2 class = 'text-center text-danger'> No Products available in Store right now! </h2>";
} else {
    ?>
    <h2 class="text-center text-success">All Products</h2>
    <table class="table table-bordered mt-5">
        <thead class="table-info text-center text-white">
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Product Image</th>
                <th>Product Price</th>
                <th>Stock</th>
                <th>Brand Name</th>
                <th>Quantity Bought</th>
                <th>Category</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="table-secondary text-white">
            <?php
            $fetch_products = "SELECT * FROM product;";
            $result_fetch = mysqli_query($con, $fetch_products);
            while ($fetch_row = mysqli_fetch_assoc($result_fetch)) {
                $product_id = $fetch_row["productID"];
                $product_name = $fetch_row["name"];
                $product_image = $fetch_row["prod_image"];
                $product_price = $fetch_row["price"];
                $product_stock = $fetch_row["stock"];
                $product_brand = $fetch_row["brand"];
                $product_bought = $fetch_row["qty_bought"];
                $product_cat = $fetch_row["categoryID"];
                ?>
                <tr class='text-center align-middle'>
                    <td>
                        <?php echo "$product_id"; ?>
                    </td>
                    <td>
                        <?php echo "$product_name"; ?>
                    </td>
                    <td><img src='../images/<?php echo "$product_image"; ?>' alt='$product_name image' class='prod_image' />
                    </td>
                    <td>
                        <?php echo "₹$product_price"; ?>
                    </td>
                    <td>
                        <?php echo "$product_stock"; ?>
                    </td>
                    <td>
                        <?php echo "$product_brand"; ?>
                    </td>
                    <td>
                        <?php echo "$product_bought"; ?>
                    </td>
                    <td>
                        <?php
                        $get_cat = "SELECT * FROM productCategory WHERE categoryID = $product_cat;";
                        $result_get = mysqli_query($con, $get_cat);
                        $row_cat = mysqli_fetch_assoc($result_get);
                        $cat_name = $row_cat['name'];
                        echo "$cat_name";
                        ?>
                    </td>
                    <td><a href='index.php?admin_id=<?php echo "$admin_id"; ?>&edit_product=<?php echo "$product_id"; ?>' class='text-success'><i
                                class='fa-solid fa-pen-to-square'></i></a></td>
                    <td><a href='index.php?admin_id=<?php echo "$admin_id"; ?>&delete_product=<?php echo "$product_id"; ?>' class='text-danger'><i
                                class='fa-solid fa-trash'></i></a></td>
                </tr>

                <?php
            }
            ?>

        </tbody>
    </table>
    <?php
}
?>