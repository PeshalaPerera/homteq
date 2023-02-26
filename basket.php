<?php
session_start();
include("db.php");
// $_SESSION['basket'][$newprodid] = $reququantity;
echo "<p>1 item added";
$pagename = "Smart Basket"; //Create and populate a variable called $pagename
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>" . $pagename . "</title>"; //display name of the page as window title
echo "<body>";
include("headfile.html"); //include header layout file
echo "<h4>" . $pagename . "</h4>"; //display name of the page on the web page
//display random text
$newprodid = '';
$reququantity = '';
$total = 0;
if (!empty($_POST['h_prodid'])) {
    $newprodid = $_POST['h_prodid'];
}
if (!empty($_POST['quantity'])) {
    $reququantity = $_POST['quantity'];
}

if (!empty($newprodid) && !empty($reququantity)) {
    $_SESSION['basket'][$newprodid] = $reququantity;
    // echo $reququantity . "<p> item added to the basket";
} else {
    // echo "<p> Basket unchanged ";
}


if (isset($_SESSION['basket'])) {
    echo "<table id='baskettable'>";
    echo "<th>Product Name</th>";
    echo "<th>Price</th>";
    echo "<th>Quantity</th>";
    echo "<th>Subtotal</th>";
    foreach ($_SESSION['basket'] as $index => $value) {
        // print_r($_SESSION['basket']);
        //create a $SQL variable and populate it with a SQL statement that retrieves product details
        $SQL = "select prodName, prodPrice, prodQuantity from Product where prodId = " . $index;
        //run SQL query for connected DB or exit and display error message
        $exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
        while ($arrayp = mysqli_fetch_array($exeSQL)) {
            $subtotal = $value * $arrayp['prodPrice'];
            $total += $subtotal;
            echo "<tr>";
            echo "<td>" . $arrayp['prodName'] . " </td>";
            echo "<td>" . $arrayp['prodPrice'] . "</td>";
            echo "<td>" . $value . "</td>";
            echo "<td>" . $subtotal . "</td>";
            echo "</tr>";
        }
    }
    echo "<tr>";
    echo "<td colspan='3'>Total</td>";
    echo "<td>" . $total . "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<a href=clearbasket.php>CLEAR BASKET</a>";
} else {
    echo "<p> Basket unchanged </p>";
}



include("footfile.html"); //include head layout
echo "</body>";
