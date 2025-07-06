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
$m=$_GET['m'];
$y=$_GET['y'];

class totalexpense extends CI_Model
{
	function getExpensseByHead($expense_head_id,$month,$year="2019")
	{
		/*18=transportation
		16=Purchase fa
		13=Salary*/
		$query=$this->db->select('sum(amount) as amount') 
		->from('tbl_payment_booking')
		->where('expense_head_id',$expense_head_id)
		->where('month(payment_date)',$month)
		->where('year(payment_date)',$year)
		->where('is_confirm','2')
		->where('is_deleted','0')
		->get();
		$record=$query->row();
		
		return $record->amount;
	}

	function getTransportation($month,$year="2019")
	{
		$query=$this->db->select('sum(amount) as total')
		->from('tbl_payment_advance')
		->where('month(created_datetime)',$month)
		->where('year(created_datetime)',$year)
		->get();
		$advance=$query->row();
		$query=$this->db->select('sum(amount) as total')
		->from('tbl_payment_due')
		->where('month(created_datetime)',$month)
		->where('year(created_datetime)',$year)
		->get();
		$due=$query->row();
		return $advance->total+$due->total;
	}

	function getTotalpurchase($expense_head_id,$month,$year="2019")
	{
		/*18=transportation
		16=Purchase fa
		13=Salary*/
		$query=$this->db->select('sum(amount) as amount') 
		->from('tbl_payment_booking')
		->where('expense_head_id',$expense_head_id)
		->where('month(booking_date)',$month)
		->where('year(booking_date)',$year)
		->where('is_deleted','0')
		->get();
		$record=$query->row();
		return $record->amount;
	}
	
	function OtherExpense($month,$year="2019")
	{
		$ignores=array("18","16","13","19","24","7","23","25","15");
		$query=$this->db->select('sum(amount) as amount') 
		->from('tbl_payment_booking')
		->where('month(payment_date)',$month)
		->where('year(payment_date)',$year)
		->where('is_confirm','2')
		->where('is_deleted','0')
		->where_not_in('expense_head_id',$ignores)
		->get();
		$record=$query->row();
		return $record->amount;
	}


	function totalBookdebts()
	{
        $m=$_GET['m'];
        $y=$_GET['y'];
        if($m ==''){ $m = date('m'); }
        if($y ==''){ $y=date('Y'); }
        $date=$y.'-'.$m.'-31';
		$this->db->select('sum(total_tax) as totalTax, sum(invoice_total) as InvoiceTotal'); 
        $this->db->from('tbl_invoice');
        $this->db->where('invoice_status','0')
        ->where('tbl_invoice.invoice_date <=',$date);
        $query=$this->db->get();
        $response=$query->row();
        //echo $this->db->last_query();
        return $response;
	}

	function getLoan()
	{
        $m=$_GET['m'];
        $y=$_GET['y'];
        if($m ==''){ $m = date('m'); }
        if($y ==''){ $y=date('Y'); }
        $date=$y.'-'.$m.'-31';
		$sql=$this->db->select('sum(loan_amount) as total_loan')
		->from('tbl_loan')
		->where('is_deleted','0')
        ->where('tbl_loan.loan_date <=',$date)
		->get();
		$data=$sql->row();
        //echo $this->db->last_query();
		return $data->total_loan;
	}

	function GetMonthlyInvoice($month,$year)
	{
		$query=$this->db->select('sum(invoice_total) as invoice_total,sum(total_tax) as total_tax')
		->from('tbl_invoice')
		->where('month(invoice_date)',$month)
		->where('year(invoice_date)',$year)
		->get();
		$record=$query->row();
		return $record;
	}
}
$obj= new totalexpense();
?>
<div class="wrapper wrapper-content">
	<form>
	<div class="row">
		<div class="col-sm-7">
			
		</div>
		
		<div class="col-sm-2 pull-right">
			<select class="vehicle_inward_id form-control"  name="m" required="required">
                <option value=''>--Select Month--</option>
                <option value='01' <?php if(isset($_GET['m']) && $_GET['m']=="01") echo "selected";?>>Janaury</option>
                <option value='02' <?php if(isset($_GET['m']) && $_GET['m']=="02") echo "selected";?>>February</option>
                <option value='03' <?php if(isset($_GET['m']) && $_GET['m']=="03") echo "selected";?>>March</option>
                <option value='04' <?php if(isset($_GET['m']) && $_GET['m']=="04") echo "selected";?>>April</option>
                <option value='05' <?php if(isset($_GET['m']) && $_GET['m']=="05") echo "selected";?>>May</option>
                <option value='06' <?php if(isset($_GET['m']) && $_GET['m']=="06") echo "selected";?>>June</option>
                <option value='07' <?php if(isset($_GET['m']) && $_GET['m']=="07") echo "selected";?>>July</option>
                <option value='08' <?php if(isset($_GET['m']) && $_GET['m']=="08") echo "selected";?>>August</option>
                <option value='09' <?php if(isset($_GET['m']) && $_GET['m']=="09") echo "selected";?>>September</option>
                <option value='10' <?php if(isset($_GET['m']) && $_GET['m']=="10") echo "selected";?>>October</option>
                <option value='11' <?php if(isset($_GET['m']) && $_GET['m']=="11") echo "selected";?>>November</option>
                <option value='12' <?php if((isset($_GET['m'])) && ($_GET['m']=="12")) echo "selected";?>>December</option>
            </select>
		</div>
		<div class="col-sm-2 pull-right">
			<!--<select class="form-control" name="y">-->
			<!--	<option value="2018"  <?php if(isset($_GET['y']) && $_GET['y']=="2018") echo "selected";?>>2018</option>-->
			<!--	<option value="2019"  <?php if(isset($_GET['y']) && $_GET['y']=="2019") echo "selected";?>>2019</option>-->
			<!--	<option value="2020"  <?php if(isset($_GET['y']) && $_GET['y']=="2020") echo "selected";?>>2020</option>-->
			<!--	<option value="2021"  <?php if(isset($_GET['y']) && $_GET['y']=="2021") echo "selected";?>>2021</option>-->
			<!--	<option value="2022"  <?php if(isset($_GET['y']) && $_GET['y']=="2022") echo "selected";?>>2022</option>-->
			<!--	<option value="2023"  <?php if(isset($_GET['y']) && $_GET['y']=="2023") echo "selected";?>>2023</option>-->
			<!--</select>-->
			<select class="form-control" name="y">
                <?php
                // Get the current year
                $currentYear = date("Y");
            
                // Loop through the years starting from 2018 to the current year
                for ($year = 2018; $year <= $currentYear; $year++) {
                    // Check if the current year is selected in the query parameters
                    $selected = (isset($_GET['y']) && $_GET['y'] == $year) ? "selected" : "";
            
                    // Output the option tag with the value and selected attribute if applicable
                    echo "<option value=\"$year\" $selected>$year</option>";
                }
                ?>
            </select>

		</div>
		<div class="col-sm-1 pull-right">
			<button type="submit" class="btn btn-success">GET</button>
		</div>

	</div>
</form>

<div class="row">
	    <div class="col-lg-3">
	        <div class="ibox cust-card float-e-margins">
	            <div class="ibox-title">
	                <span class="label label-success pull-right">Month</span>
	                <h5>Transportation</h5>
	            </div>
	            <div class="ibox-content">
	                <h1 class="no-margins">
	                	<?php
	                	$booking_transport=$obj->getExpensseByHead('18',$m,$y);
	                	$totaltrasnport=$obj->getTransportation($m,$y);
	                	echo round($booking_transport+$totaltrasnport);
	                	?>
	                </h1>
	            </div>
	        </div>
	    </div>
	    <div class="col-lg-3">
	        <div class="ibox cust-card float-e-margins">
	            <div class="ibox-title">
	                <span class="label label-info pull-right">Month</span>
	                <h5>Purchase</h5>
	            </div>
	            <div class="ibox-content">
	                <h1 class="no-margins">
	                	<?php
	                	echo $obj->getTotalpurchase('16',$m,$y);
	                	?>
	                </h1>
	                
	                <small>
	                	<?php
	                	echo "payment :". $obj->getExpensseByHead('16',$m,$y);
	                	?>
	                </small>
	            </div>
	        </div>
	    </div>
	    
	    <div class="col-lg-3">
	        <div class="ibox cust-card float-e-margins">
	            <div class="ibox-title">
	                <span class="label label-primary pull-right">Month</span>
	                <h5>Salary</h5>
	            </div>
	            <div class="ibox-content">
	                <h1 class="no-margins">
	                	<?php
	                	$a= $obj->getExpensseByHead('13',$m,$y);
	                	$b= $obj->getExpensseByHead('25',$m,$y);
	                	echo $a+$b;
	                	?>
	                </h1>
	                
	                <small></small>
	            </div>
	        </div>
	    </div>
		<div class="col-lg-3">
	        <div class="ibox cust-card float-e-margins">
	            <div class="ibox-title">
	                <span class="label label-info pull-right">Month</span>
	                <h5>Travelling &amp; Diesel</h5>
	            </div>
	            <div class="ibox-content">
	                <h1 class="no-margins">
	                	<?php
	                	$a=$obj->getExpensseByHead('19',$m,$y);
	                	$b=$obj->getExpensseByHead('24',$m,$y);
	                	$c=$obj->getExpensseByHead('7',$m,$y);
	                	echo $a+$b+$c;
	                	?>
	                </h1>
	                
	                <small>
	                	
	                </small>
	            </div>
	        </div>
	    </div>
	    
	</div>
<div class="row">
	    <div class="col-lg-3">
	        <div class="ibox cust-card float-e-margins">
	            <div class="ibox-title">
	                <span class="label label-success pull-right">Month</span>
	                <h5>GST</h5>
	            </div>
	            <div class="ibox-content">
	                <h1 class="no-margins">
	                	<?php
	                	$booking=$obj->getExpensseByHead('23',$m,$y);
	                	
	                	echo $booking;
	                	?>
	                </h1>
	            </div>
	        </div>
	    </div>
	    <div class="col-lg-3">
	        <div class="ibox cust-card float-e-margins">
	            <div class="ibox-title">
	                <span class="label label-success pull-right">Month</span>
	                <h5>Interest on Loan</h5>
	            </div>
	            <div class="ibox-content">
	                <h1 class="no-margins">
	                	<?php
	                	$booking=$obj->getExpensseByHead('15',$m,$y);
	                	
	                	echo $booking;
	                	?>
	                </h1>
	            </div>
	        </div>
	    </div>
	    
	    
	    <div class="col-lg-3">
	        <div class="ibox cust-card float-e-margins">
	            <div class="ibox-title">
	                <span class="label label-primary pull-right">Month</span>
	                <h5>Other Expense</h5>
	            </div>
	            <div class="ibox-content">
	                <h1 class="no-margins">
	                	<?php
	                	echo $obj->OtherExpense($m,$y);
	                	?>
	                </h1>
	                
	                <small></small>
	            </div>
	        </div>
	    </div>
	    <div class="col-lg-3">
	        <div class="ibox cust-card float-e-margins">
	            <div class="ibox-title">
	                <span class="label label-primary pull-right">Month</span>
	                <h5>Invoice</h5>
	            </div>
	            <div class="ibox-content">
	                <h1 class="no-margins">
	                	<?php
	                	$row= $obj->GetMonthlyInvoice($m,$y);
	                	echo round($row->invoice_total, 0);
	                	?>
	                </h1>
	                
	                <small>Tax: <?= $row->total_tax?></small>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="row">
		
			<div class="col-lg-4">
				<a href="<?=base_url('pending_advance')?>">
			        <div class="ibox cust-card float-e-margins">
			            <div class="ibox-title">
			                <span class="label label-danger pull-right"></span>
			                <h5>Advance</h5>
			            </div>
			            <div class="ibox-content">
			                <h1 class="no-margins">
			                	<?php
			                	echo $advance;
			                	?>
			                </h1>
			            </div>
			        </div>
			    </a>
		    </div>
		    <div class="col-lg-4">
		    	<a href="<?=base_url('pending_due')?>">
		        <div class="ibox cust-card float-e-margins">
		            <div class="ibox-title">
		                <span class="label label-danger pull-right">DUE</span>
		                <h5>
		                	Total Due
		                </h5>
		            </div>
		            <div class="ibox-content">
		                <h1 class="no-margins"><?php
		                	echo $due;
		                	?></h1>
		                
		            </div>
		        </div>
	    		</a>
	      </div>
	    
        <div class="col-lg-4">
        	<a href="<?=base_url('booking_transfer')?>">
	        <div class="ibox cust-card float-e-margins">
	            <div class="ibox-title">
	                <span class="label label-danger pull-right"></span>
	                <h5>Outstanding</h5>
	            </div>
	            <div class="ibox-content">
	                <h1 class="no-margins">
	                	<?php echo $total_outstanding; ?>
	                </h1>
	                
	            </div>
	        </div>
	        </a>
        </div>
    </div>
    <div class="row">
			<div class="col-lg-3">
		        <div class="ibox cust-card float-e-margins">
		            <div class="ibox-title">
		                <span class="label label-danger pull-right"></span>
		                <h5>Cash credit</h5>
		            </div>
		            <div class="ibox-content">
		                <h1 class="no-margins">
		                	500000
		                </h1>
		            </div>
		        </div>
		    </div>
		
	    
	    
	        <div class="col-lg-3">
	        	<a href="<?=base_url('invoice/getbookdebts')?>">
			        <div class="ibox cust-card float-e-margins">
			            <div class="ibox-title">
			                <span class="label label-danger pull-right"></span>
			                <h5>Book Debts</h5>
			            </div>
			            <div class="ibox-content">
			                <h1 class="no-margins">
			                	<?php
			                	$bookrow= $obj->totalBookdebts();
			                	echo round($bookrow->InvoiceTotal,0);
			                	?>
			                </h1>
			                <small>Tax: <?=$bookrow->totalTax?> </small>
			            </div>
			        </div>
			    </a>
	        </div>

	    <div class="col-lg-3">
	        <div class="ibox cust-card float-e-margins">
	            <div class="ibox-title">
	                <span class="label label-danger pull-right"></span>
	                <h5>Term Loan</h5>
	            </div>
	            <div class="ibox-content">
	                <h1 class="no-margins">
	                	<?php
	                	$termloan=round($obj->getLoan(),0);	
	                	echo $termloan;
	                	?>
	                </h1>

	            </div>
	        </div>
	    </div>
	    <div class="col-lg-3">
	        <div class="ibox cust-card float-e-margins">
	            <div class="ibox-title">
	                <span class="label label-danger pull-right"></span>
	                <h5>Asset</h5>
	            </div>
	            <div class="ibox-content">
	                <h1 class="no-margins">
	                	<?= $assign_stock_value ?>
	                </h1>
	                <small>IDLE: <?= $idle_stock_value ?> </small>
	            </div>
	        </div>
	    </div>
    </div>

<!-- other content -->
            
            <div class="row">
               
                <div class="col-lg-6">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>CC Chart </h5>

                        </div>
                        <div class="ibox-content">
                            <div>
                                <canvas id="doughnutChart" height="140"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Term Loan Chart </h5>

                        </div>
                        <div class="ibox-content">
                            <div>
                                <canvas id="TermLoan" height="140"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
		    	<div class="col-lg-12">
		            <div class="ibox float-e-margins">
		                <div class="ibox-title">
		                    <h5>Expense Chart</h5>
		                    <div ibox-tools></div>
		                </div>
		                <div class="ibox-content">
		                    <div>
		                        <canvas id="barChart" height="140"></canvas>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		    
		    <div class="row">
                            <div class="col-lg-6">
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Outatanding</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                            <a class="close-link">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content table-responsive">
                                        <table class="table table-hover no-margins">
                                            <thead>
                                            <tr>
                                                <th>Billing Name</th>
                                                <th>Outstanding</th>
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $total=0;
                                            foreach ($outstanding as $row) {
                                            ?>
                                            <tr>
                                                <td><span class="label label-primary"><?=$row['consignee_billing_name']?></span> </td>
                                                <td><i class="fa fa-inr"></i><?=$row['outstanding']?></td>
                                                
                                            </tr>
                                            <?php
                                            $total+=$row['outstanding'];
                                        }
                                        ?>
                                        <tr>
                                        	<td><span class="label label-success">Total</span></td>
                                        	<td><span class="label label-success"><?=$total?></span></td>
                                        </tr>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Outatanding Before 90 Days</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                            <a class="close-link">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content table-responsive">
                                        <table class="table table-hover no-margins">
                                            <thead>
                                            <tr>
                                                <th>Billing Name</th>
                                                <th>Outstanding</th>
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $total=0;
                                            foreach ($credit as $row) {
                                            ?>
                                            <tr>
                                                <td><span class="label label-danger"><?=$row['consignee_billing_name']?></span> </td>
                                                <td><i class="fa fa-inr"></i><?=$row['outstanding']?></td>
                                                
                                            </tr>
                                            <?php
                                            $total+=$row['outstanding'];
                                        }
                                        ?>
                                        <tr>
                                        	<td><span class="label label-danger">Total</span></td>
                                        	<td><span class="label label-danger"><?=$total?></span></td>
                                        </tr>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php
$this->load->view('footer');
?>
<script src="<?=base_url()?>assets/js/plugins/chartJs/Chart.min.js"></script>
<script type="text/javascript">
	
	$(function () {
		var x=<?= round($bookrow->InvoiceTotal,0)?>;


    var ctx = document.getElementById('barChart').getContext('2d');
var myChart = new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: [<?php
        foreach ($expensehead as $row) {
        	if($row['amount']>0)
        		echo '"'.$row['expense_head_name'].'",';
        }
        echo '"Transportation"';
         ?>],
        datasets: [{
            label: '',
            data: [<?php
        foreach ($expensehead as $row) {
        	if(!empty($row['amount']) && $row['amount']>0)
        		echo $row['amount'].",";

        }
        echo $booking_transport+$totaltrasnport;
        ?>],
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});


   

    var doughnutData = {
        labels: ["CC","Book Debts" ],
        datasets: [{
            data: [6300000,x],
            backgroundColor: ["#a3e1d4","#dedede","#b5b8cf"]
        }],
        colors: ["#ff6361","#58508d"]
    } ;


    var doughnutOptions = {
        
    };


    var ctx4 = document.getElementById("doughnutChart").getContext("2d");
    new Chart(ctx4, {type: 'pie', data: doughnutData, options:doughnutOptions});
    var totalassets="<?php echo $assign_stock_value+$idle_stock_value ?>";
    //alert(totalassets);
    var doughnutData = {
        labels: ["Term Loan","Assets" ],
        datasets: [{
            data: [<?=$termloan?>,totalassets],
            backgroundColor: ["#a3e1d4","#dedede","#b5b8cf"]
        }],
        colors: ["#ff6361","#58508d"]
    } ;


    var doughnutOptions = {
        
    };


    var ctx4 = document.getElementById("TermLoan").getContext("2d");
    new Chart(ctx4, {type: 'pie', data: doughnutData, options:doughnutOptions});


});
</script>