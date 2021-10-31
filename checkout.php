<html>
<link rel="stylesheet" href="style.css">
<body>
<h1>BookStore</h1>
<span><a href="index.html">Home</a> | <a href="shop.php">Shop Now</a> | <a></a></span>
<br><br>
</body>
</html>
<?php

session_start();
require("mysqli_connect.php");
//if request method is GET display form
if($_SERVER['REQUEST_METHOD'] == 'GET'){

    $bookid = $_GET['id'];
    $_SESSION['bookid'] = $_GET['id'];
    
    //Get book name and quantity from id passed from shop page
    $q = "SELECT * FROM BookInventry WHERE bookid = ".$bookid;
    $r = mysqli_query($dbc, $q);
        
    while($row = mysqli_fetch_array($r)){
        $_SESSION['bookname'] = $row["bookname"];
        $_SESSION['bookq'] = $row["bookquantity"];
    }

    //if a registered or logged in user use the details to fill fields
    if(isset($_SESSION['username'])){
        $q1 = "SELECT * FROM customers WHERE username = '".$_SESSION['username']."'";
        $r1 = mysqli_query($dbc, $q1);
        while($row = mysqli_fetch_array($r1)){
            $_SESSION['customerid'] = $row['customerid'];
            
            $first_name = $row['firstname'];
            $last_name = $row['firstname'];
            $email = $row['emailid'];
            $phone = $row['phonenumber'];
        }
    }
//if method is post validate fields and update db
}else{
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['emailid'];
    $phone = $_POST['phonenumber'];
    $address = $_POST['address'];
    $postalcode = $_POST['postalcode'];
    if(empty($first_name) || empty($postalcode) || empty($last_name) || empty($email) || empty($phone) || empty($address)){
       
        echo "Blank entry not allowed";
    }else{
        if(!isset($_SESSION['customerid'])){
            $_SESSION['customerid'] = 0;
        }
        $inputQuantity = $_POST['books'];
        $qu = "INSERT INTO orders VALUES (null,?,?,?)";
        $stmt = mysqli_prepare($dbc, $qu);
        mysqli_stmt_bind_param($stmt, 'iii', $_SESSION['bookid'], $_SESSION['customerid'], $inputQuantity);
            
        mysqli_stmt_execute($stmt);
        if(mysqli_affected_rows($dbc) == 1){
            echo $_SESSION['customerid'];
            $query = "UPDATE bookinventry SET bookquantity = bookquantity-1 WHERE bookid = ".$_SESSION["bookid"];
            $r = mysqli_query($dbc, $query);

            if(mysqli_affected_rows($dbc) == 1){
                echo "Purchase Successful";
            }
        }
                
    }
}
?>

<form action="checkout.php" method="POST">
    <p>
    Please select the number of <?php echo $_SESSION['bookname'];?> books you want:
    <select name = "books">
        <?php 
            for($i = 1; $i <= $_SESSION['bookq']; $i++){
                echo "<option value='$i'>$i</option>";
            }
        ?>
    </select>
    </p>
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
    <p>Address: <input type="text" name="address" value="<?php
                if(isset($address)){
                    echo $address;
                }
            ?>"></p>
    <p>Postal Code: <input type="text" name="postalcode" value="<?php
                if(isset($postalcode)){
                    echo $postalcode;
                }
            ?>"></p>
    <p>
    <input type="radio" name="paymentmethod" checked>Credit
    <input type="radio" name="paymentmethod">Debit
    <input type="radio" name="paymentmethod">Paypal
    </p>
    <p><input type="submit"></p>
</form>