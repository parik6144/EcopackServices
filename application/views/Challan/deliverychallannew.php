<?php
/**
 * Created by PhpStorm.
 * User: Amit Parik
 * Date: 16/08/2017
 * Time: 14:52
 */
$this->load->view('header');
$this->load->view('left_sidebar');
$this->load->view('topbar');
?>
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
        font-size: 16px;
        background: #1ab394;
        padding: 3px 10px;
        border-radius: 3px;
    }
    .output-data-by {
        padding: 10px 0 0;
    }

    .output-data-by label.ad {
        font-weight: 600;
        font-size: 14px;
    }

    .output-data-by label.ph {
        font-weight: 600;
        font-size: 14px;
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
        font-size: 16px;
        background: #1ab394;
        padding: 3px 10px;
        border-radius: 3px;
    }
</style>
<style type="text/css">
    .tg  {border-collapse:collapse;border-spacing:0;margin:auto;width: 100%;}
    .tg td{font-family:Arial, sans-serif;font-size:14px;padding:3px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg1 td{font-family:Arial, sans-serif;font-size:14px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
    .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:3px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
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
		font-size: 16px;
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
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Delivery Challan</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">

                <div class="ibox-title" style="display: none;">
                    <h5>Delivery Challan<small></small></h5>
                    <div class="ibox-tools">
                        <a href="<?php echo site_url('Delivery') ?>"><i class="fa fa-angle-left"></i> Back</a>
                    </div>
                </div>

                <div class="ibox-content">
					
					<div class="invoice1" id="DivIdToPrint" style="padding: 10px;">
						
						<table class="tg">
							<thead>
								<tr>
									
									<th style="width: 30%; border: none;" colspan="4" class="text-left" colspan="3" style="text-align: -webkit-center;">
									<span class="bold" style="font-weight: bold;">Delivery Challan</span></th>
									<th style="width: 30%; border: none;" colspan="4"></th>
									<th style="width: 30%; border: none;" colspan="4" colspan="4"><span class="bold" style="float: right">Original :&nbsp;For Consignee&nbsp;&nbsp;&nbsp;</span></th>
								</tr>
							</thead>
                            <tbody>
								<tr>
									<!--<th colspan="2" style="width: 10%;"><img src="<?=base_url()?>/uploads/EcoPack.jpg" style="height: 40px;"></th>-->
									<th class="text-center" colspan="10">
										
										<h2 class="bold">Delivery Challan</h2>
										<p style="font-size: 20px; margin-bottom: 0;">(See rule 55 of GST Rules 2017)</p>
									
									</th>
								</tr>
								
								<tr>
									<td class="text-left" colspan="4">
									    <div class="logo-cnt">
									        <img src="<?=base_url()?>/uploads/EcoPack.jpg" style="height: 40px;">
    										<div class="address-lst">
    										    <h3 class="bold">Ecopack Services Pvt. Ltd</h3>
									        	<p style="font-size: 16px;">H.No-15A, A-Road Zone No : 1B, Birsanagar, Telco Jamshedpur - 831019, Jharkhand</p>
    										</div>
									    </div>
										
										<ul class="det-lst-0">
										    <li>GSTNO :20ABRTP6805A120</li>
											<li>E-mail :saroj@ecopackservices.com</li>
										</ul>
									</td>
									
									<td class="text-center" colspan="6">
										<table style="width: 100%">
											<thead>
												
												<tr>
													<td style="text-align:left;"><b>Challan No: </b></td>
													<td style="text-align:left;">13213</td>
													
													<td style="text-align:left;"><b>Dated: </b></td>
													<td style="text-align:left;">9/6/2020</td>
												</tr>
												<tr>
													<td style="text-align:left;"><b>Mode/Turn of: </b></td>
													<td style="text-align:left;"></td>
													
													<td style="text-align:left;"><b> </b></td>
													<td style="text-align:left;"></td>
												</tr>
												<tr>
													<td style="text-align:left;"><b>Supplier's Ref:</b></td>
													<td style="text-align:left;"></td>
													
													<td style="text-align:left;"><b>Other References: </b></td>
													<td style="text-align:left;"></td>
												</tr>
												
												<tr>
													<td style="text-align:left;"><b>Buyer's Order No:</b></td>
													<td style="text-align:left;"></td>
													
													<td style="text-align:left;"><b>Dated: </b></td>
													<td style="text-align:left;">13213</td>
												</tr>
												
												<tr>
													<td style="text-align:left;"><b>LR No:</b></td>
													<td style="text-align:left;"></td>
													
													<td style="text-align:left;"><b>Dated: </b></td>
													<td style="text-align:left;">13213</td>
												</tr>
												
												<tr>
													<td style="text-align:left;"><b>Despatched Through:</b></td>
													<td style="text-align:left;">Road</td>
													
													<td style="text-align:left;"><b>Dated: </b></td>
													<td style="text-align:left;">9.6.2020</td>
												</tr>
												
												<tr>
													<td style="text-align:left;"><b>Date & Time of Issue:</b></td>
													<td style="text-align:left;"></td>
													
													<td style="text-align:left;"><b>Motot Vehicle No: </b></td>
													<td style="text-align:left;">5rb-1292</td>
												</tr>
												
											</thead>
										</table>
									</td>
								</tr>
								
								<tr>
									<td colspan="5" style="text-align:left;"><b>Ship To:</b></td>
									<td colspan="5" sty<td style="text-align:left;"><b>Ship From:</b></td>
								</tr>
								
								<tr>
									<td colspan="5" style="text-align:left;">
										<ul class="det-lst-0">
										    <li>GSTNO :20ABRTP6805A120</li>
											<li>E-mail :saroj@ecopackservices.com</li>
											<li>E-mail :saroj@ecopackservices.com</li>
											<li>E-mail :saroj@ecopackservices.com</li>
										</ul>
									
									</td>
									<td colspan="5" style="text-align:left;">
									    <ul class="det-lst-0">
										    <li>GSTNO :20ABRTP6805A120</li>
											<li>E-mail :saroj@ecopackservices.com</li>
											<li>E-mail :saroj@ecopackservices.com</li>
											<li>E-mail :saroj@ecopackservices.com</li>
										</ul>
									</td>
								</tr>
								
								
								
								<tr>
									<td colspan="5" style="text-align:left;"><b>GSTIN/UIN:</b></td>
									<td colspan="5" sty<td style="text-align:center;"><b>State Name & Code Jamshedpur:</b></td>
								</tr>
								<tr>
									<td colspan="1" style="text-align:left;"><b>Sr No;</b></td>
									<td colspan="3" style="text-align:left;"><b>Description Of Goods</b></td>
									<td colspan="1" style="text-align:right;"><b>HSN Code</b></td>
									
									<td colspan="1" style="text-align:center;"><b>Quantity</b></td>
									<td colspan="2" style="text-align:center;"><b>Rate</b></td>
									<td colspan="1" style="text-align:left;"><b>Uom</b></td>
									<td colspan="1" style="text-align:center;"><b>Amount</b></td>
								</tr>
								
								<tr>
									<td colspan="1" style="text-align:center;">1</td>
									<td colspan="3" style="text-align:left;">Pallets 1200 X 800</td>
									<td colspan="1" style="text-align:right;">29239090</td>
									
									<td colspan="1" style="text-align:center;">20</td>
									<td colspan="2" style="text-align:center;">100</td>
									<td colspan="1" style="text-align:left;">Uom</td>
									<td colspan="1" style="text-align:center;">2000</td>
								</tr>
								
								<tr>
									<td colspan="1" style="text-align:center;">1</td>
									<td colspan="3" style="text-align:left;">Pallets 1200 X 800</td>
									<td colspan="1" style="text-align:right;">29239090</td>
									
									<td colspan="1" style="text-align:center;">20</td>
									<td colspan="2" style="text-align:center;">100</td>
									<td colspan="1" style="text-align:left;">Uom</td>
									<td colspan="1" style="text-align:center;">2000</td>
								</tr>
								
								<tr>
									<td colspan="1" style="text-align:center;">1</td>
									<td colspan="3" style="text-align:left;">Pallets 1200 X 800</td>
									<td colspan="1" style="text-align:right;">29239090</td>
									
									<td colspan="1" style="text-align:center;">20</td>
									<td colspan="2" style="text-align:center;">100</td>
									<td colspan="1" style="text-align:left;">Uom</td>
									<td colspan="1" style="text-align:center;">2000</td>
								</tr>
								
								<tr>
									<td colspan="1" style="text-align:center;">1</td>
									<td colspan="3" style="text-align:left;">Pallets 1200 X 800</td>
									<td colspan="1" style="text-align:right;">29239090</td>
									
									<td colspan="1" style="text-align:center;">20</td>
									<td colspan="2" style="text-align:center;">100</td>
									<td colspan="1" style="text-align:left;">Uom</td>
									<td colspan="1" style="text-align:center;">2000</td>
								</tr>
								
								<tr>
									<td colspan="1" class="h-20" style="text-align:center;"></td>
									<td colspan="3" class="h-20" style="text-align:left;"></td>
									<td colspan="1" class="h-20" style="text-align:right;"></td>
									
									<td colspan="1" class="h-20" style="text-align:center;"></td>
									<td colspan="2" class="h-20" style="text-align:center;"></td>
									<td colspan="1" class="h-20" style="text-align:left;"></td>
									<td colspan="1" class="h-20" style="text-align:center;"></td>
								</tr>
								
								<tr>
									<td colspan="6" style="text-align:center;"></td>
									
									<td colspan="2" style="text-align:left;">
									    <ul class="det-lst-0">
										    <li>Total</li>
											<li>IGST</li>
											<li></li>
											<li>Round off</li>
										</ul>
									</td>
									<td colspan="1" style="text-align:right;">
									    <ul class="det-lst-0">
										    <li></li>
											<li>18%</li>
											<li></li>
											<li></li>
										</ul>
									</td>
									<td colspan="1" style="text-align:center;">
									    <ul class="det-lst-0">
										    <li>2000</li>
											<li>360</li>
											<li></li>
											<li>0</li>
										</ul>
									</td>
								
								</tr>
								
									<tr>
									<td colspan="6" style="text-align:center;">Total</td>
									
									<td colspan="3" style="text-align:left;">
									    Grand Total
									</td>
									<td colspan="1" style="text-align:center;">
									   2360/-
									</td>
								</tr>
								
								
								
							</tbody>
						</table>
						<table class="tgn tg" style="border:none;">
                            <style type="text/css">
                                .tg  {border-collapse:collapse;border-spacing:0;}
                                .tgn td{font-family:Arial, sans-serif;font-size:14px;padding:3px 5px;border-width:1px;overflow:hidden;word-break:normal;}
                                .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:3px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
                                .tg .tg-baqh{text-align:center;vertical-align:top}
                                .tg .tg-lqy6{text-align:right;vertical-align:top}
                                .tg .tg-yw4l{vertical-align:top}
                                .tg td.sum{
                                    border-bottom:none;
                                    border-top:none;
                                }
                            </style>
                            <thead>

							</thead>
							<tbody>
			
							</tbody>
						</table>
						


                        <!--<table class="tg">-->
                        <!--    <style type="text/css">-->
                        <!--        .tg  {border-collapse:collapse;border-spacing:0;}-->
                        <!--        .tg td{font-family:Arial, sans-serif;font-size:14px;padding:2px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}-->
                        <!--        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}-->
                        <!--        .tg .tg-baqh{text-align:center;vertical-align:top}-->
                        <!--        .tg .tg-lqy6{text-align:right;vertical-align:top}-->
                        <!--        .tg .tg-yw4l{vertical-align:top}-->
                        <!--    </style>-->
                        <!--    <tbody>-->
                        <!--    <tr>-->
                        <!--        <td class="tg-yw4l" colspan="8" rowspan="2">Tax Amount (in word):-->
                        <!--            <span class="bold"><b>INR two hundred thirty-two thousand, eight hundred twenty-nine only  </b></span>-->
                        <!--        </td>-->
                        <!--    </tr>-->
                        <!--    </tbody>-->
                        <!--</table>-->

                        <table class="tg">
                            <tbody>
                                 <tr>
                                    <td colspan="10" style="text-align: left;">
                                        <ul class="det-lst-0">
										    <li>Amount Chargable In (Word)</li>
											<li>INR One Only</li>
											<li>Two Thousand THree Hundred Sixty</li>
										
										</ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        Company's PAN: SOHVP&6567C
                                    </td>
                                    <td colspan="5">
                                        <p style="text-align:right;">
                                            <strong style="text-align:right;">For Ecopack Services Pvt. Ltd </strong>
                                        </p>
                                        <p>&nbsp;</p>
                                        <p style="text-align: right;">Authorised Signatory</p>
                                    </td>
                                </tr>
                                <tr>
    
                                </tr>
                            </tbody>
                            
                        </table>

                        <br>
                        <div class="col-lg-12">
                            <div class="col-lg-3 col-md-4 col-sm-4"></div>
                            <div class="col-lg-3 col-md-4 col-sm-4"></div>
                            <div class="col-lg-3 col-md-4 col-sm-4">
                                <button type="button" class="btn btn-secondary btn-lg btn-block" id="btn" onclick="printDiv();" style="float: right;">Print</button>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-4"></div>
                        </div>
                        <br><br>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>




<?php $this->load->view('footer'); ?>
</body>
</html>
