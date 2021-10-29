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

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    $login = $_GET['id'];

    if($login == 1){
        echo '<form action="login.php" method="POST">';
        echo '<p>Username: <input type="text" name="username"></p>';
        echo '<p>Password: <input type="text" name="password"></p>';
        echo '<p><input type="submit"></p>';
        echo '</form>';
    }else{
        header("location: register.php");
    }
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
            
            header("location: shop.php");
        }
        else{
            echo "Invalid Login Information";
        }
        
    }
}
?>