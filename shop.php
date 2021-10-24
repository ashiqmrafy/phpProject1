<html>
<body>
<h1>BookStore</h1>
<span><a href="index.html">Home</a> | <a href="shop.php">Shop Now</a> | <a></a></span>
    <?php
    session_start();
    require("mysqli_connect.php");
    $q = "SELECT * FROM BookInventry";
    $r = mysqli_query($dbc, $q);
    while($row = mysqli_fetch_array($r)){
        echo "<p>".$row["bookname"]."</p>";
    }
    ?>    
</body>
</html>