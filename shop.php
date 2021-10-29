<html>
<link rel="stylesheet" href="style.css">
<body>
<h1>BookStore</h1>
<span><a href="index.html">Home</a> | <a href="shop.php">Shop Now</a> | <a></a></span>
<br><br>
<table>
  <tr>
    <th>S.No.</th>
    <th>Book Name</th>
    <th>Author</th>
  </tr>
    <?php
    session_start();
    require("mysqli_connect.php");
    $q = "SELECT * FROM BookInventry";
    $r = mysqli_query($dbc, $q);
    $counter = 1;
    while($row = mysqli_fetch_array($r)){
        echo "<tr><td>".$counter."</td>";
        echo "<td><a href='checkout.php?id=".$row["bookid"]."'>".$row["bookname"]."</a></td>";
        echo "<td>".$row["bookauthor"]."</td></tr>";
        $counter++;
    }
    ?>    
</table>
</body>
</html>