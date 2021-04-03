<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
}
// get ID of the product to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once 'config/database.php';
include_once 'objects/person.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$product = new Person($db);
  
// set ID property of product to be read
$product->id = $id;
  
// read the details of product to be read
$product->readOne();
// set page headers
$page_title = "Read One User";
include_once "layout_header.php";
  
// read products button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Read Products";
    echo "</a>";
echo "</div>";
  
// HTML table for displaying a product details
echo "<table class='table table-hover table-responsive table-bordered'>";
  
    echo "<tr>";
        echo "<td>User ID</td>";
        echo "<td>{$product->id}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>Role</td>";
        echo "<td>{$product->role}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>First Name</td>";
        echo "<td>{$product->fname}</td>";
    echo "</tr>";
    
    echo "<tr>";
        echo "<td>Last Name</td>";
        echo "<td>{$product->lname}</td>";
    echo "</tr>";
    
    echo "<tr>";
        echo "<td>Email</td>";
        echo "<td>{$product->email}</td>";
    echo "</tr>";
    
    echo "<tr>";
        echo "<td>Phone Number</td>";
        echo "<td>{$product->phone}</td>";
    echo "</tr>";
   
    echo "<tr>";
        echo "<td>Address</td>";
        echo "<td>{$product->address}</td>";
    echo "</tr>";
    
    echo "<tr>";
        echo "<td>Address 2</td>";
        echo "<td>{$product->address2}</td>";
    echo "</tr>";
   
    echo "<tr>";
        echo "<td>City</td>";
        echo "<td>{$product->city}</td>";
    echo "</tr>";
    
    echo "<tr>";
        echo "<td>State</td>";
        echo "<td>{$product->state}</td>";
    echo "</tr>";
    
    echo "<tr>";
        echo "<td>Zip Code</td>";
        echo "<td>{$product->zip_code}</td>";
    echo "</tr>";
  
echo "</table>";
// set footer
include_once "layout_footer.php";
?>