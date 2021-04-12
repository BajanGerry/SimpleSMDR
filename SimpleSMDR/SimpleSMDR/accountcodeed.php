<?php
include "config.php";
top();
$url = $_GET['a'];
if (($_GET['Submit'])){
$accountcode=$_GET['AccNo'];
$name=$_GET['name'];
$stup = $con->query("UPDATE accountcode SET name = '$name' WHERE accountcode= '$accountcode'");
$stup->execute();
$url=$accountcode;
}
$sth = $con->prepare("SELECT * FROM accountcode WHERE `accountcode` = $url");
$sth->execute();
$result = $sth->fetchAll();
?>
<html>
<body>
<?php
 foreach ($result as $row) {
?>
<form id="form1" name="form1" method="get" action="<?=$_SERVER['PHP_SELF'];?>">
  <h3 align="center">Update Account Code Details </h3>  
  <table align="center">
    <tr valign="baseline"> 
      <td width="99" align="right" nowrap><strong>Account Code:</strong></td>
      <td width="194"><?php echo $row["accountcode"]; ?></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right"><strong>Name:</strong></td>
      <td><input type="text" name="name" value="<?php echo $row["name"] ?>" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Submit" name="Submit"></td>
       <input type="hidden" name="AccNo" value="<?php echo $row["accountcode"]; ?>">
    </tr>
  </table>  
</form>
<?php
}?>
</body>
</html>
