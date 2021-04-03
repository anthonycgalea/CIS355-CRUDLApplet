<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
}
// search form
echo "<form role='search' action='search.php'>";
    echo "<div class='input-group col-md-3 pull-left margin-right-1em'>";
        $search_value=isset($search_term) ? "value='{$search_term}'" : "";
        echo "<input type='text' class='form-control' placeholder='Type product name or description...' name='s' id='srch-term' required {$search_value} />";
        echo "<div class='input-group-btn'>";
            echo "<button class='btn btn-primary' type='submit'><i class='glyphicon glyphicon-search'></i></button>";
        echo "</div>";
    echo "</div>";
echo "</form>";
  
// create product button
echo "<div class='right-button-margin'>";
    echo "<a href='create_person.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-plus'></span> Create User";
    echo "</a>";
echo "</div>";
  
// display the products if there are any
if($total_rows>0){
  
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>User ID</th>";
            echo "<th>Role</th>";
            echo "<th>First</th>";
            echo "<th>Last</th>";
            echo "<th>Email</th>";
            echo "<th>Phone</th>";
            echo "<th>Address</th>";
            echo "<th>Address 2</th>";
            echo "<th>City</th>";
            echo "<th>State</th>";
            echo "<th>Zip Code</th>";
            echo "<th>Actions</th>";            
        echo "</tr>";
  
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  
            extract($row);
  
            echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$role}</td>";
                echo "<td>{$fname}</td>";
                echo "<td>{$lname}</td>";
                echo "<td>{$email}</td>";
                echo "<td>{$phone}</td>";
                echo "<td>{$address}</td>";
                echo "<td>{$address2}</td>";
                echo "<td>{$city}</td>";
                echo "<td>{$state}</td>";
                echo "<td>{$zip_code}</td>";
  
                echo "<td>";
  
                    // read product button
                    echo "<a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>";
                        echo "<span class='glyphicon glyphicon-list'></span> Read";
                    echo "</a>";
  
                    // edit product button
                    echo "<a href='update_person.php?id={$id}' class='btn btn-info left-margin'>";
                        echo "<span class='glyphicon glyphicon-edit'></span> Edit";
                    echo "</a>";
  
                    // delete product button
                    if ($_SESSION['role']=="Admin") {
                        echo "<a href='delete_person.php?id={$id}' class='btn btn-danger'>";
                            echo "<span class='glyphicon glyphicon-remove'></span> Delete";
                        echo "</a>";
                    }
  
                echo "</td>";
  
            echo "</tr>";
  
        }
  
    echo "</table>";
  
    // paging buttons
    include_once 'paging.php';
}
  
// tell the user there are no products
else{
    echo "<div class='alert alert-danger'>No products found.</div>";
}
?>