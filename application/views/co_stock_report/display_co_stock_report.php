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
				<th>Date</th>
				<?php
					$itemidary=array();
					$opstock=array();
					$tempstock=array();
					foreach ($form_data['item'] as $row) {
						echo "<th colspan='2'>".$row['item_name'].$row['item_id']."</th>";
						array_push($itemidary,$row['item_id']);
						$x="0";
						array_push($tempstock,"0");
						//array_push($tempstock,$x);

					}

				?>
				<th>LR No.</th>
				<th>Vehicle No.</th>
				<th>Driver No</th>
			</tr>
			<tr>
				<th></th>
				<?php
				foreach ($form_data['item'] as $row) {
						echo "<th>CO</th>";
						echo "<th>Warehouse</th>";
						
					}
					?>
					<th></th>
					<th></th>
					<th></th>
			</tr>
		</thead>
		
		<tbody>
			<td>Opening Stock</td>
				<?php
				foreach ($form_data['item'] as $row) {
						echo "<td>".$row['co_stock']."</td>";
						echo "<td>".$row['warehouse_stock']."</td>";
					}
					?>
					<td></td>
					<td></td>
					<td></td>
			<?php
			$prevdate="";
			$prevtype="";
			$consignment_no="";
			$vehicle_inward_no="";
			$prevqty="";
			$previtemid="";
				foreach ($form_data['inward'] as $row) {

						
					if(empty($prevdate))
					{
						$prevdate=$row['date'];
						$prevtype=$row['type'];
						$consignment_no=$row['consignment_no'];
						$vehicle_inward_no=$row['vehicle_inward_no'];
						$prevqty=$row['qty'];
						$previtemid=$row['item_id'];
					}

					/*if($consignment_no>='1432'){
						echo $row['consignment_no']."<br/>";
						echo $consignment_no;

						exit;
					}*/
					if($prevdate!=$row['date'] || $prevtype!=$row['type'] || $consignment_no!=$row['consignment_no'])
					{
						//tr bangeadate("d-m-Y",strtotime($row['consignment_date']));
						
						echo "<tr>";
						echo "<td>".date("d-m-Y",strtotime($prevdate)).$prevtype."</td>";
						for($i=0;$i<sizeof($tempstock);$i++)
						{
							if($prevtype<3)
							{
								echo "<td>-</td>";
								echo "<td>".$tempstock[$i]."</td>";
							}
							else
							{
								echo "<td>".$tempstock[$i]."</td>";
								echo "<td>-</td>";
							}
							//echo "<td>".$tempstock[$i]."</td>";

							$tempstock[$i]=0;
						}
						if($prevtype=='4')
						{
							echo "<td>".$consignment_no."</td>";
							//echo "<td>".$row['consignment_no']."</td>";
							echo "<td>".$vehicle_inward_no."</td>";
							echo "<td></td>";
						}
						else
						{
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
						}
						$prevdate=$row['date'];
						$prevtype=$row['type'];
						$consignment_no=$row['consignment_no'];
						$prevqty=$row['qty'];
						$previtemid=$row['item_id'];
						echo "</tr>";
					}
					else
					{
						//print_r($tempstock);
						//array may value jayega
						
						if(!empty($prevqty))
						{
							$pos=array_search($previtemid, $itemidary);
							$tempstock[$pos]=$prevqty;
							$prevqty="";
							$previtemid="";
						}
						
							$pos=array_search($row['item_id'], $itemidary);
							$tempstock[$pos]=$row['qty'];		
						
						
					}


					//$prevqty=$row['qty'];
					
				}
				echo "<tr>";
						echo "<td>".date("d-m-Y",strtotime($prevdate))."</td>";
						for($i=0;$i<sizeof($tempstock);$i++)
						{
							if($prevtype<3)
							{
								echo "<td>-</td>";
								echo "<td>".$tempstock[$i]."</td>";
							}
							else
							{
								echo "<td>".$tempstock[$i]."</td>";
								echo "<td>-</td>";
							}
							//echo "<td>".$tempstock[$i]."</td>";

							$tempstock[$i]=0;
						}
						if($prevtype=='4')
						{
							echo "<td>".$consignment_no."</td>";
							//echo "<td>".$row['consignment_no']."</td>";
							echo "<td>".$vehicle_inward_no."</td>";
							echo "<td></td>";
						}
						else
						{
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
						}
					echo "</tr>";	

			?>
		</tbody>
	</table>
	<table class="table table-striped table-border table-bordered">
		<thead>
			
			<tr>
				<th>Item Name</th>
				<?php
					$ctr=0;
					foreach ($warehouse as $row) {
						echo "<th>".$row['warehouse_name']."</th>";
						echo "<th>".$row['warehouse_name']." (InTransit)</th>";
						$ctr++;
					}

				?>
				<th>Co</th>
			</tr>
			<thead>

			<tbody>
				<?php

				foreach ($form_data['item'] as $row) {
						echo "<tr>";
						echo "<td>".$row['item_name']."</td>";
						for($i=0;$i<$ctr;$i++)
						{
							echo "<td>".$row['current_warehouse_stock'][$i]."</td>"; 
							echo "<td>".$row['intransit'][$i]."</td>"; 
						}

						echo "<td>".$row['current_co_stock']."</td>";
						echo "</tr>";
					}
					?>
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