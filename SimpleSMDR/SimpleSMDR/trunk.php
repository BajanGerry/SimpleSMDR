<?php
include "config.php";
top();
$sth = $con->prepare("SELECT * FROM trunks");
$sth->execute();
$result = $sth->fetchAll();
?>
<html>
<head>
</head>
<html>
<body>
<table border="1" id="UserTable">
  <tr>
    <td nowrap><div align="center"> <font size="-1"><strong>Trunk# <a href='trunkadd.php'> New</a></strong></font></div></td>
    <td nowrap><div align="center"> <font size="-1"><strong>Name</strong></font></div></td>
  </tr>
  <?php
 foreach ($result as $row) {
$rowno += 1;
?>
  <tr>
    <td><div align="center"><font size="-1"><a href='trunked.php?a=<?php echo $row["trunk"];?> '><?php echo $row["trunk"];?></a>
        <a href='empty.php?a=trunk&amp;trunk=<?php echo $row["trunk"];?> '> - Del</a></font></div></td></font></div></td>
    <td><div align="center"><font size="-1"><?php echo $row["name"];?></A></font></div></td>
  </tr>
  <?php
  }
?>
</table>

</br>

<a id="dlink"  style="display:none;"></a>
<input type="button" onclick="tableToExcel('UserTable', 'SimpleSMDR User Table', 'usertable.xls')" value="Export to Excel">
<script type="text/javascript">
var tableToExcel = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
        , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
        return function (table, name, filename) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }

            document.getElementById("dlink").href = uri + base64(format(template, ctx));
            document.getElementById("dlink").download = filename;
            document.getElementById("dlink").click();

        }
    })()
</script>
</br>
</br>

</body>
</html>
