<?php
include "config.php";
top();
$url = $_GET['a'];
switch ($url){
	case ext:
		$value=($_GET['ext']);
		$extdel = $con->prepare("delete from extension WHERE extension=$value");
		$extdel->execute();
		?> <a href='user.php'> Extension has been deleted, return to previous page</a>
<?php
	case trunk:
		$value=($_GET['trunk']);
		$extdel = $con->prepare("delete from trunks WHERE trunk=$value");
		$extdel->execute();
		?> <a href='trunk.php'> Trunk has been deleted, return to previous page</a>
<?php
	case acc:
		$value=($_GET['acc']);
		$extdel = $con->prepare("delete from accountcode WHERE accountcode=$value");
		$extdel->execute();
		?> <a href='accountcodelist.php'> Accountcode has been deleted, return to previous page</a>
<?php
	case data:
		$value=($_GET['data']);
		$datadel = $con->prepare("delete from import WHERE id=$value");
		$datadel->execute();
		?> <a href='results.php'> Record(s) has been deleted, return to previous page</a>
<?php
	case all:
		$value=($_GET['all']);
		$datadel = $con->prepare("delete from import");
		$datadel->execute();
		?> <a href='results.php'> All data records has been deleted, return to previous page</a>
<?php
}
?>
