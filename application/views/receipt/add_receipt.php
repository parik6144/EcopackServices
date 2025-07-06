<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 14:52
 */

$this->load->view('header');
$this->load->view('left_sidebar');
$this->load->view('topbar');
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Invoice</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Invoice Records</h5>
            <div class="ibox-tools">
                <a href="<?= base_url('receipt')?>"><button class="btn btn-info btn-circle btn-outline" id="btn_addrecord1" type="button"><i class="fa fa-angle-double-left"></i>
                </button></a>
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                
            </div>
        </div>
        <div class="ibox-content">
            <input type='hidden' name='billing_id' id="billing_id" value='<?=$billing_id?>'>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" id="example">
                <thead>
                <tr role="row">
                    <th>&nbsp;</th>
                    <th>Invoice No.</th>
                    <th>Date</th>
                    <th>Billing Name</th>
                    <th>Invoice Total</th>
                    <th>Pending Amount</th>
                    <th>Receipt Date</th>
                    <th>Amount</th>
                    <th>TDS/Pending</th>
                    <th>Status</th>
                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        $ctr=1;
                        $total=0;
                        $outstanding=0;
                        //var_dump($form_data);
                        //exit;
                        $tempname="";
                        foreach ($form_data as $row) {
                            echo "<tr>";
                            echo "<td>".$ctr."</td>";
                            echo "<td>".$row['invoice_no']."</td>";
                            echo "<td>".date('d-m-Y',strtotime($row['invoice_date']))."</td>";
                            if(empty($row['consignee_billing_name'])){
                                $tempname=$row['consignee_name'];
                                echo "<td>".$row['consignee_name']."</td>";
                            }
                                
                            else{
                                $tempname=$row['consignee_billing_name'];
                                echo "<td>".$row['consignee_billing_name']."</td>";
                            }
                                
                            echo "<td class='invoice_total'>".$row['invoice_total']."</td>";
                            echo "<td class='invoice_total'>".($row['invoice_total']-$row['amount'])."</td>";
                            echo "<td><input type='date' class='form-control date'></td>";
                            echo "<td><input type='number' class='form-control amount'></td>";
                            echo "<td class='tds'></td>";
                            echo "<td><select class='form-control status'>
                                <option value=''>Select Status</option>
                                <option value='0'>Pending</option>
                                <option value='1'>Clear</option>
                            </td>";
                            echo "<td><button refid='".encryptor("encrypt",$row['invoice_id'])."' class='btn btn-sm btn-success btn_save' title='save'><i class='fa fa-save'></i></button></td>";
                            echo "</tr>";
                            $total+=$row['invoice_total'];
                            $outstanding+=($row['invoice_total']-$row['amount']);
                            $ctr++;
                        }
                    ?>
                    <tr>
                        <td colspan='5'>Outstanding</td>
                        <td><?=$outstanding?></td>
                        <td colspan='5'></td>
                    </tr>
                </tbody>
            </table>
            <iframe id="txtArea1" style="display:none"></iframe>
    <a id="btnExport"  class="btn btn-success" id="btnExport"> EXPORT </a>
            <table style="display:none;" id="headerTable">
                <thead>
                    <tr>
                        <th>Sl. No</th>
                    <th>Invoice No.</th>
                    <th>Date</th>
                    <th>Billing Name</th>
                    <th>Invoice Total</th>
                    <th>Pending Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $ctr=1;
                        $total=0;
                        $outstanding=0;
                        //var_dump($form_data);
                        //exit;
                        foreach ($form_data as $row) {
                            echo "<tr>";
                            echo "<td>".$ctr."</td>";
                            echo "<td>".$row['invoice_no']."</td>";
                            echo "<td>".date('d-m-Y',strtotime($row['invoice_date']))."</td>";
                            if(empty($row['consignee_billing_name']))
                                echo "<td>".$row['consignee_name']."</td>";
                            else
                                echo "<td>".$row['consignee_billing_name']."</td>";
                            echo "<td class='invoice_total'>".$row['invoice_total']."</td>";
                            echo "<td class='invoice_total'>".($row['invoice_total']-$row['amount'])."</td>";
                            echo "</tr>";
                            $total+=$row['invoice_total'];
                            $outstanding+=($row['invoice_total']-$row['amount']);
                            $ctr++;
                        }
                    ?>
                    <tr>
                        <td colspan='5'>Outstanding</td>
                        <td><?=$outstanding?></td>
                        
                    </tr>
                </tbody>
            </table>

            </div>
        </div>
    </div>
</div>
    </div>
</div>
<?php
$this->load->view('footer');
?>
<script src="<?php echo base_url() ?>assets/js/plugins/dataTables/datatables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>

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
    var todaysDate = "OutStanding Of <?=$tempname?>";
    var blobURL = tableToExcel('headerTable', 'OutStanding');
    $(this).attr('download',todaysDate+'.xls')
    $(this).attr('href',blobURL);
});
    $(".amount").blur(function(){
        var amount=parseFloat($(this).val());
        if(!isNaN(amount))
        {
            var invoicetotal=$(this).closest("tr").find(".invoice_total:last").html();
            var tds=invoicetotal-amount;
            $(this).closest("tr").find(".tds").html(tds);
        }
    });
    $(document).on("click",".btn_save",function (e) {
        e.preventDefault();
        var ref=$(this);
        var amount=$(this).closest("tr").find(".amount").val();
        var status=$(this).closest("tr").find(".status").val();
        var tds=$(this).closest("tr").find(".tds").html();
        var receiptdate=$(this).closest("tr").find(".date").val();
        var billing_id=$("#billing_id").val();
        if(amount=="")
            swal("invaid amount","Please Enter a amount","warning");
        else if(status=="")
            swal("","Please select a status","warning");
        else
        {
            var invoice_id=$(this).attr('refid');
            swal({
                title: "Are you sure?",
                text: "You want to accept this Receipt!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-success',
                cancelButtonClass: 'btn-danger',
                confirmButtonText: 'Yes, Confirm!',
                cancelButtonText: 'No, cancel!',
                closeOnConfirm: false
                //closeOnCancel: false
            },
            function(){

                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('receipt/add')?>',
                    cache: false,
                    data: {invoice_id: invoice_id,amount:amount,status:status,'date':receiptdate,billing_id:billing_id,tds:tds},
                    success: function (data) {
                        if(data=="true")
                        {
                            //alert(status);
                            if(status=="1")
                            {
                                ref.closest("tr").hide("slow",function(){ ref.closest("tr").remove(); });
                            }
                            else
                            {

                            }
                            swal("Confirmed!", "Record Moved to Ledger!", "success");
                        }
                    },
                    error: function (data) {
                    },
                    timeout: 5000,
                    error: function(jqXHR, textStatus, errorThrown) {
                        swal("","Please check your internet connection.","error");

                    },
                    beforeSend: function() {
                        $('#loader').show();
                    },
                    complete: function(){
                        $('#loader').hide();
                    }
                });
            });
        }
        
    });
</script>
