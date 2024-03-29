<?php
session_start();
include"includes\db.php";
error_reporting(0);

// Establish a connection to the SQL Server database
$serverName = "NGUYEN-MY-DUYEN\SQLEXPRESS";
$database = "CDQ";


$connection = [
    "Database" => $database,
    "Encrypt" => "no",  // Disable connection encryption
    "TrustServerCertificate" => "yes"  // Trust the server certificate
]; 

$con = sqlsrv_connect($serverName, $connection);

if (!$con) {
    die(print_r(sqlsrv_errors(), true));
}

if (isset($_GET['action']) && $_GET['action'] != "" && $_GET['action'] == 'delete') {
    $product_id = $_GET['product_id'];
    
    ///////picture delete/////////
    $result = sqlsrv_query($con, "SELECT product_image FROM products WHERE product_id=?", array($product_id));

    $row = sqlsrv_fetch_array($result);
    $picture = $row['product_image'];
    $path = "../product_images/$picture";

    if (file_exists($path) == true) {
        unlink($path);
    } else {
    }

    /*this is delete query*/
    sqlsrv_query($con, "DELETE FROM products WHERE product_id=?", array($product_id));
}
//
///pagination, xử lý page cho user
$page = $_GET['page'];

if ($page == "" || $page == "1") {
    $page1 = 0;
} else {
    $page1 = ($page * 10) - 10;
}
include "sidenav.php";
include "topheader.php";
?>
<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">

        <div class="col-md-14">
            <div class="card ">
                <div class="card-header card-header-primary">
                    <h4 class="card-title"> Products List</h4>
                    <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                        <label class="btn btn-sm btn-primary btn-simple active" id="0">
                            <input type="radio" name="options" autocomplete="off" checked=""> electronic
                        </label>
                        <label class="btn btn-sm btn-primary btn-simple" id="1">
                            <input type="radio" name="options" autocomplete="off"> clothes
                        </label>
                        <label class="btn btn-sm btn-primary btn-simple" id="2">
                            <input type="radio" name="options" autocomplete="off"> Home Appliances
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive ps">
                        <table class="table table-hover tablesorter " id="page1">
                            <thead class=" text-primary">
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th><a class=" btn btn-primary" href="add_products.php">Add New</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $result = sqlsrv_query($con, "SELECT product_id, product_image, product_title, product_price FROM products WHERE product_cat=1 OFFSET ? ROWS FETCH NEXT 12 ROWS ONLY", array($page1));

                                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                    $product_id = $row['product_id'];
                                    $image = $row['product_image'];
                                    $product_name = $row['product_title'];
                                    $price = $row['product_price'];

                                    echo "<tr><td><img src='../product_images/$image' style='width:50px; height:50px; border:groove #000'></td><td>$product_name</td>
                        <td>$price</td>
                        <td>
                        <a class=' btn btn-success' href='clothes_list.php?product_id=$product_id&action=delete'>Delete</a>
                        </td></tr>";
                                }

                                ?>
                            </tbody>
                        </table>
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div>
                    </div>
                </div>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <?php
                    //counting paging
                    $pagingResult = sqlsrv_query($conn, "SELECT product_id, product_image, product_title, product_price FROM products");
                    $count = sqlsrv_num_rows($pagingResult);

                    $a = $count / 10;
                    $a = ceil($a);

                    for ($b = 1; $b <= $a; $b++) {
                    ?>
                        <li class="page-item"><a class="page-link" href="productlist.php?page=<?php echo $b; ?>"><?php echo $b . " "; ?></a></li>
                    <?php
                    }
                    ?>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<?php
include "footer.php";
sqlsrv_close($con);
?>
