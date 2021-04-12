<?php

include "config.php";
top();
if (($_GET['Submit'])){
$accountcode=$_GET['accountcode'];
$name=$_GET['name'];
$con->exec("INSERT INTO accountcode (`accountcode`, `name`) VALUES('$accountcode','$name')");
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
/*  border:1px solid black;*/
  padding:5px;
}
-->
</style>
</head>
<html>
<body>
<form id="form1" name="form1" method="get" action="<?=$_SERVER['PHP_SELF'];?>">
  <h3 align="center">Add Account Code Details </h3>  
  <table align="center">
    <tr valign="baseline"> 
      <td nowrap align="right">Account Code:</td>
      <td><input type="text" name="accountcode" value="" size="32"></td>
    </tr>
    <tr valign="baseline"> 
      <td nowrap align="right">Name:</td>
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
