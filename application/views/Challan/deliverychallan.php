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
                    <div class="invoice1 table-responsive">
                        <table class="table" style="width: 100%; height: 95%;">
							<thead>
								<tr>
									<th colspan="5" style="text-align:center;">
										<div class="col-xs-12 text-center">
											<span style="margin-left: 125px font-weight: 900;"><b>Delivery Challan</b></span>
											<span style="float: right">Original :&nbsp;For Consignee&nbsp;&nbsp;&nbsp;</span>
										</div>
									</th>
								</tr>
							</thead>
							<tbody>
								
								<tr>
									<td style="border-bottom: none;">
										<?php $res = $this->db->select('*')->from('sitedetails')->get()->row(); ?>
										<p>
											<div style="float: left;">&nbsp;&nbsp;&nbsp;<small style="bold">Transporter :</small></div>
											<img src="<?=base_url('uploads/').$res->siteLogo?>" style="height: 90px; padding: 10px;"><br>
											<strong style="font-size: 18px;">&nbsp;<?=$res->siteName?>&nbsp;</strong>
											<strong>Address :&nbsp;</strong><?=$res->address_1?><br>
											<?=$res->address_2?>, <?=$res->area?><br>
											<?=$res->city?> - <?=$res->pincode?>, <?=$res->state?><br>
											<strong>E-Mail :</strong>&nbsp;<?=$res->SiteEmail?> <br>
											<strong>Phone :</strong>&nbsp;<?=$res->mobile?><br>
											<strong>GSTIN :</strong>&nbsp;<?=$res->gstin?><br>
											<strong>State Code :</strong>&nbsp;<?=$res->statecode?></br>
											<strong>website : </strong>www.ecopackservices.com
										</p>
									</td>

									<td class="logo" style="padding: 15px; text-align: left; border-bottom: none;">
										<table style="float: left;">
											<tbody>
											<tr><div><small style="bold">Consignor :</small></div></tr>
											<tr><div><h3>CAPARO ENGINEERING INDIA LTD(UNIT I)</h3></div></tr>
											<tr><div> <strong>Address :&nbsp; </strong>Plot No C-11,12,Phase-IV,ADITYAPUR,INDUSTRIAL Area, Gamaharia</div></tr>
											<tr><div> <strong>City :&nbsp; </strong>JAMSHEDPUR</div></tr>
											<tr><div> <strong>Pincode :&nbsp; </strong>832108</div></tr>
											<tr><div> <strong>State :&nbsp;</strong>Jharkhand, &nbsp; <strong> Code : </strong>20</div></tr>
											<tr><div> <strong>Email :&nbsp; </strong>info@caparoengineering.com</div></tr>
											<tr><div> <strong>Contact :&nbsp; </strong>8083208469 / 8083208469 </strong></div></tr>
											<tr><div> <strong>Party :&nbsp; </strong>Mr.Debu</strong>,  <strong>Mobile : </strong>8956623235</div></tr>
											<tr><div> <strong>GSTIN :&nbsp; </strong>20AABCC7862N1ZI</div></tr>
											</tbody>
										</table>
									</td>

									<td class="logo" style="padding: 10px; text-align: left; border-bottom: none;">
										<table style="float: left;">
											<tbody>
											<tr><div><small style="bold">Consignee :</small></div></tr>
											<tr><div><h3>CONPACK POOLING (I) PVT LTD (PUNE)</h3></div></tr>
											<tr><div> <strong>Address :&nbsp; </strong>PUNE-NASIK ROAD,PRIYANKA WAREHOUSE,NEAR SHERE PUNJAB HOTEL,CHIMBLIPHATA,TAL KHED,DIST-PUNE</div></tr>
											<tr><div> <strong>City :&nbsp; </strong>PUNE</div></tr>
											<tr><div> <strong>Pincode :&nbsp; </strong>410499</div></tr>
											<tr><div> <strong>State :&nbsp;</strong>MAHARASTA, &nbsp; <strong> Code : </strong>27</div></tr>
											<tr><div> <strong>Email :&nbsp; </strong>info@conpackpooling.com</div></tr>
											<tr><div> <strong>Contact :&nbsp; </strong>7030686842 / 7030686842 </strong></div></tr>
											<tr><div> <strong>Party :&nbsp; </strong>Sachin</strong>,  <strong>Mobile : </strong>7030686842</div></tr>
											<tr><div> <strong>GSTIN :&nbsp; </strong>27AAFCC7452E1ZP</div></tr>
											</tbody>
										</table>
									</td>

									<style>
										.trans1{
											width:100%; height: 40px; border: none; float: left;
										}

										.trans2
										{
											width:100%; height: 40px; border-bottom: none;border-left: none; border-right: none; float: left;
										}
										.trans3{
											border-left: none;  border-right: none;border-bottom: none;  width:100%;
										}
										.decl{ padding: 5px; }

									</style>

									<td class="logo" style="border-bottom: none;">
										<table class="table" style="width:100%">
											<tbody>
											  <tr><td class="trans1">&nbsp;<strong>Delivery Challan No :</strong> 5194 &nbsp;</td></tr>
											  <tr><td class="trans2">&nbsp;<strong>Transaction No :</strong> ECO-19-20/00205 &nbsp;</td></tr>
											  <tr><td class="trans2">&nbsp;<strong>Transaction Date : </strong>16-Jan-2020 &nbsp;</td></tr>
											  <tr><td class="trans2">&nbsp;<strong>Transaction Type :</strong> Allot &nbsp;</td></tr>
											  <tr><td class="trans2">&nbsp;<strong> Dispatch Date : </strong>19-Jan-2020 &nbsp;</td></tr>
											  <tr><td class="trans2">&nbsp;<strong> Consignment Type :</strong>  Rent &nbsp;</td></tr>
											  <tr><td class="trans2">&nbsp;<strong> Way Bill No :</strong>  BFJ-5655 &nbsp;</td></tr>
											  <tr><td class="trans3">&nbsp;<strong> Vehicle Description </strong></td></tr>
											  <tr> <td style="border: none;">Vehicle No : JH-05AQ 5895</td></tr>
											  <tr> <td style="border: none;">Driver : Ravindar Mohanty</td></tr>
											  <tr> <td style="border: none;">Mobile : +91-923456988</td></tr>
											  <tr> <td style="border: none;">D/L No : LR6596566565</td></tr>
											</tbody>
										</table>
									</td>
									
								</tr>
							</tbody>
                        </table>

                        <table class="table" style="width: 100%; height: 95%;">
                            <tbody>
								<tr style="height: 32px;">
									<td style="width: 54px; height: 32px; padding: 10px;">Sl.No.</td>
									<td style="width: 226px; height: 32px; padding: 10px;">Description of Goods</td>
									<td style="width: 44px; height: 32px; padding: 10px;">HSN/SAC</td>
									<td style="width: 67px; height: 32px; padding: 10px;">Unit Price</td>
									<td style="width: 63px; height: 32px; padding: 10px;">Quantity</td>
									<td style="width: 47px; height: 32px; padding: 10px;">Uom</td>

									<td style="width: 117px;" colspan="2">Discount
										<table>
											<tr>
												<td style="width:126px;border left: none;border-bottom: none;border-left: none;">&nbsp;Rate&nbsp;</td>
												<td style="width:126px;border left: none;border-bottom: none;border-left: none;border-right: none;">&nbsp;Amt&nbsp;</td>
											</tr>
										</table>
									</td>

									<td style="width: 47px; height: 32px; padding: 10px;">Taxable Amt.</td>

									<td style="width: 117px;" colspan="2">CGST Tax
										<table>
											<tr>
												<td style="width:126px;border left: none;border-bottom: none;border-left: none;">Rate</td>
												<td style="width:126px;border left: none;border-bottom: none;border-left: none;border-right: none;">Amt</td>
											</tr>
										</table>
									</td>
									<td style="width: 117px;" colspan="2">&nbsp;SGST Tax
										<table>
											<tr>
												<td style="width:126px;border left: none;border-bottom: none;border-left: none;"><span>Rate</span></td>
												<td style="width:126px;border left: none;border-bottom: none;border-left: none;border-right: none;"><span>Amt</span></td>
											</tr>
										</table>
									</td>
									<td style="width: 117px;" colspan="2">&nbsp;IGST Tax
										<table>
											<tr>
												<td style="width:126px;border left: none;border-bottom: none;border-left: none;">&nbsp;Rate&nbsp;</td>
												<td style="width:126px;border left: none;border-bottom: none;border-left: none;border-right: none;">&nbsp;Amt&nbsp;</td>
											</tr>
										</table>
									</td>

									<td style="width: 69px; height: 32px; padding: 10px;">Amount</td>
								</tr>
								<tr><td colspan="16"><strong class="text-center">Rent-Item</strong></td></tr>

								<tr>
									<td class="noborder">1</td>
									<td class="item">&nbsp;PP BASE PALLET- 1200 X 800 MM&nbsp;</td>
									<td class="item">&nbsp;87141090&nbsp;</td>
									<td class="item">&nbsp;1412.50&nbsp;</td>
									<td class="item">&nbsp;1&nbsp;</td>
									<td class="item">&nbsp;Nos.</td>
									<td class="item">&nbsp;20%&nbsp;</td>
									<td class="item">&nbsp;282.50&nbsp;</td>
									<td class="item">&nbsp;1130.00&nbsp;</td>
									<td class="item">&nbsp;14.00%&nbsp;</td>
									<td class="item">&nbsp;158.20&nbsp;</td>
									<td class="item">&nbsp;14.00%&nbsp;</td>
									<td class="item">&nbsp;158.20&nbsp;</td>
									<td class="item">&nbsp;0.00%&nbsp;</td>
									<td class="item">&nbsp;0.00&nbsp;</td>
									<td>1446.4</td>
								</tr>
								<tr>
									<td class="noborder">2</td>
									<td class="item">&nbsp;PP SEPARATOR SHEET 2000GSM - 1150 x 750MM&nbsp;</td>
									<td class="item">&nbsp;87141090&nbsp;</td>
									<td class="item">&nbsp;260.16&nbsp;</td>
									<td class="item">&nbsp;1&nbsp;</td>
									<td class="item">&nbsp;Nos.</td>
									<td class="item">&nbsp;20%&nbsp;</td>
									<td class="item">&nbsp;52.03&nbsp;</td>
									<td class="item">&nbsp;208.13&nbsp;</td>
									<td class="item">&nbsp;14.00%&nbsp;</td>
									<td class="item">&nbsp;29.14&nbsp;</td>
									<td class="item">&nbsp;14.00%&nbsp;</td>
									<td class="item">&nbsp;29.14&nbsp;</td>
									<td class="item">&nbsp;0.00%&nbsp;</td>
									<td class="item">&nbsp;0.00&nbsp;</td>
									<td>266.41</td>
								</tr>
								<tr>
									<td class="noborder">3</td>
									<td class="item">&nbsp;PP SEPARATOR SHEET 750GSM - 1150 x 750MM&nbsp;</td>
									<td class="item">&nbsp;87141090&nbsp;</td>
									<td class="item">&nbsp;649.22&nbsp;</td>
									<td class="item">&nbsp;1&nbsp;</td>
									<td class="item">&nbsp;Nos.</td>
									<td class="item">&nbsp;20%&nbsp;</td>
									<td class="item">&nbsp;129.84&nbsp;</td>
									<td class="item">&nbsp;519.38&nbsp;</td>
									<td class="item">&nbsp;14.00%&nbsp;</td>
									<td class="item">&nbsp;72.71&nbsp;</td>
									<td class="item">&nbsp;14.00%&nbsp;</td>
									<td class="item">&nbsp;72.71&nbsp;</td>
									<td class="item">&nbsp;0.00%&nbsp;</td>
									<td class="item">&nbsp;0.00&nbsp;</td>
									<td>664.8</td>
								</tr>
								<tr>
									<td class="noborder">4</td>
									<td class="item">&nbsp; PP TOP COVER - 1200 X 800 MM&nbsp;</td>
									<td class="item">&nbsp;87141090&nbsp;</td>
									<td class="item">&nbsp;136.71&nbsp;</td>
									<td class="item">&nbsp;1&nbsp;</td>
									<td class="item">&nbsp;Nos.</td>
									<td class="item">&nbsp;20%&nbsp;</td>
									<td class="item">&nbsp;27.34&nbsp;</td>
									<td class="item">&nbsp;109.37&nbsp;</td>
									<td class="item">&nbsp;14.00%&nbsp;</td>
									<td class="item">&nbsp;15.31&nbsp;</td>
									<td class="item">&nbsp;14.00%&nbsp;</td>
									<td class="item">&nbsp;15.31&nbsp;</td>
									<td class="item">&nbsp;0.00%&nbsp;</td>
									<td class="item">&nbsp;0.00&nbsp;</td>
									<td>139.99</td>
								</tr>
								<tr>
									<td class="noborder">5</td>
									<td class="item">&nbsp;  SIDE WALL - 690 MM&nbsp;</td>
									<td class="item">&nbsp;87141090&nbsp;</td>
									<td class="item">&nbsp;136.71&nbsp;</td>
									<td class="item">&nbsp;1&nbsp;</td>
									<td class="item">&nbsp;Nos.</td>
									<td class="item">&nbsp;20%&nbsp;</td>
									<td class="item">&nbsp;27.34&nbsp;</td>
									<td class="item">&nbsp;109.37&nbsp;</td>
									<td class="item">&nbsp;14.00%&nbsp;</td>
									<td class="item">&nbsp;15.31&nbsp;</td>
									<td class="item">&nbsp;14.00%&nbsp;</td>
									<td class="item">&nbsp;15.31&nbsp;</td>
									<td class="item">&nbsp;0.00%&nbsp;</td>
									<td class="item">&nbsp;0.00&nbsp;</td>
									<td>139.99</td>
								</tr>
								<tr>
									<td class="noborder">6</td>
									<td class="item">&nbsp;SIDE WALL- 390 MM&nbsp;</td>
									<td class="item">&nbsp;87141090&nbsp;</td>
									<td class="item">&nbsp;136.71&nbsp;</td>
									<td class="item">&nbsp;1&nbsp;</td>
									<td class="item">&nbsp;Nos.</td>
									<td class="item">&nbsp;20%&nbsp;</td>
									<td class="item">&nbsp;27.34&nbsp;</td>
									<td class="item">&nbsp;109.37&nbsp;</td>
									<td class="item">&nbsp;14.00%&nbsp;</td>
									<td class="item">&nbsp;15.31&nbsp;</td>
									<td class="item">&nbsp;14.00%&nbsp;</td>
									<td class="item">&nbsp;15.31&nbsp;</td>
									<td class="item">&nbsp;0.00%&nbsp;</td>
									<td class="item">&nbsp;0.00&nbsp;</td>
									<td>139.99</td>
								</tr>
								<tr><td colspan="16"><strong class="text-center">Billing-Item</strong></td></tr>
								<tr>
									<td class="noborder">1</td>
									<td class="item">&nbsp;Big FLC&nbsp;</td>
									<td class="item">&nbsp;87141090&nbsp;</td>
									<td class="item">&nbsp;1412.50&nbsp;</td>
									<td class="item">&nbsp;33&nbsp;</td>
									<td class="item">&nbsp;Nos.</td>
									<td class="item">&nbsp;20%&nbsp;</td>
									<td class="item">&nbsp;282.50&nbsp;</td>
									<td class="item">&nbsp;1130.00&nbsp;</td>
									<td class="item">&nbsp;14.00%&nbsp;</td>
									<td class="item">&nbsp;158.20&nbsp;</td>
									<td class="item">&nbsp;14.00%&nbsp;</td>
									<td class="item">&nbsp;158.20&nbsp;</td>
									<td class="item">&nbsp;0.00%&nbsp;</td>
									<td class="item">&nbsp;0.00&nbsp;</td>
									<td>1446.4</td>
								</tr>

								<tr>
									<td class="noborder">2</td>
									<td class="item">&nbsp;Small FLC&nbsp;</td>
									<td class="item">&nbsp;87141090&nbsp;</td>
									<td class="item">&nbsp;1412.50&nbsp;</td>
									<td class="item">&nbsp;19&nbsp;</td>
									<td class="item">&nbsp;Nos.</td>
									<td class="item">&nbsp;20%&nbsp;</td>
									<td class="item">&nbsp;282.50&nbsp;</td>
									<td class="item">&nbsp;1130.00&nbsp;</td>
									<td class="item">&nbsp;14.00%&nbsp;</td>
									<td class="item">&nbsp;158.20&nbsp;</td>
									<td class="item">&nbsp;14.00%&nbsp;</td>
									<td class="item">&nbsp;158.20&nbsp;</td>
									<td class="item">&nbsp;0.00%&nbsp;</td>
									<td class="item">&nbsp;0.00&nbsp;</td>
									<td>1446.4</td>
								</tr>
								<tr>
									<td class="item" colspan="15"> <strong>Total ( with Round off )</strong></td>
									<td><strong>6166</strong></td>
								</tr>

								<tr><td colspan="16">Amount chargable in Word: <strong>INR Six thousand, one hundred sixty-six Only </strong></td></tr>
                            </tbody>
                        </table>

                        <table class="table" style="width: 100%; height: 95%; ">
                            <tbody>
								<tr>
									<td style="width: 116px;">&nbsp;HSN/SAC</td>
									<td style="width: 117px;">Taxable value</td>
									<td style="width: 117px;" colspan="2">Central Tax
										<table class="table">
											<tbody>
												<tr>
													<td style="width:200px; border-left: none;">Rate</td>
													<td style="width:200px; border-right: none; border-left: none;">Amt</td>
												</tr>
											</tbody>
										</table>
									</td>
									<td style="width: 117px;" colspan="2">&nbsp;State Tax
										<table class="table">
											<tbody>
												<tr>
													<td style="width:200px; border-left: none;">Rate</td>
													<td style="width:200px; border-right: none; border-left: none;">Amt</td>
												</tr>
											</tbody>
										</table>
									</td>
									<td style="width: 117px;" colspan="2">&nbsp;IGST Tax
										<table class="table">
											<tbody>
												<tr>
													<td style="width:200px; border-left: none;">Rate</td>
													<td style="width:200px; border-right: none; border-left: none;">Amt</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>

								<tr>
									<td style="width: 116px;">&nbsp;87141090</td>
									<td style="width: 117px;">2473.18</td>
									<td style="width: 116px;">&nbsp;14.00%</td>
									<td style="width: 117px;">346.24</td>
									<td style="width: 116px;">&nbsp;14.00%</td>
									<td style="width: 117px;">346.24</td>
									<td style="width: 116px;">&nbsp;0.00%</td>
									<td style="width: 117px;">0.00</td>
								</tr>

								<tr>
									<td colspan="8" style="width: 927px;">Total Tax Amount(in words):<strong>INR six hundred ninety-two and four nine paise  Only </strong></td>
								</tr>
                            </tbody>
                        </table>


                        <table class="table" style="width: 100%; height: 95%; ">
                            <tbody>
								<tr style="padding: 15px;">
									<td style="width: 927px; text-align: left; border-bottom: none;">
										<b style="padding: 15px;">Declaration:</b>
										<div class="decl">1.) WE declare that this invoice shows that Actual price of the goods describe and that all particulars are true and correct.</div>
										<div class="decl">2.) All disputes are subject to jamshedpur Jurisdiction.</div>
										<div class="decl">3.) THE CONSIGNOR IS LIABLE TO PAY THE SERVICE TAX.</div>
										<div class="decl">4.) IN CASE THE MATERIALS IN DAMAGED THE COMPENSATION WILL BE CHARGED FROM THE VEHICLE OWNER.</div>
										<div class="decl">5.) TWO POINT DELIVERY WITHIN MUNICIPAL LIMIT UP TO 5 K.M.</div>
									</td>
									<td style="width: 927px; ">
										<strong>For <?=$res->siteName?></strong>
										<p>&nbsp;</p>
										<p>Authorised Signatory</p>
									</td>
								</tr>
								<tr><td></td></tr>
                            </tbody>

                        </table>
					</div>

                </div>
            </div>

        </div>
    </div>
</div>




<?php $this->load->view('footer'); ?>
</body>
</html>
