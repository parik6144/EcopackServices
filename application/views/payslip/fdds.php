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
                        <a href="#" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Payslip </a>
                    </div>
                </div>
            </div>
			<style>
			
			.tb .text-center{font-size: 18px;text-transform: capitalize;color: #1ab394;}
			.t-bdr{border: 1px solid;}
			.tb-inner{width: 100%;margin-top: 1rem;margin-bottom: 1rem;}
			table.tb-inner td {font-size: 15px !important;padding: 5px 10px;}
			table.tb-inner-2 {width: 100%;border-spacing: 0 !important;border-collapse: collapse;border-right: 0px solid #ddd;/* padding: 10px !important; */}

			table.tb-inner-2 thead tr th {padding: 3px 10px;font-size: 16px;}

			table.tb-inner-2 thead tr th:first-child {width: 60%;}
			table.tb-inner-2 thead tr th:nth-child(n+2) {text-align: right;}
			table.tb-inner-2 thead tr th:nth-child(n+3) {text-align: right;}
			table.tb-inner-2 thead tr {border: 0px solid;border-spacing: 0 !important;border-top: 1px solid; border-bottom: 1px solid;}
			table.tb-inner-2 tbody tr td {font-size: 15px;padding: 5px 10px;}
			table.tb-inner-2 tbody tr td:nth-child(n+2) {text-align: right;}
			table.tb-inner-2 tbody tr td:nth-child(n+3) {text-align: right;}
			table.tb-inner-2 tfoot tr th {padding: 3px 10px;font-size: 16px;}

			table.tb-inner-2 tfoot tr {border: 0px solid;border-spacing: 0 !important;border-top: 1px solid;;}
			table.tb-inner-2.tb-inner-tr tfoot tr th:first-child {width: 50%;}
			table.tb-inner-2.tb-inner-tr thead tr th:last-child {text-align: right;}
			
			table.tb-inner-2 tfoot tr th:nth-child(n+3) {text-align: right;}
			</style>
			 <div class="row">
                <div class="col-lg-12">
                    <div class="wrapper wrapper-content animated fadeInRight">
						<div class="ibox-content p-xl">
							<div class="table-responsive t-bdr">
							
								<table class="table-head-wrap" style="width: 100%">
									<thead>
										<?php $res = $this->db->select('*')->from('sitedetails')->get()->row(); ?>
										<tr>
											<th><img src="<?=base_url('uploads/').$res->siteLogo?>" style="width: 120px;"></th>
											<th class="text-center">
												<h1 style="font-family: -webkit-body; font-size: 35px;"><?=$res->siteName?></h1>
												<p style="font-size: 18px; font-weight: 400;">
												<?=$res->address_1?>, <?=$res->address_2?>, <?=$res->area?>, <?=$res->city?>- <?=$res->pincode?>, Jharkhand<br>
												Mobile : <?=$res->mobile?>,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E-mail : <?=$res->SiteEmail?>  <br>
												GSTIN : <?=$res->gstin?>,&nbsp;&nbsp;&nbsp;State-Code : <?=$res->statecode?></p>
											</th>
											<th></th>
										</tr>
									</thead>
									<tbody class="tb">
										<tr>
											<td class="text-center" colspan="12">payslip for the periode of may 2019</td>
										</tr>
										<tr>
											<td>
												<table class="tb-inner">
													<tbody>
														<tr>
															<td>Employee ID</td>
															<td>11001</td>
														</tr>
														<tr>
															<td>Department</td>
															<td>Information Technology</td>
														</tr>
														<tr>
															<td>Department</td>
															<td>Information Technology</td>
														</tr>
														<tr>
															<td>Department</td>
															<td>Information Technology</td>
														</tr>
														
													</tbody>
												</table>
											</td>
											<td>
												<table class="tb-inner">
													<tbody>
														<tr>
															<td>Employee ID</td>
															<td>11001</td>
														</tr>
														<tr>
															<td>Department</td>
															<td>Information Technology</td>
														</tr>
														<tr>
															<td>Department</td>
															<td>Information Technology</td>
														</tr>
														<tr>
															<td>Department</td>
															<td>Information Technology</td>
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
															<th>Ernings</th>
															<th>YTD</th>
															<th>Amount</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>Employee ID</td>
															<td>1000.00</td>
															<td>11001</td>
														</tr>
														<tr>
															<td>Department</td>
															<td>1000.00</td>
															<td>1230.00</td>
														</tr>
														<tr>
															<td>Department</td>
															<td>2000.00</td>
															<td>1012.00</td>
														</tr>
														<tr>
															<td>Department</td>
															<td>1200.00</td>
															<td>1510.00</td>
														</tr>
														
													</tbody>
													<tfoot>
														<tr>
															<th>Ernings</th>
															<th>YTD</th>
															<th>Amount</th>
														</tr>
													<tfoot>
												</table>
											</td>
											<td>
												<table class="tb-inner-2">
													<thead>
														<tr>
															<th>Deductions</th>
															<th>YTD</th>
															<th>Amount</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>Employee ID</td>
															<td>1000.00</td>
															<td>11001</td>
														</tr>
														<tr>
															<td>Department</td>
															<td>1000.00</td>
															<td>1230.00</td>
														</tr>
														<tr>
															<td>Department</td>
															<td>2000.00</td>
															<td>1012.00</td>
														</tr>
														<tr>
															<td>Department</td>
															<td>1200.00</td>
															<td>1510.00</td>
														</tr>
														
													</tbody>
													<tfoot>
														<tr>
															<th>Deductions</th>
															<th>YTD</th>
															<th>Amount</th>
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
														<th>23490.00</th>
													</tr>
												</tfoot>
											</table>
											
										</tr>
										
									</tbody>
								</table>
								<table class="table invoice-table">
									<tbody>
										<tr rowspan="3"></tr>
										<tr>
											<td><div><strong>Employee Signature</strong></div></td>
											<td><div><strong>Employee Signature</strong></div></td>
										</tr>
									</tbody>
								</table>
							</div><!-- /table-responsive -->
						</div>
					</div>
				</div>
			</div>
       
            </br></br>

<?php $this->load->view('footer'); ?>