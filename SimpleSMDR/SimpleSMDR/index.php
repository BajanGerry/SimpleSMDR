<?php
include("config.php");
top();
?>
<html>
<head>
<title>SMDR reporting</title>
<script src='https://code.jquery.com/jquery-3.3.1.js'></script>
</head>
<div align="center" id="links">
  <h2>Welcome to <i>Simple</i>SMDR</h2>
  <img src="images/smdr.gif" width=650/>
</div>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script type='text/javascript'>
var timeout = setInterval(reloadChat, 10000);    
function reloadChat () {

     $('#links').load('main.php');
}
</script>
</html>