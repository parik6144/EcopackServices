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
.ibox-content {

    display: inline-block;
}
.seting-table > tbody > tr > th {
    font-size: 12px;
    font-weight: 500;
}
.seting-table > tbody > tr > td:first-child {
    font-size: 12px;
    font-weight: 500;
}
tr.scnd-tr>th>table>tbody>tr>td {
    padding: 0 3px;
    border: none;
    font-size: 12px;
}
tr.scnd-tr>th>table>tbody>tr:hover{
	background-color: rgba(0, 0, 0, 0);
}
.seting-table tbody tr > td > table > tbody > tr:hover{
	background-color: rgba(0, 0, 0, 0);
}
table tr table {
    margin: auto;
}
.table-bordered td, .table-bordered th {
    border: 0px solid #dee2e6;
}
.tabs-container .tabs-left > .nav-tabs > li > a, .tabs-container .tabs-right > .nav-tabs > li > a {
    margin-right: 0;
    margin-bottom: 3px;
    background: #00807426;
}
.tabs-container .tabs-left > .nav-tabs a.active, .tabs-container .tabs-left > .nav-tabs a.active:hover, .tabs-container .tabs-left > .nav-tabs a.active:focus {
    border-color: #e7eaec transparent #e7eaec #e7eaec;
    background: #fff;
}
</style>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>Access Module</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?=base_url()?>">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Access</strong>
                </li>
            </ol>
        </div>

        <div class="col-lg-4"></div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <?php if($this->session->flashdata('update')) {?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> <?=$this->session->flashdata('update')?>
                    </div>
                <?php } if($this->session->flashdata('error')) {?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> <?=$this->session->flashdata('error')?>
                    </div>
                <?php } ?>
                <div class="ibox float-e-margins">

                    <div class="ibox-content">
						<div class="tabs-container">
                            <div class="tabs-left">
                                <ul class="nav nav-tabs">
                                <?php  $i=1; foreach($catrecords as $res): ?>
                                   <li><a class="nav-link " data-toggle="tab" href="#tab-<?=$i?>"><?=$res->mcat_name?></a></li>
                                <?php $i++; endforeach; ?>
                                </ul>
                                <div class="tab-content ">
								<?php  $i=1; foreach($catrecords as $res): ?>
                                 <div id="tab-<?=$i?>" class="tab-pane">
                                    <div class="panel-body">
                                        <h3><?=$res->mcat_name?> Module-Access</h3>
										<div class="table-responsive">
											<table class="table  table-bordered seting-table">
												<tbody>
													<tr>
														<th class="text-center">Employee</th>

													</tr>

													<tr>
														<td class="text-center">Mohit Kumar</td>

														<td>
															<table>
																<tbody>
																<tr>
																	<td> <input type="checkbox" name="view_action[0][0]" value="1" checked=""></td>

																	<td> <input type="checkbox" name="add_action[0][0]" value="1"></td>
																</tr>
																</tbody>
															</table>

														</td>
														<td>
															<table>
																<tbody>
																<tr>
																	<td> <input type="checkbox" name="view_action[0][1]" value="1"></td>

																	<td> <input type="checkbox" name="add_action[0][1]" value="1"></td>
																</tr>
																</tbody>
															</table>

														</td>
														<td>
															<table>
																<tbody>
																<tr>
																	<td> <input type="checkbox" name="view_action[0][1]" value="1"></td>

																	<td> <input type="checkbox" name="add_action[0][1]" value="1"></td>
																</tr>
																</tbody>
															</table>

														</td>
														<td>
															<table>
																<tbody>
																<tr>
																	<td> <input type="checkbox" name="view_action[0][1]" value="1"></td>

																	<td> <input type="checkbox" name="add_action[0][1]" value="1"></td>
																</tr>
																</tbody>
															</table>

														</td>
														<td>
															<table>
																<tbody>
																<tr>
																	<td> <input type="checkbox" name="view_action[0][1]" value="1"></td>

																	<td> <input type="checkbox" name="add_action[0][1]" value="1"></td>
																</tr>
																</tbody>
															</table>

														</td>
														<td>
															<table>
																<tbody>
																<tr>
																	<td> <input type="checkbox" name="view_action[0][1]" value="1"></td>

																	<td> <input type="checkbox" name="add_action[0][1]" value="1"></td>
																</tr>
																</tbody>
															</table>

														</td>
														<td>
															<table>
																<tbody>
																<tr>
																	<td> <input type="checkbox" name="view_action[0][1]" value="1"></td>

																	<td> <input type="checkbox" name="add_action[0][1]" value="1"></td>
																</tr>
																</tbody>
															</table>

														</td>
														<td>
															<table>
																<tbody>
																<tr>
																	<td> <input type="checkbox" name="view_action[0][1]" value="1"></td>

																	<td> <input type="checkbox" name="add_action[0][1]" value="1"></td>
																</tr>
																</tbody>
															</table>

														</td>
														<td>
															<table>
																<tbody>
																<tr>
																	<td> <input type="checkbox" name="view_action[0][1]" value="1"></td>

																	<td> <input type="checkbox" name="add_action[0][1]" value="1"></td>
																</tr>
																</tbody>
															</table>

														</td>
													</tr>

												</tbody>
											</table>
										</div>
								   </div>
                                </div>
								<?php $i++; endforeach; ?>
                                 <div id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <h3>HR Module-Access</h3>
										<div class="table-responsive">
										<table class="table table-bordered seting-table">
											<tbody>
												<tr>
													<th>Roll</th>
													<th>PRODUCT ADMIN</th>
													<th>COMMUNITY ADMIN</th>
													<th>TENANT</th>
													<th>COMMUNITY STAFF</th>
													<th>MANAGING AGENT</th>
													<th>TRUSTEE</th>
													<th>OWNER</th>
													<th>SUB USERS</th>
													<th>PROPERTY AGENTS</th>
												</tr>
												<tr class="scnd-tr">
													<th></th>

													<th>
														<table>
														<tbody>
														<tr>
														<td>View</td>
														<td>Add</td>
														</tr>
                                                        </tbody>
                                                        </table>
													</th>

													<th>
														<table> <tbody><tr><td>View</td>
														<td>Add</td></tr> </tbody></table>
													</th>

													<th>
														<table> <tbody><tr><td>View</td>
														<td>Add</td></tr> </tbody></table>
													</th>

													<th>
														<table> <tbody><tr><td>View</td>
														<td>Add</td></tr> </tbody></table>
													</th>

													<th>
														<table> <tbody><tr><td>View</td>
														<td>Add</td></tr> </tbody></table>
													</th>

													<th>
														<table> <tbody><tr><td>View</td>
														<td>Add</td></tr> </tbody></table>
													</th>

													<th>
														<table> <tbody><tr><td>View</td>
														<td>Add</td></tr> </tbody></table>
													</th>

													<th>
														<table> <tbody><tr><td>View</td>
														<td>Add</td></tr> </tbody></table>
													</th>

													<th>
														<table> <tbody><tr><td>View</td>
														<td>Add</td></tr> </tbody></table>
													</th>

												</tr>


                                              <tr>
        <td>Mohit Kumar</td>
        <td>
            <table>
                <tbody>
                <tr>
                    <td> <input type="checkbox" name="view_action[0][0]" value="1" checked=""></td>

                    <td> <input type="checkbox" name="add_action[0][0]" value="1"></td>
                </tr>
                </tbody>
            </table>

        </td>
        <td>
            <table>
                <tbody>
                <tr>
                    <td> <input type="checkbox" name="view_action[0][1]" value="1"></td>

                    <td> <input type="checkbox" name="add_action[0][1]" value="1"></td>
                </tr>
                </tbody>
            </table>

        </td>
        <td>
            <table>
                <tbody>
                <tr>
                    <td> <input type="checkbox" name="view_action[0][1]" value="1"></td>

                    <td> <input type="checkbox" name="add_action[0][1]" value="1"></td>
                </tr>
                </tbody>
            </table>

        </td>
        <td>
            <table>
                <tbody>
                <tr>
                    <td> <input type="checkbox" name="view_action[0][1]" value="1"></td>

                    <td> <input type="checkbox" name="add_action[0][1]" value="1"></td>
                </tr>
                </tbody>
            </table>

        </td>
        <td>
            <table>
                <tbody>
                <tr>
                    <td> <input type="checkbox" name="view_action[0][1]" value="1"></td>

                    <td> <input type="checkbox" name="add_action[0][1]" value="1"></td>
                </tr>
                </tbody>
            </table>

        </td>
        <td>
            <table>
                <tbody>
                <tr>
                    <td> <input type="checkbox" name="view_action[0][1]" value="1"></td>

                    <td> <input type="checkbox" name="add_action[0][1]" value="1"></td>
                </tr>
                </tbody>
            </table>

        </td>
        <td>
            <table>
                <tbody>
                <tr>
                    <td> <input type="checkbox" name="view_action[0][1]" value="1"></td>

                    <td> <input type="checkbox" name="add_action[0][1]" value="1"></td>
                </tr>
                </tbody>
            </table>

        </td>
        <td>
            <table>
                <tbody>
                <tr>
                    <td> <input type="checkbox" name="view_action[0][1]" value="1"></td>

                    <td> <input type="checkbox" name="add_action[0][1]" value="1"></td>
                </tr>
                </tbody>
            </table>

        </td>
        <td>
            <table>
                <tbody>
                <tr>
                    <td> <input type="checkbox" name="view_action[0][1]" value="1"></td>

                    <td> <input type="checkbox" name="add_action[0][1]" value="1"></td>
                </tr>
                </tbody>
            </table>

        </td>
    </tr>

											</tbody>
										</table>
										</div>
								   </div>
                                </div>

                                </div>
                            </div>
                        </div>

                     </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



<?php $this->load->view('footer'); ?>