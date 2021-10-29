<html>
<link rel="stylesheet" href="style.css">
<body>
<h1>BookStore</h1>
<span><a href="index.html">Home</a> | <a href="shop.php">Shop Now</a> | <a></a></span>
<br><br>
</body>
</html>
<?php

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $bookid = $_GET['id'];
    require("mysqli_connect.php");
    
    $q = "SELECT * FROM BookInventry WHERE bookid = ".$bookid;
    $r = mysqli_query($dbc, $q);
        
    while($row = mysqli_fetch_array($r)){
        echo $row["bookname"];
        echo "<select name='books'>";
        for($i = 1; $i <= $row["bookquantity"]; $i++){
            echo "<option value='$i'>$i</option>";
        }
        echo "</select>";
    }


}
?>