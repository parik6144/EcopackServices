<?php
	// $this->load->view('report_header');
    $this->load->view('header');
    $this->load->view('left_sidebar');
    $this->load->view('topbar');
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
.center_text{ text-align: center; }
.td{ text-align: center; }
.th{ text-align: center; }
</style>

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2> Warehouse Idle Stock Report</h2>
        </div>
        <div class="col-lg-2"></div>
    </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="table-responsive">
	                <table class="table table-striped table-border table-bordered" id="headerTable">
                    <thead>
                       <tr role="row">
                        <th class="center_text">Sl. No</th>
                        <th class="center_text">Item Name</th>
                        <th class="center_text">Item Code</th>
                        <th class="center_text">Warehouse</th>
                        <th class="center_text">Stock</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ctr=1;
                        foreach($form_data as $row) { if($row['qty']>0){
                        echo "<tr>";
                        echo "<td class='center_text'>".$ctr."</td>";
                        echo "<td class='center_text'>".$row['item_name']."</td>";
                        echo "<td class='center_text'>".$row['item_code']."</td>";
                        $res = $this->db->select('warehouse_name,warehouse_id')->from('tbl_warehouse')->where('warehouse_id',$row['warehouse_id'])->get()->row();
                        // echo $this->db->last_query();
                        if($row['warehouse_id']=='0' || $row['warehouse_id']==''){  echo "<td class='center_text'>".$row['warehouse_id']."</td>"; }
                        if($row['warehouse_id']!='0'){  echo "<td class='center_text'>".$res->warehouse_name."</td>"; }
                        echo "<td class='center_text'>".$row['qty']."</td>";
                        echo "<tr/>";
                        $ctr++;
                        }} ?>
                    </tbody>
                   </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8"></div>
        <div class="col-lg-4">
            <div class="title-action">
                <a href="#" class="btn btn-primary" id="btnExport"><i class="fa fa-print"></i> Export Report </a>
            </div>
        </div>
    </div>
</div>

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