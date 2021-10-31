<?php

    // when posted validate the fields and insert to customer table
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require("mysqli_connect.php");
    
        $first_name = $_POST['firstname'];
        $last_name = $_POST['lastname'];
        $email = $_POST['emailid'];
        $phone = $_POST['phonenumber'];
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        if(empty($first_name) || empty($username) || empty($last_name) || empty($email) || empty($phone) || empty($password)){
            echo "Blank entry not allowed";
        }else{

            //Check if username provided is unique
            $q1 = "SELECT * FROM customers";
            $r = mysqli_query($dbc, $q1);
            $flag = true;
            while($row = mysqli_fetch_array($r)){
                if(strcmp($row['username'], $username) == 0){
                    $flag = false;
                }
            }

            //if username is unique insert to table
            if($flag){
                
                $q = "INSERT INTO customers VALUES (null,?,?,?,?,?,?)";
                
                $stmt = mysqli_prepare($dbc, $q);
                
                mysqli_stmt_bind_param($stmt, 'ssssss', $first_name, $last_name, $email, $phone, $username, $password);
                
                mysqli_stmt_execute($stmt);
                
                if(mysqli_affected_rows($dbc) == 1){
                    session_start();
                    $_SESSION['username'] = $username;
                    header("location: shop.php");
                }
                else{
                    echo "Invalid Information: ".mysqli_stmt_error($stmt);
                }
            }else{
                echo "Enter Unique UserID";
            }
        }
    }

?>
<html>
<link rel="stylesheet" href="style.css">
<body>
<h1>BookStore</h1>
<span><a href="index.html">Home</a> | <a href="shop.php">Shop Now</a> | <a></a></span>
<br><br>
<form action="register.php" method="POST">
    <p>First Name: <input type="text" name="firstname" value="<?php
                if(isset($first_name)){
                    echo $first_name;
                }
            ?>"></p>
    <p>Last Name: <input type="text" name="lastname" value="<?php
                if(isset($last_name)){
                    echo $last_name;
                }
            ?>"></p>
    <p>Email ID: <input type="text" name="emailid" value="<?php
                if(isset($email)){
                    echo $email;
                }
            ?>"></p>
    <p>Phone Number: <input type="text" name="phonenumber" value="<?php
                if(isset($phone)){
                    echo $phone;
                }
            ?>"></p>
    <p>Username: <input type="text" name="username" value="<?php
                if(isset($username)){
                    echo $username;
                }
            ?>"></p>
    <p>Password: <input type="text" name="password"></p>
    <p><input type="submit"></p>
</form>
</body>
</html>