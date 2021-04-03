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
}

// check if value was posted
    //console_log($_GET);
      console_log("THIS NEEDS TO WORK");
    if($_GET){
        // include database and object file
        include_once 'config/database.php';
        include_once 'objects/person.php';
      
        // get database connection
        $database = new Database();
        $db = $database->getConnection();
      
        // prepare product object
        $product = new Person($db);
          
        // set product id to be deleted
        $product->id = $_GET['id'];
         
        // delete the product
        if($product->delete()){
            echo "Person was deleted.";
        }
          
        // if unable to delete the product
    else{
        echo "Unable to delete object.";
    }
}


function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
?>