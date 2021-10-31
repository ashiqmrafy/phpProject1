<html>
<link rel="stylesheet" href="style.css">
<body>
<h1>BookStore</h1>
<span><a href="index.html">Home</a> | <a href="shop.php">Shop Now</a> | <a></a></span>
<br><br>
</body>
</html>
<?php
require("mysqli_connect.php");

//if method is get
if($_SERVER['REQUEST_METHOD'] == 'GET'){

    // Get ID to check if 1 or 2
    $login = $_GET['id'];

    // If 1 proceed ask username and password
    if($login == 1){
        echo '<form action="login.php" method="POST">';
        echo '<p>Username: <input type="text" name="username"></p>';
        echo '<p>Password: <input type="text" name="password"></p>';
        echo '<p><input type="submit"></p>';
        echo '</form>';
    //else redirect to register.php
    }else{
        header("location: register.php");
    }
//if method is post validate username and password and redirect to shop page
}else{
    if(!empty($_POST['username']) && !empty($_POST['password'])){

        
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        
        $q = "SELECT * FROM customers WHERE username = ? AND password = ?";
        
        $stmt = mysqli_prepare($dbc, $q);

        mysqli_stmt_bind_param($stmt, 'ss', $username, $password);

        mysqli_stmt_execute($stmt);
        
        mysqli_stmt_store_result($stmt);
    
        if(mysqli_stmt_num_rows($stmt) == 1){
            session_start();
            $_SESSION['username'] = $username;
            
            header("location: shop.php");
        }
        else{
            echo "Invalid Login Information";
        }
        
    }
}
?>