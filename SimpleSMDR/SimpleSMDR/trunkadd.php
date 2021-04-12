<?php
include "config.php";
top();
if (($_GET['Submit'])){
$number=$_GET['number'];
$name=$_GET['name'];
$con->exec("INSERT INTO trunks (trunk, name) VALUES ('$number', '$name')");
}
?>
<html>
<body>
<form id="form1" name="form1" method="get" action="<?=$_SERVER['PHP_SELF'];?>">
  <h3 align="center">Add New Trunk Details </h3>  
  <table align="center">
    <tr valign="baseline"> 
      <td width="99" align="right" nowrap>Trunk#:</td>
      <td width="194"><input type="text" name="number" value="" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Trunk Name:</td>
      <td><input type="text" name="name" value="" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Submit" name="Submit"></td>
    </tr>
  </table>  
</form>
</body>
</html>
