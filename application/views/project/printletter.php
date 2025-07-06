<?php
	$this->load->view('report_header');
	
	function calculateasset($purchase_cost,$interest,$time,$profit,$rotation,$life)
	{
		$a = $purchase_cost;
        $b = $interest;
        $c = $time;
        $n = $c;         
        $r = $b / (12 * 100);
        $p = ($a * $r * pow((1 + $r), $n)) / (pow((1 + $r), $n) - 1);
        $print = round($p);
        //$r1 = print.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $Totalpayment=$print*$c;
        $Totalinterest=$Totalpayment-$purchase_cost;
        $permonthinterest=$Totalinterest/$c;
        $perRotationInterest=$permonthinterest/$rotation;

        $total=$purchase_cost/($life*$rotation);
        //total+=rowtotal;

        /*custom*/
        //alert(total);
        //alert("interest"+perRotationInterest);
        $total_asset_expense=$total+$perRotationInterest;
        $profitinpercent=$profit;
        $profit=($total_asset_expense*$profitinpercent)/100;
        return number_format(($total_asset_expense+$profit),2);
        //$total_asset_expense_yearly=total_asset_expense*12;
	}
	function calculateoperation($operation_total,$interest,$rotation,$profitinpercent)
	{
		$toalopcost=$operation_total*$rotation;
        $operation_interest_rate=$interest;

        $interest_on_operation=($toalopcost*$operation_interest_rate)/100;
        $total_operation_expense=$operation_total+($interest_on_operation/12);
        //$profitinpercent=$profit;
        $profit=($total_operation_expense*$profitinpercent)/100;
        return number_format(($total_operation_expense+$profit),2);
	}

?>
<style type="text/css">
.center_text{
	text-align: center;
}
</style>
<div class="row">
	<div class="col-sm-4">
	</div>
	<div class="col-sm-4 center_text">
		<img alt="Ecopack" class="" onload="loadImage()" src="<?php echo site_url();?>uploads/EcoPack1.png" style="width:50%;" />
	</div>
	<div class="col-sm-4">
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<p><b>CIN –U63040JH2016PTC003444</b></p>
	</div>
	<div class="col-sm-4">
		<p class="center_text"><b><a href="www.ecopackservices.com">www.ecopackservices.com</a></b></p>
	</div>
	<div class="col-sm-4" style="text-align: right;">
		<p><b>GSTIN- 20AAECE1697G1ZV</b></p>
	</div>
</div>
<hr style="font-weight: bolder;"/>
<div class="float-right">Date- <?=date('d/m/Y')?></div>
<div class="con-sm-6">
<p><b><?=$form_data['project']['0']['company_name']?></b></p>
<p><b><?=$form_data['project']['0']['contact_person_name']?></b></p>
<p><b><?=$form_data['project']['0']['company_address']?></b></p>
</div>
<div class="row">
	<div class="col-sm-12">
		<b><u>Subject:- Commercial Proposal for <?=$form_data['project']['0']['project_name']?> </u></b>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<p>Dear Sir/Ma'm</p> 
<p>Thanks for providing us the opportunity. We here by providing best quotation as per our understanding about your requirement. Kindly feel free to contact us in case of any doubt.</p>

	</div>
</div>
<div class="center_text">
	<b>Cost Breakup</b>
</div>
<table  class="table table-striped table-border table-bordered" id="headerTable">
	<thead>
		<tr>
			<td>Sl. No.</td>
			<td>Perticular</td>
			<td>Amount</td>
		</tr>
	</thead>
	<tbody>
		<?php
		$ctr=0;
		$total=0;
		 foreach ($form_data['project_asset'] as $row): 
			$ctr++;
			$rowtotal=calculateasset($row['purchase_cost'],$form_data['project']['0']['assets_interest_rate'],"36",$form_data['project']['0']['profit_rate'],$form_data['project']['0']['rotation_per_month'],$row['life_in_month']);
			$total+=$rowtotal;
			?>
			<tr>
				<td><?=$ctr?></td>
				<td><?=$row['assets_name']?></td>
				<td style="text-align: right;"><?=$rowtotal?></td>
			</tr>
		<?php endforeach ?>


		<?php foreach ($form_data['project_operation'] as $row): $ctr++; 
			$rowtotal=calculateoperation($row['operation_cost'],"12",$form_data['project']['0']['rotation_per_month'],$form_data['project']['0']['profit_rate']);
			$total+=$rowtotal;
			?>
			<tr>
				<td><?=$ctr?></td>
				<td><?=$row['operation_name']?></td>
				<td style="text-align: right;"><?=$rowtotal?></td>
			</tr>
		<?php endforeach ?>
		<tr>
			<td colspan="2">Total</td>
			<td  style="text-align: right;"><b><?=round($total)?></b></td>
		</tr>
		
	</tbody>
</table>
<div class="row">
	<div class="col-sm-12" style="white-space: pre-line;">
		<?=$form_data['project']['0']['remarks']?>
	</div>
</div>
<?php
	$this->load->view('footer');
?>
<script type="text/javascript">
	$(document).ready(function(){
		window.print();
		window.close();
	})
</script>