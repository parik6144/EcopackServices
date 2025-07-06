<?php
	$this->load->view('report_header');
?>
	<table class="table table-stipped table-border" id="headerTable">
		<thead>
			<tr>
				<th>SL. No</th>
				<th>LR No.</th>
				<th>Starting Date</th>
				<?php
					if(isset($_POST['consignee_name']) && $_POST['consignee_name']=="14")
					{
						echo "<th>Qty</th>";
					}
				?>
				<?php
					if(isset($_POST['consignee_name']) && $_POST['consignee_name']=="6")
					{
						echo "<th>Nafeb/ H Frame</th>";
						echo "<th>Vehicle Capacity</th>";
					}
				?>
				<th>Vehicle No</th>
				<th>Mobile No</th>
				<?php
					for($i=1;$i<$form_data['count'];$i++)
					{
						echo "<th>Day ".$i."</th>";
					}
				?>
				<th>Current Location</th>
				<th>Delivered date</th>
				<th>Remarks</th>
				<th>Invoice Status</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$ctr=0;
				foreach ($form_data['data'] as $row) {
					$ctr++;
					?>
					<tr>
						<td><?=$ctr?></td>
						<td><?=$row['consignment_no']?></td>
						<td><?=date('d-m-Y',strtotime($row['consignment_date']))?></td>
						<?php
						$row1="";
							if(isset($_POST['consignee_name']) && $_POST['consignee_name']=="14")
							{
								$query=$this->db->select('sum(qty) as qty')
								->from('tbl_consignment_stock_item')
								->where('consignment_id',$row['consignment_no'])
								->get();
								$row1=$query->row();
								echo "<td>".$row1->qty."</td>";
							}
						?>
						<?php
							if(isset($_POST['consignee_name']) && $_POST['consignee_name']=="6")
							{
								
								
								 
									$query=$this->db->select('sum(qty) as qty')
									->from('tbl_consignment_stock_item')
									->where('consignment_id',$row['consignment_no'])
									->get();
									$row1=$query->row();
									if($row1->qty > 0)
									{
										echo "<td>Nafeb</td>";
										if($row['vehicle_type_id']=="12" || $row['vehicle_type_id']=="13")
										{
											echo "<td>16 MT</td>";
										}
										else
											echo "<td>7 MT</td>";
									}
									else
									{
										if($row['vehicle_type_id']=="12" || $row['vehicle_type_id']=="13")
										{
											echo "<td>HFrame</td>";
											echo "<td>16 MT</td>";
										}
										else{
											echo "<td>HFrame</td>";
											echo "<td>7 MT</td>";
										}
										
									}
								
							}
						?>
						<td><?=$row['vehicle_inward_no']?></td>
						<td><?=$row['mobile_no']?></td>
						
						
						<?php
						$k=0;
						for($j=0;$j<(sizeof($row['follow_up'])-1);$j++) {
							//var_dump($row1);
							?>
							<td><?=$row['follow_up'][$j]['vehicle_location']?></td>
							<?php
							$k++;
						}
						for($i=$j;$j<($form_data['count']-1);$j++)
						{
							echo "<td>-</td>";
						}
						?>

						<td><?php
						$followup_date="";
						if(isset($row['follow_up'][$k]['delevery_status']))
						{
							if($row['follow_up'][$k]['delevery_status']=="1")
							{
								echo "delivered";
								$followup_date=$row['follow_up'][$k]['followup_date'];
							}
						else
							echo $row['follow_up'][$k]['vehicle_location'];
						}
						else
						{
							echo "NA";
						}
						
						?></td>
						<td>
							<?php 
								if(!empty($followup_date))
									echo date('d-m-Y',strtotime($followup_date));

							?>
						</td>
						<td><?php
						if(isset($row['follow_up'][$k]['remarks']))
							echo $row['follow_up'][$k]['remarks'];
						?></td>
						<td><?php
						if($row['invoice_status']==1)
							echo "Cleared";
						else
							echo "Pending";
						?></td>
					</tr>
					<?php
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