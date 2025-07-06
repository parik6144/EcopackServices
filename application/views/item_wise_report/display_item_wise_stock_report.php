<?php
	$this->load->view('report_header');
	function createtd($num)
	{
		$str="";
		for($i=0;$i<$num;$i++)
		{
			$str.="<td>0</td>";
		}
		return $str;
	}
?>
<style type="text/css">
.center_text{
	text-align: center;
}
</style>

	<table class="table table-striped table-border table-bordered" id="headerTable">
		<thead>
			
			<tr>
				<th>Sl. No</th>
				<th>Consignee Name</th>
				<?php
				foreach ($warehouse as $row) {
					# code...
					echo "<th>".$row['warehouse_name']."</th>";
				}
				?>
				<th>Co Stock</th>
			</tr>
			
		</thead>
			<?php
			$ctr=1;
			foreach ($form_data as $row) {
				# code...
				echo "<tr>";
				echo "<td>".$ctr."</td>";
				echo "<td>".$row['consignee_name']."</td>";
				for($i=0;$i<sizeof($row['warehouse_stock']);$i++)
				{
					echo "<td>".$row['warehouse_stock'][$i]."</td>";
				}
				echo "<td>". $row['current_co_stock']."</td>";
				echo "</tr>";
				$ctr++;
			}
			?>
		
		<tbody>
		</tbody>
	</table>
	
	
	<iframe id="txtArea1" style="display:none"></iframe>
	<a id="btnExport"  class="btn btn-success" id="btnExport"> EXPORT </a>

<?php
	$this->load->view('footer');
?>
<script>
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    var blob = new Blob([format(template, ctx)]);
  var blobURL = window.URL.createObjectURL(blob);
    return blobURL;

  }
})()

$("#btnExport").click(function () {
    var todaysDate = "Stock_Report";
    var blobURL = tableToExcel('headerTable', 'test_table');
    $(this).attr('download',todaysDate+'.xls')
    $(this).attr('href',blobURL);
});

</script>