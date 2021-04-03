<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
}

if($_SESSION['role']!='Admin') {
    header("Location: index.php");
    echo("Access denied.");
}

// include database and object files
include_once 'config/database.php';
include_once 'objects/person.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$product = new Person($db);
// set page headers
$page_title = "Create Person";
include_once "layout_header.php";
  
// contents will be here
echo "<div class='right-button-margin'>
<a href='index.php' class='btn btn-default pull-right'>Read Users</a>
</div>";

?>
<!-- PHP post code will be here -->
<?php 
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
  
    // set product property values
    $product->role = $_POST['role'];
    $product->fname = $_POST['fname'];
    $product->lname = $_POST['lname'];
    $product->email = $_POST['email'];
    $product->phone = $_POST['phone'];
    $salt= MD5(microtime(true));
    //$regex = preg_match('[@_!#$%^&*()<>?/|}{~:]', $_POST['password']);
    $validpass = false;
    if(strlen($_POST['password']) >= 16 && 1 === preg_match('~[0-9]~', $_POST['password']) && strtolower($_POST['password']) != $_POST['password'] && strtoupper($_POST['password']) != $_POST['password']) {
        $validpass=true;
    }
    $product->password_hash = MD5($_POST['password'] . $salt);
    $product->password_salt = $salt;
    $product->address = $_POST['address'];
    $product->address2 = $_POST['address2'];
    $product->city = $_POST['city'];
    $product->state = $_POST['state'];
    $product->zip_code = $_POST['zip_code'];
    
  
    // create the product
    if($validpass) {
        if($product->create()){
            echo "<div class='alert alert-success'>User was created.</div>";
            // try to upload the submitted file
    // uploadPhoto() method will return an error message, if any.
        }
      
        // if unable to create the product, tell the user
        else{
            echo "<div class='alert alert-danger'>Unable to create user.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid password. Please try again.</div>";   
    }
}
?>
<!-- HTML form for creating a product -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
  
    <table class='table table-hover table-responsive table-bordered'>
        <tr><td>Role</td><td>
            <select name='role'>
                <option value='Admin'>Admin</option>
                <option value='User' selected>User</option>
            </select>
            </td>
        </tr>
        <tr><td>First</td><td><input type='text' name='fname' class='form-control' /></td></tr>
        <tr><td>Last</td><td><input type='text' name='lname' class='form-control' /></td></tr>
        <tr><td>Email</td><td><input type='text' name='email' class='form-control' /></td></tr>
        <tr><td>Phone</td><td><input type='text' name='phone' class='form-control' /></td></tr>
        <tr><td>Password</td><td><input type='password' name='password' class='form-control' /></td></tr>
        <!--
        <tr><td>Password Hash</td><td><input type='text' name='password_hash' class='form-control' /></td></tr>
        <tr><td>Password Salt</td><td><input type='text' name='password_salt' class='form-control' /></td></tr>
        -->
        <tr><td>Address</td><td><input type='text' name='address' class='form-control' /></td></tr>
        <tr><td>Address 2</td><td><input type='text' name='address2' class='form-control' /></td></tr>
        <tr><td>City</td><td><input type='text' name='city' class='form-control' /></td></tr>
        <tr><td>State</td><td><input type='text' name='state' class='form-control' /></td></tr>
        <tr><td>Zip Code</td><td><input type='text' name='zip_code' class='form-control' /></td></tr>
  
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>
    </table>
</form>
<?php
// footer
include_once "layout_footer.php";
?>