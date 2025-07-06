<?php
	$this->load->view('report_header');
	
?>
<style type="text/css">
.center_text{
	text-align: center;
}
</style>

	<table class="table table-striped table-border table-bordered" id="headerTable">
		<thead>
			<tr>
				<th>Consignment No</th>
				<th>Follow up Date</th>
				<th>Vehicle No</th>
				<th>Diver Name</th>
				<th>Mobile No</th>
				<th>Location</th>
				<th>Status</th>
			</tr>
		</thead>
		
		<tbody>
			<?php
				$ctr=1;
				$total=0;
				//var_dump($form_data);
				//exit;
				foreach ($form_data as $row) {
					echo "<tr>";
					echo "<td>".$row['consignment_no']."</td>";
					echo "<td>".date("d-m-Y",strtotime($row['consignment_date']))."</td>";
					echo "<td>".$row['vehicle_inward_no']."</td>";
					echo "<td>".$row['driver_name']."</td>";
					echo "<td>".$row['mobile_no']."</td>";
					echo "<td>".$row['vehicle_location']."</td>";
					
					if($row['delevery_status']=="0")
						echo "<td>Pending</td>";
					else
						echo"<td>Delivered</td>";
					echo "</tr>";
				}
			?>
			
		</tbody>
	</table>
	<iframe id="txtArea1" style="display:none"></iframe>
	<button id="btnExport" onclick="fnExcelReport();"> EXPORT </button>

<?php
	$this->load->view('footer');
?>
<script>
function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('headerTable'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}
</script>