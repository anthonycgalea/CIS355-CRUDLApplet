<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
}
if($_SESSION['role']!='Admin' && $_SESSION['id']!=$_GET['id']) {
    header("Location: index.php");
    
}

// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once 'config/database.php';
include_once 'objects/person.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$product = new Person($db);
  
// set ID property of product to be edited
$product->id = $id;
  
// read the details of product to be edited
$product->readOne();

  
// set page header
$page_title = "Update Person";
include_once "layout_header.php";
  
echo "<div class='right-button-margin'>
          <a href='index.php' class='btn btn-default pull-right'>Read People</a>
     </div>";
  
?>
<?php 
// if the form was submitted
if($_POST){
  
    // set product property values
    $product->role = $_POST['role'];
    $product->fname = $_POST['fname'];
    $product->lname = $_POST['lname'];
    $product->email = $_POST['email'];
    $product->phone = $_POST['phone'];
    $salt= MD5(microtime(true));
    $product->password_hash = MD5($_POST['password'] . $salt);
    $product->password_salt = $salt;
    $product->address = $_POST['address'];
    $product->address2 = $_POST['address2'];
    $product->city = $_POST['city'];
    $product->state = $_POST['state'];
    $product->zip_code = $_POST['zip_code'];
    // update the product
    if($product->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "Product was updated.";
        echo "</div>";
    }
  
    // if unable to update the product, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update product.";
        echo "</div>";
    }
}
?>
  
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        
        <table class='table table-hover table-responsive table-bordered'>
        <tr><td>Role</td><td>
            <select name='role'>
                <option value='Admin' <?php if ($_SESSION['role']!='Admin') {echo "disabled";}?>>Admin</option>
                <option value='User' selected>User</option>
            </select>
            </td>
        </tr>
        <tr><td>First</td><td><input type='text' name='fname' value='<?php echo $product->fname; ?>' class='form-control' /></td></tr>
        <tr><td>Last</td><td><input type='text' name='lname' value='<?php echo $product->lname; ?>'class='form-control' /></td></tr>
        <tr><td>Email</td><td><input type='text' name='email' value='<?php echo $product->email; ?>' class='form-control' /></td></tr>
        <tr><td>Phone</td><td><input type='text' name='phone' value='<?php echo $product->phone; ?>' class='form-control' /></td></tr>
        <tr><td>Password</td><td><input type='password' name='password' value='<?php echo $product->password; ?>' class='form-control' /></td></tr>
        <tr><td>Address</td><td><input type='text' name='address' value='<?php echo $product->address; ?>' class='form-control' /></td></tr>
        <tr><td>Address 2</td><td><input type='text' name='address2' value='<?php echo $product->address2; ?>' class='form-control' /></td></tr>
        <tr><td>City</td><td><input type='text' name='city' value='<?php echo $product->city; ?>' class='form-control' /></td></tr>
        <tr><td>State</td><td><input type='text' name='state' value='<?php echo $product->state; ?>' class='form-control' /></td></tr>
        <tr><td>Zip Code</td><td><input type='text' name='zip_code' value='<?php echo $product->zip_code; ?>' class='form-control' /></td></tr>
  
    </table>
        
           
            </td>
        </tr>
  
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Update</button>
            </td>
        </tr>
  
    </table>
</form>
<?php 
// set page footer
include_once "layout_footer.php";
?>