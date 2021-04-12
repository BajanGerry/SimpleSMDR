<?php
include "config.php";
top();
if (($_GET['Submit'])){
$first=$_GET['first'];
$surname=$_GET['last'];
$ext=$_GET['extension'];
$con->exec("INSERT INTO extension VALUES ($ext, '$first', '$surname')");
}
?>
<html>
<head>
<title>SMDR Reporting</title>
<style type="text/css">
<!--

table {
  background-color:#FFF;
  width:100%;
  border-collapse:collapse;
}
/* and of course a default one */
td {
  background-color:#FFF;
  padding:5px;
}
-->
</style>
</head>
<html>
<body>
<form id="form1" name="form1" method="get" action="<?=$_SERVER['PHP_SELF'];?>">
  <h3 align="center">Add New User Details </h3>  
  <table align="center">
    <tr valign="baseline"> 
      <td width="99" align="right" nowrap>Extension:</td>
      <td width="194"><input type="text" name="extension" value="" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">First Name:</td>
      <td><input type="text" name="first" value="" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Last Name:</td>
      <td><input type="text" name="last" value="" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Submit" name="Submit"></td>
    </tr>
  </table>  
</form>
</body>
</html>
