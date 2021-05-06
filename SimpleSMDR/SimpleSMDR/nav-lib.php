<?php
function top()
{ 
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<title>Simple SMDR Reporting Application </title> 
<link rel="stylesheet" type="text/css" media="screen" href="style.css">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
</head>
<body align = "center"> 
<a href='index.php'> <img src='images/simplesmdrlogo.jpg'>  </a>
<div align="center">
 <div class="navbar">
   <a href='results.php'>Search All</a>
   <a href='user.php'>Extensions</a>
   <a href='accountcodelist.php'>Account Codes</a>
   <a href='trunk.php'>Trunks</a>
   <a href='pbx.php'>PBX Configuration</a>
  <div class="dropdown">
    <button class="dropbtn">Administration</button>
    <div class="dropdown-content">
      <a href="empty.php?a=delall">Delete all call data</a>
      <a href="https://simplesmdr.sourceforge.io" target="_blank">About</a>
    </div>
  </div>
 </div>
</div>
 <td align='center' valign='top'>
<?php
}

function bottom() 
{
  ?>
</td>

<?php
}
?>