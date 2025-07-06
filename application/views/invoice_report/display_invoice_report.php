<?php
	$this->load->view('report_header');
?>
<?php
//$this->load->view('header');
//$this->load->view('left_sidebar');
//$this->load->view('topbar');
?>
<style type="text/css">
.center_text{
	text-align: center;
}
@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12"><br/>
            <div class="ibox">
                <div class="ibox-title">
                    <h2 style="display: inline-block; margin-right: 30px;">Ledger Report</h2>
                    <button class="btn btn-primary btn-lg" style="display: inline-block; margin-right: 20px; padding: 10px 30px;" onclick="fnExcelReport();">Export CSV</button>
                    <button class="btn btn-primary btn-lg" style="display: inline-block; padding: 10px 30px;" onclick="printpage();">Print</button>
                </div>

                <div class="ibox-content">
                    <table class="table table-striped table-border table-bordered" id="headerTable">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Invoice No.</th>
                            <th>Date</th>
                            <th>Billing Name</th>
                            <th>GST No</th>
                            <th>Taxable Value</th>
                            <th>GST Rate</th>
                            <th style="text-align: center;">Invoice GST Details</th>
                            <th>Total Tax</th>
                            <th>Round Off</th>
                            <th>Invoice Total</th>
                            <th>Invoice Type</th>
                            <th class="no-print">#</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $ctr=1;
                        $total=0;
                        $totaltax=0;
                        foreach ($form_data as $row) {
                            echo "<tr>";
                            echo "<td>".$ctr."</td>";
//                            echo "<td>".$row['invoice_no'].'--'.$row['invoice_id'].'--'.$row['invoice_type_id']."</td>";
                            echo "<td>".$row['invoice_no']."</td>";
                            echo "<td>".date('d-m-Y',strtotime($row['invoice_date']))."</td>";
                            if(empty($row['consignee_billing_name'])) echo "<td>".$row['consignee_name']."</td>";
                            else echo "<td>".$row['consignee_billing_name']."</td>";
                            echo "<td>".$row['gstin']."</td>";
                            $taxable=$row['invoice_total']-$row['total_tax'];
                            if($row['round_off']<0)
                            {
                                $taxable=$taxable-$row['round_off'];
                            }
                            else
                            {
                                $taxable=$taxable+$row['round_off'];
                            }
                            echo "<td>".$taxable."</td>";
                            echo "<td>".$row['gst_rate']."%</td>";
                            echo "<td>".$this->Mdl_invoice->getgstdetailsinvoicereport($row['invoice_id'], $row['invoice_type_id'],$row)."</td>";
                            echo "<td>".$row['total_tax']."</td>";
                            echo "<td>".$row['round_off']."</td>";
                            echo "<td>".$row['invoice_total']."</td>";
                            echo "<td>".$row['category_name']."</td>";
                            echo "<td class='no-print'><a href='".base_url('invoice/printinvoice/').encryptor("encrypt",$row['invoice_id'])."' class=''  target='_blank'><i class='fa fa-print'></i></a></td>";
                            echo "</tr>";
                            $total+=$row['invoice_total'];
                            $totaltax+=$row['total_tax'];
                            $ctr++;
                        }
                        ?>
                        <tr>
                            <td colspan="7">Total</td>
                            <td></td>
                            <td><?=$totaltax?></td>
                            <td></td>
                            <td><?=$total?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('footer'); ?>
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
function printpage()
{
	window.print();
}
</script>