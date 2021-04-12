<?php
function top()  { 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<title>Simple SMDR Reporting Application </title> 
<link rel="stylesheet" type="text/css" media="screen" href="style.css">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
<style type="text/css">@import url("style.css"); </style>
</head>
<body align = "center"> 
<a href='index.php'> <img src='images/simplesmdrlogo.jpg'>  </a>
<div id="menucase" align="center">
  <div id="styletwo">
    <ul>
      <li><a href='results.php'>Search All</a></li>
      <li><a href='user.php'>Extensions</a></li>
      <li><a href='accountcodelist.php'>Account Codes</a></li>
      <li><a href='trunk.php'>Trunks</a></li>
      <li><a href='pbx.php'>PBX Configuration</a></li>
    </ul>
  </div>
</div>

 
<td align='center' valign='top'>
<?php
}
  // this is the bottom of the page..
function bottom() {
?>
</td>

<?php
}
/****** ** pass by reference **********/ 
?>