<?php
	$this->load->view('report_header');
?>
	<table id="headerTable" border="1" class="table table-stripped">
		<thead>
			<tr>
				<th>Collection Date</th>
				<th>Collection Qty</th>
				<th>Dispatch date</th>
				<th>LR No</th>
				<th>Dispatch Qty</th>
				<th>Vehicle No</th>
				<th>Driver's Mobile No</th>
				<th>Current Location</th>
				<th>Delivered Date</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$arysize=(sizeof($form_data))-1;
				$j=1;
				for($i=0;$i<$arysize;$i++)
				{
					echo "<tr>";
					if($form_data[$i]['type']=="1")
					{
						echo "<td></td>";
						echo "<td></td>";
						echo "<td>".$form_data[$i]['date']."</td>";
						echo "<td>".$form_data[$i]['consignment_no']."</td>";
						echo "<td>".$form_data[$i]['qty']."</td>";
						echo "<td>".$form_data[$i]['vehicle_inward_no']."</td>";
						echo "<td>".$form_data[$i]['mobile_no']."</td>";
						echo "<td></td>";
						echo "<td></td>";

					}
					else
					{
						if($form_data[$i]['type']=="0")
						{
							echo "<td>".$form_data[$i]['date']."</td>";
							echo "<td>".$form_data[$i]['qty']."</td>";
						}
						if($form_data[$j]['type']=="1" && $form_data[$i]['date']==$form_data[$j]['date'])
						{
							echo "<td>".$form_data[$j]['date']."</td>";
							echo "<td>".$form_data[$j]['consignment_no']."</td>";
							echo "<td>".$form_data[$j]['qty']."</td>";
							echo "<td>".$form_data[$j]['vehicle_inward_no']."</td>";
							echo "<td>".$form_data[$j]['mobile_no']."</td>";
							echo "<td></td>";
							echo "<td></td>";
							$i=$j;
							$j++;
						}
						else
						{
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
						}
					}
					echo "</tr>";
					$j++;
				}
			?>
			
		</tbody>
	</table>
	<iframe id="txtArea1" style="display:none"></iframe>
	<a href="" class="btn btn-success" id="btnExport">EXPORT </a>

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
    var todaysDate = "Followup_Report";
    var blobURL = tableToExcel('headerTable', 'test_table');
    $(this).attr('download',todaysDate+'.xls')
    $(this).attr('href',blobURL);
});
</script>