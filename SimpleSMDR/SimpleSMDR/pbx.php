<?php
include("config.php");
top();
if (($_GET['Submit'])){
    $pbx = $_GET['pbx'];
    $port = $_GET['port'];
    $pbx = "pbx = " . $pbx;
    $port = "port = " . $port;
    $file = fopen("../config.ini","w");
    fwrite($file,$pbx.PHP_EOL);
    fwrite($file,$port.PHP_EOL);
    fclose($file);
    echo "Config updated successfully";
}
    $filename = "../config.ini";
    $names = file($filename);
    $pbx = $names[0];
    $port = $names[1];
    $pbx = substr(strrchr($pbx, "="), 2);
    $port = substr(strrchr($port, "="), 2);
?>
<form id="form1" name="form1" method="get" action="<?=$_SERVER['PHP_SELF'];?>">
  <h3>Update PBX Connection Details </h3>  
  <table align="center">
    <tr valign="baseline"> 
      <td>PBX IP:</td>
      <td><input type="text" name="pbx" value="<?php echo $pbx; ?>"</td>
    </tr>
    <tr valign="baseline"> 
      <td>Port:</td>
      <td><input type="text" name="port" value="<?php echo $port; ?>"></td>
    </tr>
    <tr valign="baseline"> 
      <td>&nbsp;</td>
      <td><input type="submit" value="Submit" name="Submit"></td>
    </tr>
  </table>  
</form>
