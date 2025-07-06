<?php
/**
 * Created by PhpStorm.
 * User: Amit Parik
 * Date: 16/08/2017
 * Time: 14:52
 */
$this->load->view('header');
$this->load->view('left_sidebar');
//$this->load->view('left_sidebar_access');
$this->load->view('topbar');
?>

    <style>
::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, .5);
    border-radius: 10px;
    border: 0px solid #ffffff;
}
.ibox-content {

    display: inline-block;
}
.table-responsive {

    max-height: 462px;
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
.tabs-container .tabs-left .tab-pane .panel-body, .tabs-container .tabs-right .tab-pane .panel-body {
    border-top: 1px solid #e7eaec;
	border-left: none;
}
.ibox-content {
    display: flow-root;
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

                                <div class="tab-content">
								<?php $i=1; foreach($catrecords as $res): ?>
                                <div id="tab-<?=$i?>" class="tab-pane <?php if($i==1){ echo 'active'; } ?>">
                                    <div class="panel-body">
                                        <h2><?=$res->mcat_name?> Module-Access</h2>
                                       <form action="<?=base_url('Setting/add_access_module')?>" method="post">
                                        <button type="submit" name="module_submit" class="btn btn-primary pull-right" style="margin-top: -17px;"><?=$res->mcat_name?> Module Update</button></h3>
										<div class="table-responsive">
											<table class="table table-bordered seting-table">
												<tbody>
													<tr>
                                                        <th class="text-center"><h3>SL</h3></th>
														<th class="text-center"><h3>Employee</h3></th>
                                                        <?php
                                                        $query=$this->db->select('`msubcat_id`, `mcat_id`, `msub_cat_name`')
                                                        ->from('tbl_module_subcat')
                                                        ->where('mcat_id',$res->mcat_id)->get();
                                                        $record = $query->result();
                                                        // var_dump($record);
                                                        foreach($record as $rec): ?>
                                                         <th class="text-center"><h3><?=$rec->msub_cat_name?></h3></th>
                                                        <?php endforeach; ?>
													</tr>

													<tr class="scnd-tr">
														<th class="text-center"></th>
                                                        <th class="text-center"></th>
                                                        <?php foreach($record as $rec1): ?>
														<th>
															<table><tbody><tr>
															<td class="text-center"></td>
															<td class="text-center">View</td>
															<td class="text-center">Add</td>
															<td class="text-center">Delete</td>
															</tr></tbody></table>
														</th>
                                                        <?php endforeach; ?>
													</tr>

                                                    <?php $e=1; foreach($staffrecords as $emp):  ?>
                                                        
													<tr>
														<td class="text-center"><?=$e?></td>
														<td class="text-center"><?=$emp->full_name?></td>
                                                        <?php foreach($record as $rec2):
                                                         $query1=$this->db->select('*')
                                                         ->from('tbl_access_module')
                                                         ->where('emp_id',$emp->user_id)
                                                         ->where('mcat_id', $res->mcat_id)
                                                         ->where('msubcat_id', $rec2->msubcat_id)
                                                         ->get();
                                                         $query1=$query1->row();
                                                         ?>
        													<td>
                                                                <table>
                                                                <tbody>
                                                                <tr>
                                                                <input type="hidden" name="emp_id[]" value="<?=$emp->user_id?>">
                                                                <input type="hidden" name="mcat_id[]" value="<?=$res->mcat_id?>">
                                                                <input type="hidden" name="msubcat_id[]" value="<?=$rec2->msubcat_id?>">
                                                                <td> <input type="checkbox" name="is_view[<?=$emp->user_id?>][<?=$res->mcat_id?>][<?=$rec2->msubcat_id?>]" <?php if($query1->is_view==1){?> checked="checked" <?php } ?> value="1"></td>
                                                                <td> <input type="checkbox" name="is_add[<?=$emp->user_id?>][<?=$res->mcat_id?>][<?=$rec2->msubcat_id?>]" <?php if($query1->is_edit==1){?> checked="checked" <?php } ?> value="1"></td>
                                                                <td> <input type="checkbox" name="is_delete[<?=$emp->user_id?>][<?=$res->mcat_id?>][<?=$rec2->msubcat_id?>]" <?php if($query1->is_delete==1){?> checked="checked" <?php } ?> value="1"></td>
                                                                </tr>
                                                                </tbody>
                                                                </table>
                                                            </td>
                                                        <?php endforeach; ?>
													</tr>
                                                    <?php $e++; endforeach;  ?>
                                                    </form>
												</tbody>
											</table>
										</div>
								   </div>
                                </div>
								<?php $i++; endforeach; ?>

                                </div>

                            </div>
                        </div>

                     </div>

                    </div>
                </div>
            </div>
        </div>

<?php $this->load->view('footer'); ?>