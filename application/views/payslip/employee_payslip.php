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
                        <a href="#" class="btn btn-primary" onclick='printDiv();'><i class="fa fa-print"></i> Print Payslip</a>
<!--                        <a href="#" class="btn btn-primary" onclick="window.history.back()"><i class="fa fa-backward"></i> Back</a>-->
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
                                table.tb-inner-2.tb-inner-tr tfoot tr th:first-child {width: 49%;}
                                table.tb-inner-2.tb-inner-tr thead tr th:last-child {text-align: right;}
                                table.tb-inner-2 tfoot tr th:nth-child(n+3) {text-align: right;}
                                .empryt{ text-align: right; } .emplft{ text-align: left; }
                             </style>

                                <div class="table-responsive t-bdr">
									<table class="table-head-wrap" style="width: 100%">
										<thead>
											<?php $res = $this->db->select('*')->from('sitedetails')->get()->row(); //  echo $this->db->last_query(); exit();  ?>
											<tr>
											<th class="text-center" colspan="12">
												<img src="<?=base_url('uploads/').$res->siteLogo?>" style="height: 60px; padding: 10px;">
												<h1 style="font-family: -webkit-body; font-size: 35px;"><?=$res->siteName?></h1>
												<p style="font-size: 18px; font-weight: 400;">
												<?=$res->address_1?>, <?=$res->address_2?>, <?=$res->area?>, <?=$res->city?>- <?=$res->pincode?>, Jharkhand<br>
												Phome : 0657-2280144, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E-mail : <?=$res->SiteEmail?>  <br>
												GSTIN : 20AAECE1697G1ZV, &nbsp;&nbsp;&nbsp;State-Code : <?=$res->statecode?></p>
											</th>
											</tr>
										</thead>
										<tbody class="tb">
											<?php
                                            // $query = $this->db->query("SELECT * FROM `payslip_details` WHERE `payslip_id`=$payslip_id");
                                            $query = $this->db->query("SELECT * FROM `payslip_details`
                                              join staff ON  payslip_details.staffID=staff.staff_id
                                              join employee_type ON employee_type.employee_type_id=staff.employee_type_id
                                              WHERE `payslip_id`=$payslip_id");
                                            //echo $this->db->last_query(); exit();
                                            $res = $query->row();
                                            $paying_basic_rate=$res->paying_basic_rate;
                                            $PayingDate='01-'.$res->payslip_month.'-'.$res->payslip_year;
                                            $PayingYear = $res->payslip_year;
                                            $PayingMonth = $res->payslip_month;
                                            //print_r($res); // exit();
                                            ?>
											<tr>
												<td class="text-center" colspan="12" style="text-align: center;">
												<h2 style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Payslip for <?php echo date('F Y', strtotime($PayingDate)); ?>
	                                            <!-- <span style="float: right;">Payslip No : -->  <?//=$payslip_id?><!--&nbsp;&nbsp;&nbsp;&nbsp;</span>-->
												</h2>
												</td>
											</tr>

											<tr>
												<td>
													<table class="tb-inner">
														<tbody>
															<tr>
																<td>Employee No :</td>
																<td><?=$res->emp_no?></td>
															</tr>
															<tr>
																<td>Department :</td>
																<td><?=$res->type_name?></td>
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
																<td><?=$res->staff_name?></td>
															</tr>
															<tr>
																<td>Designation :</td>
																<td></td>
															</tr>
															<tr>
																<td>Bank :</td>
																<td><?=$res->bank_name?></td>
															</tr>
															<tr>
																<td>Ifsc : </td>
																<td><?=$res->ifsc_code?></td>
															</tr>
															<tr>
																<td>Account :</td>
																<td><?=$res->account_no?></td>
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
																<td><?php if(!empty($res->paying_basic_rate)){ echo $res->paying_basic_rate; } else { echo "0.00"; } ?></td>
															</tr>

															<tr>
																<td>Dearness Allowance </td>
																<td><?php if(!empty($res->paying_da_rate)){ echo $res->paying_da_rate; } else { echo "0.00"; } ?></td>
															</tr>

															<tr>
																<td>Housing Rent Allowance</td>
						                                        <td><?php if(!empty($res->paying_hra_rate)){ echo $res->paying_hra_rate; } else { echo "0.00"; } ?></td>
															</tr>

															<tr>
																<td>Conveyance Allowance</td>
																<td><?php if(!empty($res->paying_cea_rate)){ echo $res->paying_cea_rate; } else { echo "0.00"; } ?></td>
															</tr>

															<tr>
															<td>Transport Allowance</td>
															<td><?php if(!empty($res->paying_tpa_rate)){ echo $res->paying_tpa_rate; } else { echo "0.00"; } ?></td>
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
																<td>Provident Fund </td>
																<td><?php if(!empty($res->pf_amt)){ echo $pf_amt=$res->pf_amt; } else { echo "0.00"; } ?></td>
															</tr>
															<tr>
																<td>ESIC</td>
																<td><?php if(!empty($res->esi_amt)){ echo $esi_amt=$res->esi_amt; } else { echo "0.00"; } ?></td>
															</tr>

															<tr>
																<td>Advance Salary Pay</td>
                                                                <?php
                                                                $query_adv = $this->db->query("SELECT *  FROM `tbl_advance_salary` WHERE `employee_id` = $emp_id AND `month_id` = $PayingMonth AND `year_id` = $PayingYear");
                                                                // echo $this->db->last_query(); exit();
                                                                $res_adv = $query_adv->row();
                                                                $advance_salary = $res_adv->advance_salary;
                                                                //print_r($res_adv);  exit();
                                                                ?>
																<?php if(!empty($advance_salary)){  $advance_salary; } else {  '0.00'; } ?>
																<td><?php if(!empty($res->advance_sal)){ echo $advance_sal=$res->advance_sal; } else { echo "0.00"; } ?></td>

															</tr>

															<tr>
																<td>Loan Payment</td>
																<td><?php if(!empty($res->loan_emi_amt)){ echo $loan_emi_amt=$res->loan_emi_amt; } else { echo "0.00"; } ?></td>
															</tr>

															<tr>
																<td>Leave Deductions</td>
																<td><?php if(!empty($res->leave_dedu_amt)){ echo $leave_dedu_amt=$res->leave_dedu_amt; } else { echo "0.00"; } ?></td>
																<?php $netDeduction = $pf_amt+$esi_amt+$advance_sal+$loan_emi_amt+$leave_dedu_amt; ?>
															</tr>

															 <tr><td></br></br></br></td></tr>

														</tbody>
														<tfoot>
															<tr>
																<th>Total Deductions (Rounded)</th>
																<th class="text-right"><?=$netDeduction?></th>
															</tr>
														</tfoot>
													</table>
												</td>
											</tr>
											<tr>
												<td colspan="12">
													<table class="tb-inner-2 tb-inner-tr">
														<tfoot>
															<tr>
																<th></th>
																<th>Net Pay (Rounded)</th>
																<th><?=$netPay-$netDeduction?></th>
															</tr>
														</tfoot>
													</table>
												</td>
											</tr>

											<tr>
												<td colspan="12">
													<table class="tb-inner-2 tb-inner-tr">
														<tfoot>
															<tr>
																<td><strong style="font-size: 15px; float: left;height:50px;">Employee Signature</strong></td>
																<td><strong style="font-size: 15px; float: right;height:50px;">Employer's Signature</strong></td>
															</tr>
														</tfoot>
													</table>
												</td>
											</tr>
										</tbody>
									</table>

                                </div>
								<h4 class="text-center" style="padding: 10px; text-align: center;"> This is system generated payslip, signature not required.</h4>
							<!-- /table-responsive -->
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