<?php
include("config.php");
top();
if (isset($_POST['pageno'])) {
    $pageno = $_POST['pageno'];
} else {
    $pageno = 1;
}
$rowno=0;
if($_POST['year'] ==null ){$year_var = '%';} else {$year_var = $_POST['year'];}
if($_POST['month'] ==null ){$month_var = '%';} else {$month_var= $_POST['month'];}
if($_POST['day'] ==null ){$day_var = '%';} else {$day_var= $_POST['day'];}
if($_POST['time'] ==null ){$time_var = '%';} else {$time_var= $_POST['time'];}
if($_POST['caller'] ==null ){$caller_var = '%';} else {$caller_var= $_POST['caller'];}
if($_POST['calledno'] ==null ){$calledno_var = '%';} else {$calledno_var= $_POST['calledno'];}
if($_POST['accountcode'] ==null ){$accountcode_var = '%';} else {$accountcode_var= $_POST['accountcode'];}
if($_POST['calledparty'] ==null ){$calledparty_var = '%';} else {$calledparty_var= $_POST['calledparty'];}
if($_POST['transferext'] ==null ){$transferext_var = '%';} else {$transferext_var= $_POST['transferext'];}
if($_POST['callid'] ==null ){$callid_var = '%';} else {$callid_var= $_POST['callid'];}
if($_POST['callseq'] ==null ){$callseq_var = '%';} else {$callseq_var= $_POST['callseq'];}
if($_POST['assocall'] ==null ){$assocall_var = '%';} else {$assocall_var= $_POST['assocall'];}
if($_POST['sysid'] ==null ){$sysid_var = '%';} else {$sysid_var= $_POST['sysid'];}

$sth = $con->prepare("SELECT * FROM `import` WHERE `year` LIKE '$year_var' AND `month` LIKE '$month_var' AND `callingparty` LIKE '$caller_var'  AND `day` LIKE '$day_var' AND `time` LIKE '$time_var' AND `calledno` LIKE '$calledno_var' AND `calledparty` LIKE '$calledparty_var' AND `transferext` LIKE '$transferext_var' AND `accountcode` LIKE '$accountcode_var' AND `sysid` LIKE '$sysid_var' AND `callid` LIKE '$callid_var' AND `callseq` LIKE '$callseq_var' AND `assocall` LIKE '$assocall_var' ORDER BY id ASC");
$sth->execute();
$result = $sth->fetchAll();
$count = $con->prepare("SELECT COUNT(*) FROM `import`");
?>

<table border="1" id="opencalls">
  <tr>
    <td nowrap><div > <font size="-1"><strong>Row</strong></font></div></td>
    <td nowrap><div > <font size="-1"><strong>Year</strong></font></div></td>
    <td nowrap><div > <font size="-1"><strong>Mth</strong></font></div></td>
    <td nowrap><div > <font size="-1"><strong>Day</strong></font></div></td>
    <td nowrap><div > <font size="-1"><strong>Time</strong></font></div></td>
    <td nowrap><div > <font size="-1"><strong>Call Length</strong></font></div></td>
    <td nowrap><div > <font size="-1"><strong>Call Source</strong></font></div></td>
    <td nowrap><div > <font size="-1"><strong>Called No</strong></font></div></td>
    <td nowrap><div > <font size="-1"><strong>Account Code</strong></font></div></td>
    <td nowrap><div > <font size="-1"><strong>Called Party</strong></font></div></td>
    <td nowrap><div > <font size="-1"><strong>Transfer Ext</strong></font></div></td>
    <td nowrap><div > <font size="-1"><strong>Call ID</strong></font></div></td>
    <td nowrap><div > <font size="-1"><strong>Call Seq</strong></font></div></td>
    <td nowrap><div > <font size="-1"><strong>Associated</strong></font></div></td>
    <td nowrap><div > <font size="-1"><strong>System ID</strong></font></div></td>
    <td nowrap><div > <font size="-1"><strong>Delete Record</strong></font></div></td>
  </tr>
<tr>
  <div><form action="<?=$_SERVER['PHP_SELF'];?>" method="POST" name="Seach form">
  <td nowrap ><strong>
	<?php
	echo "N/A";
	?>
	</strong></td>
	<td nowrap><select name="year" >
	<?php
		$sthres = $con->query("SELECT DISTINCT `year` FROM `import`");
		$sthres->execute();
		$resyear = $sthres->fetchAll();
		echo '<option value="'.$year_var.'">'.$year_var.'</option>';
		echo '<option value=""></option>';
		foreach ($resyear as $row) {
		echo("<option value='".$row['year']."'>".$row['year']."</option>");
		}
	?>
	</td>
    <td nowrap><select name="month" >
	<?php
		$sthmonth = $con->query("SELECT DISTINCT `month` FROM `import`");
		$sthmonth->execute();
		$resmonth = $sthmonth->fetchAll();
		echo '<option value="'.$month_var.'">'.$month_var.'</option>';
		echo '<option value=""></option>';
		foreach ($resmonth as $row) {
	    echo("<option value='".$row['month']."'>".$row['month']."</option>");
		}
	?>
	</td>
    <td nowrap><select name="day" >
	<?php
		$sthday = $con->query("SELECT DISTINCT `day` FROM `import`");
		$sthday->execute();
		$resday = $sthday->fetchAll();
		echo '<option value="'.$day_var.'">'.$day_var.'</option>';
		echo '<option value=""></option>';
		foreach ($resday as $row) {
	    echo("<option value='".$row['day']."'>".$row['day']."</option>");
		}
	?>
	</td>
    <td nowrap><select name="time" >
	<?php
		$sthtime = $con->query("SELECT DISTINCT `time` FROM `import`");
		$sthtime->execute();
		$restime = $sthtime->fetchAll();
		echo '<option value="'.$time_var.'">'.$time_var.'</option>';
		echo '<option value=""></option>';
		foreach ($restime as $row) {
		echo("<option value='".$row['time']."'>".$row['time']."</option>");
		}
	?>
	</td>
    <td nowrap ><strong>
	<?php
		echo "N/A";
	?>
	</strong></td>
    <td nowrap><select name="caller" >
	<?php
		$sthcp = $con->query("SELECT DISTINCT `callingparty` FROM `import`");
		$sthcp->execute();
		$rescp = $sthcp->fetchAll();
		echo '<option value="'.$caller_var.'">'.$caller_var.'</option>';
		echo '<option value=""></option>';
		foreach ($rescp as $row) {
		echo("<option value='".$row['callingparty']."'>".$row['callingparty']."</option>");
		}
	?>
	</td>
    <td nowrap><select name="calledno" >
	<?php
		$sthcn = $con->query("SELECT DISTINCT `calledno` FROM `import`");
		$sthcn->execute();
		$rescn = $sthcn->fetchAll();
		echo '<option value="'.$calledno_var.'">'.$calledno_var.'</option>';
		echo '<option value=""></option>';
		foreach ($rescn as $row) {
		echo("<option value='".$row['calledno']."'>".$row['calledno']."</option>");
		}
	?>
	</td>
    <td nowrap><select name="accountcode" >
	<?php
		$sthac = $con->query("SELECT DISTINCT `accountcode` FROM `import`");
		$sthac->execute();
		$resac = $sthac->fetchAll();
		echo '<option value="'.$accountcode_var.'">'.$accountcode_var.'</option>';
		echo '<option value=""></option>';
		foreach ($resac as $row) {
		echo("<option value='".$row['accountcode']."'>".$row['accountcode']."</option>");
		}
	?>
	</td>
    <td nowrap><select name="calledparty" >
	<?php
		$sthcpp = $con->query("SELECT DISTINCT `calledparty` FROM `import`");
		$sthcpp->execute();
		$rescpp = $sthcpp->fetchAll();
		echo '<option value="'.$calledparty_var.'">'.$calledparty_var.'</option>';
		echo '<option value=""></option>';
		foreach ($rescpp as $row) {
		echo("<option value='".$row['calledparty']."'>".$row['calledparty']."</option>");
		}
	?>
	</td>
    <td nowrap><select name="transferext" >
	<?php
		$sthtf = $con->query("SELECT DISTINCT `transferext` FROM `import`");
		$sthtf->execute();
		$restf = $sthtf->fetchAll();
		echo '<option value="'.$transferext_var.'">'.$transferext_var.'</option>';
		echo '<option value=""></option>';
		foreach ($restf as $row) {
		echo("<option value='".$row['transferext']."'>".$row['transferext']."</option>");
		}
	?>
	</td>
    <td nowrap><select name="callid" >
	<?php
		$sthid = $con->query("SELECT DISTINCT `callid` FROM `import`");
		$sthid->execute();
		$resid = $sthid->fetchAll();
		echo '<option value="'.$callid_var.'">'.$callid_var.'</option>';
		echo '<option value=""></option>';
		foreach ($resid as $row) {
		echo("<option value='".$row['callid']."'>".$row['callid']."</option>");
		}
	?>
	</td>
    <td nowrap><select name="callseq" >
	<?php
		$sthcs = $con->query("SELECT DISTINCT `callseq` FROM `import`");
		$sthcs->execute();
		$rescs = $sthcs->fetchAll();
		echo '<option value="'.$callseq_var.'">'.$callseq_var.'</option>';
		echo '<option value=""></option>';
		foreach ($rescs as $row) {
		echo("<option value='".$row['callseq']."'>".$row['callseq']."</option>");
		}
	?>
	</td>
    <td nowrap><select name="assocall" >
	<?php
		$sthac = $con->query("SELECT DISTINCT `assocall` FROM `import`");
		$sthac->execute();
		$resac = $sthac->fetchAll();
		echo '<option value="'.$assocall_var.'">'.$assocall_var.'</option>';
		echo '<option value=""></option>';
		foreach ($resac as $row) {
		echo("<option value='".$row['assocall']."'>".$row['assocall']."</option>");
		}
	?>
	</td>
	<td nowrap><select name="sysid" >
	<?php
		$sthsys = $con->query("SELECT DISTINCT `sysid` FROM `import`");
		$sthsys->execute();
		$ressys = $sthsys->fetchAll();
		echo '<option value="'.$sysid_var.'">'.$sysid_var.'</option>';
		echo '<option value=""></option>';
		foreach ($ressys as $row) {
		echo("<option value='".$row['sysid']."'>".$row['sysid']."</option>");
		}
	?>
	</strong></select></td>
	  <td nowrap ><strong>
	<a href='empty.php?a=all'> Delete All</a>
	</strong></td>
	</div>
</tr> 
  <input type = "submit" value="Update" style="font-size: larger; background-color: green; padding: 10px 10px; font-size: 16px; display: inline-block;"> 
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
    <td><div ><font size="-1"><?php echo $rowno;?></A></font></div></td>
    <td><div ><font size="-1"><?php echo $row["year"];?></A></font></div></td>
    <td><div ><font size="-1"><?php echo $row["month"];?></A></font></div></td>
    <td><div ><font size="-1"><?php echo $row["day"]; ?></font></div></td>
    <td><div ><font size="-1"><?php echo $row["time"];?></font></div></td>
    <td><div ><font size="-1"><?php echo $row["hrs"];?>:<?php echo $row["mins"];?>:<?php echo $row["sec"]; ?></font></div></td>
    <td><div ><font size="-1"><?php echo $fi;?> <?php echo $extprint["name"];?> <?php echo $extprint["first"];?> <?php echo $row["callingparty"];?></font></div></td>
    <td><div ><font size="-1"><?php echo $row["calledno"];?></font></div></td>
    <td><div ><font size="-1"><?php echo $row["accountcode"];?></font></div></td>
    <td><div ><font size="-1"><?php echo $se;?> <?php echo $tresult["first"];?> <?php echo $tresult["name"];?> <?php echo $row["calledparty"];?></font></div></td>
    <td><div ><font size="-1"><?php echo $row["transferext"];?></font></div></td>
    <td><div ><font size="-1"><?php echo $row["callid"];?></A></font></div></td>
    <td><div ><font size="-1"><?php echo $row["callseq"];?></A></font></div></td>
    <td><div ><font size="-1"><?php echo $row["assocall"];?></A></font></div></td>
    <td><div ><font size="-1"><?php echo $row["sysid"];?></A></font></div></td>
    <td><div ><font size="-1"><a href='empty.php?a=data&amp;data=<?php echo $row["id"];?> '> Delete </a></font></div></td>
  </tr>
  <?php
}
?>
</table>
</body>
</html>