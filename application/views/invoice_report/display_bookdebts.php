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
				<th colspan="5" class="center_text">Ecopack Services Pvt Ltd</th>
                
			</tr>
			<tr>
				<th colspan="5" class="center_text">Book debts For the month of <?=date('F Y');?></th>
                
			</tr>
			<tr>
				<th>&nbsp;</th>
                <th>Date</th>
                <th>Invoice No.</th>
                <th>Billing Name</th>
                <th>Invoice Total</th>
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
					echo "<td>".$ctr."</td>";
					echo "<td>".date('d-m-Y',strtotime($row['invoice_date']))."</td>";
					echo "<td>".$row['invoice_no']."</td>";
					if(empty($row['consignee_billing_name']))
		                echo "<td>".$row['consignee_name']."</td>";
		            else
		                echo "<td>".$row['consignee_billing_name']."</td>";
					echo "<td>".$row['invoice_total']."</td>";
					echo "</tr>";
					$total+=$row['invoice_total'];
					$ctr++;
				}
			?>
			<tr>
				<td colspan="4">Total</td>
				<td><?=$total?></td>
				
			</tr>
		</tbody>
	</table>
	<iframe id="txtArea1" style="display:none"></iframe>
	<button id="btnExport" onclick="fnExcelReport();"> EXPORT </button>
	<button id="btn_print"> Print </button>

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
$("#btn_print").click(function(){
	window.print();
})
</script>