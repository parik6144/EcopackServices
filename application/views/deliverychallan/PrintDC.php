<?php
/**
 * Created by PhpStorm.
 * User: Amit Parik
 * Date: 16/08/2017
 * Time: 14:52
 */
$this->load->view('header');
//$this->load->view('left_sidebar');
//$this->load->view('topbar');
?>
<style>td{ font-weight: bold; font-size: 20px}
    th{ font-weight: bold; font-size: 20px  }
    h4{font-size: 20px; }
    h3{font-size: 20px; font-weight: bold; }
    li{font-size: 20px; font-weight: bold;}</style>
<style>
    .table > tfoot > tr > td{
        vertical-align: middle;
    }
    .table > tbody > tr > td{
        vertical-align: middle;
    }
    .table > thead > tr > th{
        text-align: center;
    }
    .custom_control{
        margin-bottom: 15px;
    }
    .ibox-tools a {
        cursor: pointer;
        margin-left: 5px;
        color: #fefefe !important;
        font-size: 20px;
        background: #1ab394;
        padding: 3px 10px;
        border-radius: 3px;
    }

    .output-data-by {
        padding: 10px 0 0;
    }

    .output-data-by label.ad {
        font-weight: 600;
        font-size: 20px;
    }

    .output-data-by label.ph {
        /*font-weight: 600;*/
        font-size: 20px;
    }
    .i-checks {
        padding-left: 0;
        display: inline-block;
        margin-right: 10px;
    }

    td{
        border:1px solid #000000;
    }
    .logo{
        width:25%;
    }
    .description{
        height:200px;
    }
    .item{
        border-right: none;
        text-align: center;
    }
    .item_border{
        border-bottom: 0px solid !important;
        text-align: center;
        /*border-right: 0px solid;*/
    }
    td,.noborder{
        border-bottom: ;
        text-align: center;
    }
    .ibox-tools a {
        cursor: pointer;
        margin-left: 5px;
        color: #fefefe !important;
        font-size: 20px;
        background: #1ab394;
        padding: 3px 10px;
        border-radius: 3px;
    }
</style>
<style type="text/css">
    .tg  {border-collapse:collapse;border-spacing:0;margin:auto;width: 100%;}
    .tg td{font-family:Arial, sans-serif;font-size:20px;padding:3px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg1 td{font-family:Arial, sans-serif;font-size:20px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg th{font-family:Arial, sans-serif;font-size:20px;font-weight:normal;padding:3px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg .tg-yw4l{vertical-align:top}
    th.tg-yw4l {text-align: left;}
    span.bold {
        font-weight: 700;
    }
	.bold{
		font-weight: 600;
	}
	ul.det-lst {
		list-style: none;
	}

	ul.det-lst li {
		font-size: 20px;
		/* padding: 0 10px; */
		line-height: 22px;
		display: inline-block;
    padding-right: 10px;
		/* text-align: left; */
	}
	
	/*---------- new challan format -------------*/
	.logo-cnt {
         display: flex;
    }
    
    .address-lst {
        padding-left: 15px;
    }
    
    ul.det-lst-0 {
        margin: 0;
        list-style: none;
        padding-left: 10px;
    }
    .h-20{
        height: 20px;
    }

    table.testInfoTable {
        page-break-before: always;
        width: 200px;
    }

    table.testInfoTable td, table.testInfoTable th {
        border: 1px solid;
    }
    
    .testInfoTable{ page-break-after: always; }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">

                <div class="ibox-title" style="display: none;">
                    <h5 style="font-weight: 600;">Delivery Challan<small></small></h5>
                    <div class="ibox-tools">
                        <a href="<?php echo site_url('Delivery') ?>"><i class="fa fa-angle-left"></i> Back</a>
                    </div>
                </div>

                <div class="ibox-content">
					<div class="testInfoTable" id="ConsigneeCopy" style="padding: 10px;">
						<table class="tg">
							<thead>
							<tr>
								<th style="width: 30%; border: none;" colspan="4" class="text-left" colspan="3" style="text-align: -webkit-center;">
								<span class="bold" style="font-weight: bold; font-weight: 600;">Delivery Challan</span></th>
								<th style="width: 30%; border: none;" colspan="4"></th>
								<th style="width: 30%; border: none;" colspan="4" colspan="4"><span class="bold" style="float: right; font-weight: 600;">Original :&nbsp;For Consignee&nbsp;&nbsp;&nbsp;</span></th>
							</tr>
							</thead>
							
                            <tbody>
								<tr>
									<th class="text-center" colspan="10">
										<h2 class="bold" style="font-weight: 600;">Delivery Challan</h2>
										<span style="font-size: 20px; margin-bottom: 0;  font-weight: 700;"><b>(See rule 55 of GST Rules 2017)</b></span>
									
									</th>
								</tr>
								
								<tr>
									<td class="text-left" colspan="4">
									    <div class="logo-cnt">
									        <img src="<?=base_url()?>/uploads/EcoPack.jpg" style="height: 40px;">
    										<div class="address-lst">
    										    <h3 class="bold" style="font-size: 30px;">Ecopack Services Pvt. Ltd</h3>
									        	<p style="font-size: 20px;  font-weight: 700;">H.No-15A, A-Road Zone No : 1B, Birsanagar, Telco Jamshedpur - 831019, Jharkhand</p>
    										</div>
									    </div>

                                        <div class="address-lst">
                                            <p style="font-size: 20px; font-weight: 700;">
                                                GSTNO :   20AAECE1697G1ZV</br>
                                                Company's PAN: AAECE1697G </br>
                                                E-mail :  saroj@ecopackservices.com</br>
                                            </p>
                                        </div>
									</td>
									
									<td class="text-center" colspan="6">
										<table style="width: 100%;  font-weight: 700;">
											<thead>
												<tr>
													<td style="text-align:left;"><b>Challan No : </b></td>
													<td style="text-align:left;">000<?=$form_data['consignment']->dc_no?></td>
													
													<td style="text-align:left;"><b>Dated: </b></td>
													<td style="text-align:left;"><?=date("d-M-Y",strtotime($form_data['consignment']->consignment_date))?></td>
												</tr>
												<tr>
													<td style="text-align:left;"><b>Warehouse : </b></td>
													<td style="text-align:left;"><b> <?=$form_data['consignment']->warehouse_name?></b></td>
													
													<td style="text-align:left;"><b>Way Bill No : </b></td>
													<td style="text-align:left;"><?=$form_data['consignment']->way_bill_no?></td>
												</tr>
												<tr>
													<td style="text-align:left;"><b> Address: </b></td>
													<td style="text-align:left;"></td>
													
													<td style="text-align:left;"><b>Other References: </b></td>
													<td style="text-align:left;"></td>
												</tr>
												
												<tr>
													<td style="text-align:left;"><b>Buyer's Order No:</b></td>
													<td style="text-align:left;"></td>
													
													<td style="text-align:left;"><b> </b></td>
													<td style="text-align:left;"></td>
												</tr>
												
												<tr>
													<td style="text-align:left;"><b>LR No:</b></td>
													<td style="text-align:left;"></td>

                                                    <td style="text-align:left;"><b>Vehicle No: </b></td>
                                                    <td style="text-align:left;"><?=$form_data['consignment']->vehicle_inward_no?></td>
												</tr>
												
												<tr>
													<td style="text-align:left;"><b>Dispatched Through:</b></td>
													<td style="text-align:left;"><b>Road</b></td>
													
													<td style="text-align:left;"><b>Driver's Name:  </b></td>
													<td style="text-align:left;"><?=$form_data['consignment']->driver_name?></td>
												</tr>
												
												<tr>
													<td style="text-align:left;"><b>Date & Time of Issue:</b></td>
													<td style="text-align:left;"></td>
													
													<td style="text-align:left;"><b>Driver's Mobile no. </b></td>
													<td style="text-align:left;"><?=$form_data['consignment']->v_mobile_no?></td>
												</tr>

											</thead>
										</table>
									</td>
								</tr>
								
								<tr>
									<td colspan="6" style="text-align:left;"><b>Ship From: <strong><?=$form_data['consignment']->source?></strong></b></td>
									<td colspan="6" style="text-align:left;"><b>Ship To: <strong><?=$form_data['consignment']->destination?></strong></b></td>
								</tr>


								<tr>
									<td colspan="5" style="text-align:left;">
                                        <h4>Consignor : <?=$form_data['consignment']->consignor_name?></h4>
										<ul class="det-lst-0">
										    <li>Address :<?=$form_data['consignment']->address?></li>
										    <li>City  :<?=$form_data['consignment']->city?>, Pincode : <?=$form_data['consignment']->pincode?></li>
											<li>State : <?=$form_data['consignment']->state?></li>
											<li>Mobile : <?=$form_data['consignment']->mobile_no?></li>
											<li style="display: none;">GST No : <?=$form_data['consignment']->consignor_gstin?></li>
										</ul>
									
									</td>
									<td colspan="5" style="text-align:left;">
                                        <h4>Consignee : <?=$form_data['consignment']->consignee_name?></h4>
									    <ul class="det-lst-0">
                                            <li>Address :<?=$form_data['consignment']->c_address?></li>
                                            <li>City  :<?=$form_data['consignment']->c_city?>, Pincode : <?=$form_data['consignment']->c_pincode?></li>
                                            <li>State : <?=$form_data['consignment']->c_state?></li>
                                            <li>Mobile : <?=$form_data['consignment']->c_mobile_no?></li>
                                            <li style="display: none;">GST No : <?=$form_data['consignment']->gstin?></li>
										</ul>
									</td>
								</tr>
								

								<tr style="text-align:left;">
									<td colspan="5" style="text-align:left;"><b>Consignor GSTIN/UIN: <?=$form_data['consignment']->consignor_gstin?></b></td>
									<td colspan="5" style="text-align:left;"><b>Consignee GSTIN/UIN: <?=$form_data['consignment']->gstin?></b></td>
								</tr>

                            </tbody>
                        </table>

                        <table style="width: 100%">
                            <tbody>
                                <tr>
                                    <td colspan="10" style="text-align:center; border-top-color: transparent; "><h3>Rent Stock Item</h3></td>
                                </tr>

								<tr>
									<td colspan="1" style="text-align:center;"><b>Sl No</b></td>
									<td colspan="6" style="text-align:center;"><b>Description Of Goods</b></td>
									<td colspan="3" style="text-align:center;"><b>Quantity</b></td>
								</tr>

                                <?php $ctr=1; $rqty=0; foreach ($form_data['consignment_item'] as $row) { ?>
                                    <tr>
                                        <td colspan="1" style="text-align:center;"><?=$ctr?></td>
                                        <td colspan="6" style="text-align:center;"><?=$row['item_name']?></td>
                                        <td colspan="3" style="text-align:center;"><?=$row['qty']?></td>
                                    </tr>
                                <?php $rqty=$rqty+$row['qty']; $ctr++; } ?>

                                <tr>
                                    <td colspan="1" style="text-align:center;"></td>
                                    <td colspan="6" style="text-align:center;"><b>Total</b></td>
                                    <td colspan="3" style="text-align:center;"><b><?=$rqty?></b></td>
                                </tr>

                                <tr>
                                    <td colspan="10" style="text-align:center;"><h3>Billing Item</h3></td>
                                </tr>

                                <tr>
                                    <td colspan="1" style="text-align:center;"><b>Sl No</b></td>
                                    <td colspan="6" style="text-align:center;"><b>Description Of Goods</b></td>
                                    <td colspan="3" style="text-align:center;"><b>Quantity</b></td>
                                </tr>

                                <?php $ctr=1; $bqty=0; foreach ($form_data['consignment_stock_item'] as $row) { ?>
								<tr>
									<td colspan="1" style="text-align:center;"><?=$ctr?></td>
									<td colspan="6" style="text-align:center;"><?=$row['item_name']?></td>
									<td colspan="3" style="text-align:center;"><?=$row['qty']?></td>
								</tr>
                               <?php $bqty=$bqty+$row['qty']; $ctr++; } ?>

                                <tr>
                                    <td colspan="1" style="text-align:center;"></td>
                                    <td colspan="6" style="text-align:center;"><b>Total</b></td>
                                    <td colspan="3" style="text-align:center;"><b><?=$bqty?></b></td>
                                </tr>

                            </tbody>
                        </table>

                        <table style="width: 100%">
                            <tbody>
                                <tr>
                                    <td colspan="5" style="text-align:center; height: 160px; vertical-align:bottom; border-top-color: transparent; ">Driver's Signature</td>
                                    <td colspan="5" style="text-align:center; height: 160px; vertical-align:bottom; border-top-color: transparent; "><b>Authorised Signatory </br> <strong style="text-align:right;">For Ecopack Services Pvt. Ltd </strong></b></td>
                                </tr>

								<tr>
									<td colspan="10" style="text-align:center;">
                                        Note: Kindly submit the receiving copy to the transporter through courier or in hand within 10 days of delivery,or else transporter will not be responsible for the rest payment
                                    </td>
								</tr>
								
							</tbody>
						</table>
                        <br>
                    </div>

                 

                    <div class="testInfoTable" id="TransporterCopy" style="padding: 10px;">
                        <table class="tg">
                            <thead>
                            <tr>
                                <th style="width: 30%; border: none;" colspan="4" class="text-left"  style="text-align: -webkit-center;">
                                    <span class="bold" style="font-weight: bold;">Delivery Challan</span></th>
                                <th style="width: 30%; border: none;" colspan="4"></th>
                                <th style="width: 100%; border: none;" colspan="3"><span class="bold" style="float: right">Duplicate :&nbsp;For Transporter&nbsp;&nbsp;&nbsp;</span></th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <!--<th colspan="2" style="width: 10%;"><img src="<?=base_url()?>/uploads/EcoPack.jpg" style="height: 40px;"></th>-->
                                <th class="text-center" colspan="10">
                                    <h2 class="bold">Delivery Challan</h2>
                                    <span style="font-size: 20px; margin-bottom: 0;"><b>(See rule 55 of GST Rules 2017)</b></span>
                                </th>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="4">
                                    <div class="logo-cnt">
                                        <img src="<?=base_url()?>/uploads/EcoPack.jpg" style="height: 40px;">
                                        <div class="address-lst">
                                            <h3 class="bold">Ecopack Services Pvt. Ltd</h3>
                                            <p style="font-size: 20px;">H.No-15A, A-Road Zone No : 1B, Birsanagar, Telco Jamshedpur - 831019, Jharkhand</p>
                                        </div>
                                    </div>

                                    <div class="address-lst">
                                        <p style="font-size: 20px;">GSTNO :   20AAECE1697G1ZV</br>
                                            Company's PAN: AAECE1697G </br>
                                            E-mail :  saroj@ecopackservices.com</br></p>
                                    </div>
                                </td>

                                <td class="text-center" colspan="6">
                                    <table style="width: 100%">
                                        <thead>
                                        <tr>
                                            <td style="text-align:left;"><b>Challan No: </b></td>
                                            <td style="text-align:left;">000<?=$form_data['consignment']->dc_no?></td>

                                            <td style="text-align:left;"><b>Dated: </b></td>
                                            <td style="text-align:left;"><?=date("d-M-Y",strtotime($form_data['consignment']->consignment_date))?></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left;"><b>Warehouse : </b></td>
                                            <td style="text-align:left;"><b> <?=$form_data['consignment']->warehouse_name?></b></td>

                                            <td style="text-align:left;"><b>Way Bill No : </b></td>
                                            <td style="text-align:left;"><?=$form_data['consignment']->way_bill_no?></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:left;"><b> Address: </b></td>
                                            <td style="text-align:left;"></td>

                                            <td style="text-align:left;"><b>Other References: </b></td>
                                            <td style="text-align:left;"></td>
                                        </tr>

                                        <tr>
                                            <td style="text-align:left;"><b>Buyer's Order No:</b></td>
                                            <td style="text-align:left;"></td>

                                            <td style="text-align:left;"><b> </b></td>
                                            <td style="text-align:left;"></td>
                                        </tr>

                                        <tr>
                                            <td style="text-align:left;"><b>LR No:</b></td>
                                            <td style="text-align:left;"></td>

                                            <td style="text-align:left;"><b>Vehicle No: </b></td>
                                            <td style="text-align:left;"><?=$form_data['consignment']->vehicle_inward_no?></td>
                                        </tr>

                                        <tr>
                                            <td style="text-align:left;"><b>Dispatched Through:</b></td>
                                            <td style="text-align:left;"><b>Road</b></td>

                                            <td style="text-align:left;"><b>Driver's Name:  </b></td>
                                            <td style="text-align:left;"><?=$form_data['consignment']->driver_name?></td>
                                        </tr>

                                        <tr>
                                            <td style="text-align:left;"><b>Date & Time of Issue:</b></td>
                                            <td style="text-align:left;"></td>

                                            <td style="text-align:left;"><b>Driver's Mobile no. </b></td>
                                            <td style="text-align:left;"><?=$form_data['consignment']->v_mobile_no?></td>
                                        </tr>

                                        </thead>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="6" style="text-align:left;"><b>Ship From: <strong><?=$form_data['consignment']->source?></strong></b></td>
                                <td colspan="6" style="text-align:left;"><b>Ship To: <strong><?=$form_data['consignment']->destination?></strong></b></td>
                            </tr>

                            <tr>
                                <td colspan="5" style="text-align:left;">
                                    <h4>Consignor : <?=$form_data['consignment']->consignor_name?></h4>
                                    <ul class="det-lst-0">
                                        <li>Address :<?=$form_data['consignment']->address?></li>
                                        <li>City  :<?=$form_data['consignment']->city?>, Pincode : <?=$form_data['consignment']->pincode?></li>
                                        <li>State : <?=$form_data['consignment']->state?></li>
                                        <li>Mobile : <?=$form_data['consignment']->mobile_no?></li>
                                        <li style="display: none;">GST No : <?=$form_data['consignment']->consignor_gstin?></li>
                                    </ul>

                                </td>
                                <td colspan="5" style="text-align:left;">
                                    <h4>Consignee : <?=$form_data['consignment']->consignee_name?></h4>
                                    <ul class="det-lst-0">
                                        <li>Address :<?=$form_data['consignment']->c_address?></li>
                                        <li>City  :<?=$form_data['consignment']->c_city?>, Pincode : <?=$form_data['consignment']->c_pincode?></li>
                                        <li>State : <?=$form_data['consignment']->c_state?></li>
                                        <li>Mobile : <?=$form_data['consignment']->c_mobile_no?></li>
                                        <li style="display: none;">GST No : <?=$form_data['consignment']->gstin?></li>
                                    </ul>
                                </td>
                            </tr>


                            <tr style="text-align:left;">
                                <td colspan="5" style="text-align:left;"><b>Consignor GSTIN/UIN: <?=$form_data['consignment']->consignor_gstin?></b></td>
                                <td colspan="5" style="text-align:left;"><b>Consignee GSTIN/UIN: <?=$form_data['consignment']->gstin?></b></td>
                            </tr>

                            </tbody>
                        </table>

                        <table style="width: 100%">
                            <tbody>
                            <tr>
                                <td colspan="10" style="text-align:center;border-top-color: transparent; "><h3>Rent Stock Item</h3></td>
                            </tr>

                            <tr>
                                <td colspan="1" style="text-align:center;"><b>Sl No</b></td>
                                <td colspan="6" style="text-align:center;"><b>Description Of Goods</b></td>
                                <td colspan="3" style="text-align:center;"><b>Quantity</b></td>
                            </tr>

                            <?php $ctr=1; $rqty=0; foreach ($form_data['consignment_item'] as $row) { ?>
                                <tr>
                                    <td colspan="1" style="text-align:center;"><?=$ctr?></td>
                                    <td colspan="6" style="text-align:center;"><?=$row['item_name']?></td>
                                    <td colspan="3" style="text-align:center;"><?=$row['qty']?></td>
                                </tr>
                                <?php $rqty=$rqty+$row['qty']; $ctr++; } ?>

                            <tr>
                                <td colspan="1" style="text-align:center;"></td>
                                <td colspan="6" style="text-align:center;"><b>Total</b></td>
                                <td colspan="3" style="text-align:center;"><b><?=$rqty?></b></td>
                            </tr>

                            <tr>
                                <td colspan="10" style="text-align:center;"><h3>Billing Item</h3></td>
                            </tr>

                            <tr>
                                <td colspan="1" style="text-align:center;"><b>Sl No</b></td>
                                <td colspan="6" style="text-align:center;"><b>Description Of Goods</b></td>
                                <td colspan="3" style="text-align:center;"><b>Quantity</b></td>
                            </tr>

                            <?php $ctr=1; $bqty=0; foreach ($form_data['consignment_stock_item'] as $row) { ?>
                                <tr>
                                    <td colspan="1" style="text-align:center;"><?=$ctr?></td>
                                    <td colspan="6" style="text-align:center;"><?=$row['item_name']?></td>
                                    <td colspan="3" style="text-align:center;"><?=$row['qty']?></td>
                                </tr>
                                <?php $bqty=$bqty+$row['qty']; $ctr++; } ?>

                            <tr>
                                <td colspan="1" style="text-align:center;"></td>
                                <td colspan="6" style="text-align:center;"><b>Total</b></td>
                                <td colspan="3" style="text-align:center;"><b><?=$bqty?></b></td>
                            </tr>

                            </tbody>
                        </table>

                        <table style="width: 100%">
                            <tbody>
                            <tr>
                                <td colspan="5" style="text-align:center; height: 160px; vertical-align:bottom;border-top-color: transparent; ">Driver's Signature</td>
                                <td colspan="5" style="text-align:center; height: 160px; vertical-align:bottom;border-top-color: transparent; "><b>Authorised Signatory </br> <strong style="text-align:right;">For Ecopack Services Pvt. Ltd </strong></b></td>
                            </tr>

                            <tr>
                                <td colspan="10" style="text-align:center;">
                                    Note: Kindly submit the receiving copy to the transporter through courier or in hand within 10 days of delivery,or else transporter will not be responsible for the rest payment
                                </td>
                            </tr>

                            </tbody>
                        </table>
                        <br>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?php  //$this->load->view('footer'); ?>
</body>

<script type="text/javascript">
    window.print();
    //window.close();
    setTimeout(function(){window.close();}, 1000);
</script>


</html>
