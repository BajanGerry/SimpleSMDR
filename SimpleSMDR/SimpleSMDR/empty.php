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
		break;
	case trunk:
		$value=($_GET['trunk']);
		$trkdel = $con->prepare("delete from trunks WHERE trunk='$value'");
		$trkdel->execute();
		?> <a href='trunk.php'> Trunk has been deleted, return to previous page</a>
<?php
		break;
	case acc:
		$value=($_GET['acc']);
		$accdel = $con->prepare("delete from accountcode WHERE accountcode=$value");
		$accdel->execute();
		?> <a href='accountcodelist.php'> Accountcode has been deleted, return to previous page</a>
<?php
		break;
	case data:
		$value=($_GET['data']);
		$datadel = $con->prepare("delete from import WHERE id=$value");
		$datadel->execute();
		?> <a href='results.php'> DATA Record(s) has been deleted, return to previous page</a>
<?php
		break;
	case delall:
		$dadel = $con->prepare("delete from import");
		$dadel->execute();
		?> <a href='results.php'> All data records has been deleted, return to previous page</a>
<?php
		break;
}
?>