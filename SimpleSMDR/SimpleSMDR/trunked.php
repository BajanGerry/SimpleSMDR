<?php
include "config.php";
top();
$url = $_GET['a'];
if (($_GET['Submit'])){
$trunk=$_GET['trunk'];
$name=$_GET['name'];
$url=$_GET['TrunkID'];
$stup = $con->prepare("UPDATE trunks SET `name` = '$name' WHERE `trunk` = '$url'");
$stup->execute();
}
$sth = $con->prepare("SELECT * FROM trunks WHERE trunk = '$url'");
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
  <h3 align="center">Update Trunk Details </h3>  
  <table align="center">
    <tr valign="baseline"> 
      <td nowrap align="right">Trunk #:</td>
      <td ><?php echo $row["trunk"]; ?></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Name:</td>
      <td><input type="text" name="name" value="<?php echo $row["name"]; ?>" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Submit" name="Submit"></td>
	  <input type="hidden" name="TrunkID" value="<?php echo $row["trunk"];?>">
    </tr>
  </table>  
</form>
<?php
}?>
</body>
</html>