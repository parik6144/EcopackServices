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
				<th colspan="<?=sizeof($form_data['item'])?>" class="center_text">Opening Stock</th>
				<th colspan="<?=sizeof($form_data['item'])?>" class="center_text">Inward Stock</th>
				<th colspan="<?=sizeof($form_data['item'])?>" class="center_text">Outward Stock</th>
				<th colspan="">LR No.</th>
				<th colspan="">Invoice No</th>
				<th colspan="">Vehicle No.</th>
				<th colspan="">Driver No</th>
				<th colspan="">Current Location</th>
			</tr>
			<tr>
				<td></td>
				<?php
					$itemidary=array();
					$opstock=array();
					$flag=0;
					$tempth=0;
					
					foreach ($form_data['item'] as $row) {
						if($flag==0){
							$itemnameary=explode("(", $row['item_name']);
							echo "<th colspan='2'>".$row['item_name']."</th>";
							$tempth++;
						}
						$flag++;
						if($flag>1)
							$flag=0;

						
						
						
						array_push($itemidary, $row['item_id']);
						array_push($opstock, $row['stock']);
						
					}
					$flag=0;
					foreach ($form_data['item'] as $row) {
						
							if($flag==0){
							$itemnameary=explode("(", $row['item_name']);
							echo "<th colspan='2'>".$row['item_name']."</th>";
							$tempth++;
						}
						$flag++;
						if($flag>1)
							$flag=0;
							
						
						
					}
					$flag=0;
					foreach ($form_data['item'] as $row) {
						
							if($flag==0){
							$itemnameary=explode("(", $row['item_name']);
							echo "<th colspan='2'>".$row['item_name']."</th>";
							$tempth++;
						}
						$flag++;
						if($flag>1)
							$flag=0;
							
						
						
					}
				?>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
			<tr>
				<th></th>
				<?php
				for ($i=0; $i <$tempth; $i++) { 
					?>
					<th>Box</th>
					<th>Qty</th>
					<?php
				}
				?>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				
			</tr>
		</thead>
		<?php
			$tempdate="";
			$incurindex=0;
			$inlastpos=0;
			$outlastpos=0;
			$outcurindex=0;
			$date="";
			$dateary=array();
			$consignmentary=array();
			$vehiclenoary=array();
			$mobilenoary=array();
			$d_c_noary=array();
			$inary=[];
			$itemin=array();
			$itemout=array();
			$previouscno="";
			$tempin=array();
			$tempout=array();
			$prevdate="";
			$ctr=0;
			for($i=0;$i<sizeof($itemidary);$i++)
			{
				
				$tempin[$i]="0";
				$tempout[$i]="0";
			}
			foreach ($form_data['inward'] as $row) {

				if($date!=$row['date'])
				{
					if(isset($tempin) & $date!="")
					{
						array_push($itemin, $tempin);
						array_push($itemout, $tempout);
					}
					$tempin=array();
					$tempout=array();
					for($i=0;$i<sizeof($itemidary);$i++)
					{
						
						$tempin[$i]="0";
						$tempout[$i]="0";
					}
					$previouscno=$row['consignment_no'];
				}
				elseif (!empty($row['consignment_no'])&& $row['consignment_no']!=$previouscno) {
					if(isset($tempin))
					{

						array_push($itemin, $tempin);
						array_push($itemout, $tempout);
					}
					$tempin=array();
					$tempout=array();
					for($i=0;$i<sizeof($itemidary);$i++)
					{
						
						$tempin[$i]="0";
						$tempout[$i]="0";
					}
					$previouscno=$row['consignment_no'];
				}
				array_push($dateary,$row['date']);
				if($row['type']=="1")
				{
					
					$pos=array_search($row['item_id'],$itemidary);
					$tempout[$pos]=$row['qty'];
					
				}
				if($row['type']=="0")
				{
					$pos=array_search($row['item_id'],$itemidary);
					$tempin[$pos]=$row['qty'];
					
				}
				array_push($consignmentary,$row['consignment_no']);
				array_push($vehiclenoary,$row['vehicle_inward_no']);
				array_push($mobilenoary,$row['mobile_no']);
				array_push($d_c_noary,$row['d_c_no']);
				$date=$row['date'];
				/*echo "tempin.<pre>";
				print_r($tempin);

				echo "</pre>itemin<pre>";
				print_r($itemin);
				echo "</pre>";

				echo "<br/>";
				echo "<br/>";*/
				
			}
			if(isset($tempin))
			{
				array_push($itemin, $tempin);
				array_push($itemout, $tempout);
			}
			
			?>
		<tbody>
			<?php
			$prevdate="";
			$prevlrno="";
			$ctr=0;
			
			
			for($i=0;$i<sizeof($dateary);$i++)
			{
				if($prevdate!=$dateary[$i])
				{
					echo "<tr>";
					echo "<td>".date("d-m-Y",strtotime($dateary[$i]))."</td>";
					for($j=0;$j<sizeof($opstock);$j++)
					{
						echo "<td>".$opstock[$j]."</td>";
					}
					if(isset($itemin[$ctr]))
					{
						for($j=0;$j<sizeof($itemin[$ctr]);$j++)
						{
							echo "<td>".$itemin[$ctr][$j]."</td>";
							$opstock[$j]=$opstock[$j]+$itemin[$ctr][$j];
						}
					}
					
					for($j=0;$j<sizeof($itemout[$ctr]);$j++)
					{
						echo "<td>".$itemout[$ctr][$j]."</td>";
						$opstock[$j]=$opstock[$j]-$itemout[$ctr][$j];
					}
					echo "<td>".$consignmentary[$i]."</td>";
					echo "<td>".$d_c_noary[$i]."</td>";
					echo "<td>".$vehiclenoary[$i]."</td>";
					echo "<td>".$mobilenoary[$i]."</td>";
					if(!empty($consignmentary[$i]))
					{
						$result=$this->db->select('vehicle_location,delevery_status')
				        ->from('tbl_vehicle_followup')
				        ->where('consignment_id',$consignmentary[$i])
				        ->order_by('followup_id','desc')
				        ->limit('1')
				        ->get();
				        $data=$result->row();
				        if(isset($data->delevery_status))
				        {
				        	if($data->delevery_status=="1")
					        	echo "<td>Deliverd</td>";	
					        else
					        {
					        	echo "<td>".$data->vehicle_location."</td>";
					        }
				        }
				        else
						{
							echo "<td>NA</td>";
						}
				        
					}
					else
					{
						echo "<td>NA</td>";
					}
					echo "</tr>";
					//echo "<td>".print_r($this->Mdl_followup->getcurrentlocation($consignmentary[$i]))	."</td>";
					echo "</tr>";
					$prevdate=$dateary[$i];
					$prevlrno=$consignmentary[$i];
					$ctr++;
				}
				else if($prevlrno!=$consignmentary[$i] && !empty($consignmentary[$i]))
				{
					echo "<tr>";
					echo "<td>".date("d-m-Y",strtotime($dateary[$i]))."</td>";
					for($j=0;$j<sizeof($opstock);$j++)
					{
						echo "<td>".$opstock[$j]."</td>";
					}
					if(isset($itemin[$ctr]))
					{
						for($j=0;$j<sizeof($itemin[$ctr]);$j++)
						{
							echo "<td>".$itemin[$ctr][$j]."</td>";
							$opstock[$j]=$opstock[$j]+$itemin[$ctr][$j];
						}
					}
					for($j=0;$j<sizeof($itemout[$ctr]);$j++)
					{
						echo "<td>".$itemout[$ctr][$j]."</td>";
						$opstock[$j]=$opstock[$j]-$itemout[$ctr][$j];
					}
					echo "<td>".$consignmentary[$i]."</td>";
					echo "<td>".$d_c_noary[$i]."</td>";
					echo "<td>".$vehiclenoary[$i]."</td>";
					echo "<td>".$mobilenoary[$i]."</td>";
					if(!empty($consignmentary[$i]))
					{
						$result=$this->db->select('vehicle_location,delevery_status')
				        ->from('tbl_vehicle_followup')
				        ->where('consignment_id',$consignmentary[$i])
				        ->order_by('followup_id','desc')
				        ->limit('1')
				        ->get();
				        $data=$result->row();
				        if(isset($data->delevery_status))
				        {
				        	if($data->delevery_status=="1")
					        	echo "<td>Deliverd</td>";	
					        else
					        {
					        	echo "<td>".$data->vehicle_location."</td>";
					        }
				        }
				        else
						{
							echo "<td>NA</td>";
						}
				        
					}
					else
					{
						echo "<td>NA</td>";
					}
					echo "</tr>";
					//$prevdate=$dateary[$i];
					$prevlrno=$consignmentary[$i];
					$ctr++;
				}
			}
			?>
			<tr>
				<td>Closing</td>
				<?php
				for($j=0;$j<sizeof($opstock);$j++)
					{
						echo "<td>".$opstock[$j]."</td>";
					}
				?>
			</tr>
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