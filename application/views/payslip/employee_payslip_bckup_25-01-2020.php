<?php
// print_r($emp);  exit();
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
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2>Payslip</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?=base_url()?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Payslip</strong>
                        </li>
                    </ol>
                </div>

                <div class="col-lg-4">
                    <div class="title-action">
                        <a href="#" class="btn btn-primary" onclick='printDiv();'><i class="fa fa-print"></i> Print Payslip </a>
                    </div>
                </div>
            </div>

			 <div class="row">
                <div class="col-lg-12">
                    <div class="wrapper wrapper-content animated fadeInRight">
						<div class="ibox-content p-xl" id='DivIdToPrint'>
							<style>
                                .tb .text-center{font-size: 18px;text-transform: capitalize;color: #1ab394;}
                                .t-bdr{border: 1px solid;}
                                .tb-inner{ width: 100%;margin-top: 1rem;margin-bottom: 1rem;}
                                table.tb-inner td { font-size: 15px !important;padding: 3px 10px;}
                                table.tb-inner-2 { width: 100%;border-spacing: 0 !important;border-collapse: collapse; border-right: 0px solid #ddd;/* padding: 10px !important; */}
                                table.tb-inner-2 thead tr th { padding: 3px 10px;font-size: 16px;}
                                table.tb-inner-2 thead tr th:first-child {width: 60%;}
                                table.tb-inner-2 thead tr th:nth-child(n+2) {text-align: right;}
                                table.tb-inner-2 thead tr th:nth-child(n+3) {text-align: right;}
                                table.tb-inner-2 thead tr {border: 0px solid;border-spacing: 0 !important;border-top: 1px solid; border-bottom: 1px solid;}
                                table.tb-inner-2 tbody tr td {font-size: 15px;padding: 3px 10px;}
                                table.tb-inner-2 tbody tr td:nth-child(n+2) {text-align: right;}
                                table.tb-inner-2 tbody tr td:nth-child(n+3) {text-align: right;}
                                table.tb-inner-2 tfoot tr th {padding: 3px 10px;font-size: 16px;}
                                table.tb-inner-2 tfoot tr {border: 0px solid;border-spacing: 0 !important;border-top: 1px solid;;}
                                table.tb-inner-2.tb-inner-tr tfoot tr th:first-child {width: 50%;}
                                table.tb-inner-2.tb-inner-tr thead tr th:last-child {text-align: right;}
                                table.tb-inner-2 tfoot tr th:nth-child(n+3) {text-align: right;}
                             </style>

                                <div class="table-responsive t-bdr">
								<table class="table-head-wrap" style="width: 100%">
									<thead>
										<?php $res = $this->db->select('*')->from('sitedetails')->get()->row(); ?>
										<tr>
                                        <th class="text-center" colspan="12">
                                            <img src="<?=base_url('uploads/').$res->siteLogo?>" style="height: 60px; padding: 10px;">
                                            <h1 style="font-family: -webkit-body; font-size: 35px;"><?=$res->siteName?></h1>
                                            <p style="font-size: 18px; font-weight: 400;">
                                            <?=$res->address_1?>, <?=$res->address_2?>, <?=$res->area?>, <?=$res->city?>- <?=$res->pincode?>, Jharkhand<br>
                                            Mobile : <?=$res->mobile?>,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E-mail : <?=$res->SiteEmail?>  <br>
                                            GSTIN : <?=$res->gstin?>,&nbsp;&nbsp;&nbsp;State-Code : <?=$res->statecode?></p>
                                        </th>
										</tr>
									</thead>
									<tbody class="tb">
                                        <?php
                                        $query= $this->db->query("SELECT * FROM `payslip_details` WHERE `payslip_id`=$payslip_id");
                                        //echo $this->db->last_query(); exit();
                                        $res = $query->row();
                                        $paying_basic_rate=$res->paying_basic_rate;
                                        $PayingDate='01-'.$res->payslip_month.'-'.$res->payslip_year;
                                        //print_r($res);
                                        ?>
										<tr>
											<td class="text-center" colspan="12" style="text-align: center;">
											<h2 style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Payslip for <?php echo date('F Y', strtotime($PayingDate)); ?>
<!--											<span style="float: right;">Payslip No : --><?//=$payslip_id?><!--&nbsp;&nbsp;&nbsp;&nbsp;</span>-->
											</h2>
											</td>
										</tr>

										<tr>
											<td>
												<table class="tb-inner">
													<tbody>
														<tr>
															<td>Employee ID :</td>
															<td><?=$emp_no?></td>
														</tr>
														<tr>
															<td>Department :</td>
															<td><?=$type_name?></td>
														</tr>
														<tr>
															<td>Days Worked :</td>
															<td><?=$res->paying_days?></td>
														</tr>
														<tr>
															<td>Casual Leave :</td>
															<td><?=$res->casual_leave?></td>
														</tr>
														<tr>
															<td>Overtime Hours :</td>
															<td><?=$res->paying_ot_hrs?></td>
														</tr>
													</tbody>
												</table>
											</td>
											<td>
												<table class="tb-inner">
													<tbody>
														<tr>
															<td>Employee Name :</td>
															<td><?=$staff_name?></td>
														</tr>
														<tr>
															<td>Designation :</td>
															<td></td>
														</tr>
														<tr>
															<td>Bank/Ifsc :</td>
															<td><?=$bank_name?> / <?=$ifsc_code?></td>
														</tr>
														<tr>
															<td>Account :</td>
															<td><?=$account_no?></td>
														</tr>
														
													</tbody>
												</table>
											</td>
										</tr>
										
										<tr>
											<td style="border-right: 1px solid;">
												<table class="tb-inner-2">
													<thead>
														<tr>
															<th>Earnings</th>
															<th>Amount</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>Basic Pay</td>
															<td><?=$paying_basic_rate?></td>
														</tr>

														<tr>
															<td>Medical Allowance</td>
															<td><?=$res->paying_da_rate?></td>
														</tr>

														<tr>
															<td>Housing Rent Allowance</td>
															<td><?=$res->paying_hra_rate?></td>
														</tr>

														<tr>
															<td>Conveyance Allowance</td>
															<td><?=$res->paying_cea_rate?></td>
														</tr>

                                                        <tr>
                                                        <td>TPA Allowance</td>
                                                        <td><?=$res->paying_tpa_rate?></td>
                                                        </tr>

                                                       <tr><td></br></br></br></td></tr>
													</tbody>

													<tfoot>
                                                    <tr>
                                                        <th>Total Earnings (Rounded)</th>
                                                        <th class="text-right"><?=$netPay=$paying_basic_rate+$res->paying_da_rate+$res->paying_hra_rate+$res->paying_cea_rate+$res->paying_tpa_rate?></th>
                                                    </tr>
													<tfoot>
												</table>
											</td>

											<td>
												<table class="tb-inner-2">
													<thead>
														<tr>
															<th>Deductions</th>
															<th class="text-right">Amount</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>PF & ESI</td>
															<td><?=$pf=($paying_basic_rate*10/100)?></td>
														</tr>
														<tr>
															<td>Tax</td>
															<td><?=$tax=($paying_basic_rate*18/100)?></td>
														</tr>
														
														<tr>
															<td>Advance Pay</td>
															<td><?=$adv=1500?></td>
														</tr>

														<tr>
														<td><?php $netDeduction=$pf+$tax+$adv; ?></td>
														<td></td>
														</tr>

														<tr><td></br></br></br></br></br></br></td></tr>
													</tbody>
													<tfoot>
														<tr>
															<th>Total Deductions (Rounded)</th>
															<th class="text-right"><?=$netDeduction?></th>
														</tr>
													<tfoot>
												</table>
											</td>
										</tr>
										<tr>
											<table class="tb-inner-2 tb-inner-tr">
												<tfoot>
													<tr>
														<th colspan=""></th>
														<th>Net Pay (Rounded)</th>
														<th><?=$netPay-$netDeduction?></th>
													</tr>
												</tfoot>
											</table>
										</tr>
									</tbody>
								</table>
								<table class="table invoice-table">
									<tbody>
										<tr rowspan="3"></tr></br>
										<tr>
											<td><strong style="font-size: 15px;">Employee Signature</strong></br></br></br></td>
											<td><strong>Employer's Signature</strong></br></br></br></td>
										</tr>
									</tbody>
								</table>
							</div><!-- /table-responsive -->
						</div>
					</div>
				</div>
			</div>


               <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8"></div>

                <div class="col-lg-4">
                    <div class="title-action">
                        <a href="#" class="btn btn-primary" onclick='printDiv();'><i class="fa fa-print"></i> Print Payslip </a>
                    </div>
                </div>
            </div> </br></br>

            <script>
            function printDiv()
            {
                var divToPrint=document.getElementById('DivIdToPrint');
                var newWin=window.open('','Print-Window');
                newWin.document.open();
                newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
                newWin.document.close();
                setTimeout(function(){newWin.close();},10);
            }
           </script>

<?php $this->load->view('footer'); ?>