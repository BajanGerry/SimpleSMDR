<?php
include "config.php";
top();
$url = $_GET['a'];
if (($_GET['Submit'])){
$first=$_GET['first'];
$surname=$_GET['last'];
$ext=$_GET['ExtID'];
$url = $ext;
$stup = $con->prepare("UPDATE extension SET `last` = '$surname', `first` = '$first' WHERE extension=$url");
$stup->execute();
}
$sth = $con->prepare("SELECT * FROM `extension` WHERE extension = $url");
$sth->execute();
$result = $sth->fetchAll();
?>
<html>
<body>
<?php
 foreach ($result as $row) {
$rowno += 1;
?>
<form id="form1" name="form1" method="get" action="<?=$_SERVER['PHP_SELF'];?>">
  <h3 align="center">Update User Details </h3>  
  <table align="center">
    <tr valign="baseline"> 
      <td>Extension:</td>
      <td><?php echo $row["extension"]; ?></td>
    </tr>
    <tr valign="baseline"> 
      <td>First Name:</td>
      <td><input type="text" name="first" value="<?php echo $row["first"]; ?>"></td>
    </tr>
    <tr valign="baseline"> 
      <td>Last Name:</td>
      <td><input type="text" name="last" value="<?php echo $row["last"]; ?>"></td>
    </tr>
    <tr valign="baseline"> 
      <td>&nbsp;</td>
      <td><input type="submit" value="Submit" name="Submit"></td>
       <input type="hidden" name="ExtID" value="<?php echo $row["extension"]; ?>">
    </tr>
  </table>  
</form>
<?php
}?>
</body>
</html>