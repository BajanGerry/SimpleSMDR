<?php
/**
 * MyClass File Doc Comment
 * php version 7.4.3
 * 
 * @category Php
 * @package  SimpleSMDR
 * @author   Gerry Armstrong <bajangerry@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://simplesmdr.sourceforge/net
 */
require "config.php";
top();
?>
<html>
<head>
<title>SMDR reporting</title>
<script src='https://code.jquery.com/jquery-3.3.1.js'></script>
</head>
<div align="center" id="links">
  <h2><a href='https://simplesmdr.sourceforge.io' target ="_blank">
  Please visit the website for latest information</a></h2>
<!--  <img src="images/smdr.gif" width=650/> -->
<iframe src="https://simplesmdr.sourceforge.io" width="700" height="700"></iframe>
</div>
<script src="http://code.jquery.com/jquery-latest.min.js"
type="text/javascript"></script>
<script type='text/javascript'>
var timeout = setInterval(reloadChat, 10000);    
function reloadChat () {

     $('#links').load('main.php');
}
</script>
</html>