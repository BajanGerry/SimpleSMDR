<?php
include ("config.php");
$output = shell_exec('netstat -na');
if (str_contains($output, ':1752')) {
    $state = "up";

}
else {
$state = "down";
}
?>
<html>
<div align="center">
  <h3><?php if ($state == "up") {echo "<font color='green'>The PBX connection is UP</font>"; } else {echo "<font color='red'>The PBX connection is DOWN!</font>"; } ?></h3>
  <h3>These are the 10 most recent records</h3>
</div>
<?php
$rowno=0;
$sth = $con->prepare("SELECT * FROM `import` ORDER BY id DESC LIMIT 10");
$sth->execute();
$result = $sth->fetchAll();
?>
<body>
<table border="1" id="opencalls">
  <tr>
    <td nowrap><div align="center"> <font size="-1"><strong>Year</strong></font></div></td>
    <td nowrap><div align="center"> <font size="-1"><strong>Mth</strong></font></div></td>
    <td nowrap><div align="center"> <font size="-1"><strong>Day</strong></font></div></td>
    <td nowrap><div align="center"> <font size="-1"><strong>Time</strong></font></div></td>
    <td nowrap><div align="center"> <font size="-1"><strong>Call Length</strong></font></div></td>
    <td nowrap><div align="center"> <font size="-1"><strong>Call Source</strong></font></div></td>
    <td nowrap><div align="center"> <font size="-1"><strong>Called No</strong></font></div></td>
    <td nowrap><div align="center"> <font size="-1"><strong>Account Code</strong></font></div></td>
    <td nowrap><div align="center"> <font size="-1"><strong>Called Party</strong></font></div></td>
    <td nowrap><div align="center"> <font size="-1"><strong>Transfer Ext</strong></font></div></td>
    <td nowrap><div align="center"> <font size="-1"><strong>Call ID</strong></font></div></td>
    <td nowrap><div align="center"> <font size="-1"><strong>Call Seq</strong></font></div></td>
    <td nowrap><div align="center"> <font size="-1"><strong>Associated</strong></font></div></td>
    <td nowrap><div align="center"> <font size="-1"><strong>System ID</strong></font></div></td>
  </tr>
<?php
foreach ($result as $row) {
$rowno += 1;

$cip = preg_replace('/[^A-Za-z0-9]/', '', "{$row["callingparty"]}");
if ($cip[0] == "T" ||$cip[0] == "X") {
	$extquery = $con->query("SELECT `name` FROM trunks WHERE trunk = '$cip'");
	$extquery->execute();
	$extprint = $extquery->fetch();
}
else {
	$extquery1 = $con->query("SELECT `first` FROM `extension` WHERE `extension` = '$cip'");
	$extquery1->execute();
	$extprint = $extquery1->fetch();
}
//Get Trunk name
$cp = preg_replace('/[^A-Za-z0-9]/', '', "{$row["calledparty"]}");
if ($cp[0] == "T" ||$cp[0] == "X") {
	$tquery = $con->query("SELECT `name` FROM trunks WHERE trunk = '$cp'");
	$tquery->execute();
	$tresult = $tquery->fetch();
}
else {
	$tquery1 = $con->query("SELECT `first` FROM `extension` WHERE `extension` = '$cp'");
	$tquery1->execute();
	$tresult = $tquery1->fetch();
	}

?>
  <tr> 
    <td><div align="center"><font size="-1"><?php echo $row["year"];?></A></font></div></td>
    <td><div align="center"><font size="-1"><?php echo $row["month"];?></A></font></div></td>
    <td><div align="center"><font size="-1"><?php echo $row["day"]; ?></font></div></td>
    <td><div align="center"><font size="-1"><?php echo $row["time"];?></font></div></td>
    <td><div align="center"><font size="-1"><?php echo $row["hrs"];?>:<?php echo $row["mins"];?>:<?php echo $row["sec"]; ?></font></div></td>
    <td><div align="center"><font size="-1"><?php echo $fi;?> <?php echo $extprint["name"];?> <?php echo $extprint["first"];?> <?php echo $row["callingparty"];?></font></div></td>
    <td><div align="center"><font size="-1"><?php echo $row["calledno"];?></font></div></td>
    <td><div align="center"><font size="-1"><?php echo $row["accountcode"];?></font></div></td>
    <td><div align="center"><font size="-1"><?php echo $se;?> <?php echo $tresult["first"];?> <?php echo $tresult["name"];?> <?php echo $row["calledparty"];?></font></div></td>
    <td><div align="center"><font size="-1"><?php echo $row["transferext"];?></font></div></td>
    <td><div align="center"><font size="-1"><?php echo $row["callid"];?></A></font></div></td>
    <td><div align="center"><font size="-1"><?php echo $row["callseq"];?></A></font></div></td>
    <td><div align="center"><font size="-1"><?php echo $row["assocall"];?></A></font></div></td>
    <td><div align="center"><font size="-1"><?php echo $row["sysid"];?></A></font></div></td>
  </tr>
  <?php
}
?>

</table>
</body>
</html>