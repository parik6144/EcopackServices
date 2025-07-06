<?php
$this->load->view('header');
$this->load->view('left_sidebar');
$this->load->view('topbar');
//echo "<pre>";
//print_r($transport_consignments); exit;
// var_dump($form_data['account']['0']['account_name']);
 //exit;
?>

<link rel="stylesheet" href="https://harvesthq.github.io/chosen/chosen.css">
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
    </style>

<link href="<?php echo base_url() ?>assets/css/select2.min.css" rel="stylesheet" />
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h1>Transport Invoice</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"></li>
            </ol>
        </div>
        <div class="col-lg-2"></div>
    </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Consignment Records<small></small></h5>
                    <div class="ibox-tools">
                        <a href="#" onclick="history.back();">Go Back</a>
                    </div>
                </div>

                <form id="frm_consignment" method="POST" action="<?=base_url('Invoice/TransportCreateConsignmentInvoice')?>">
                    <input type="hidden" name="transport_invoice_rate_id" value="<?=$transport_invoice_rate_id?>">
                    <div class="ibox-content">
                        <div class="row">
                            <style>th{ text-align: center; } td { text-align: center; } </style>
                            <div class="col-sm-12">
<!--                                 <input type="hidden" value="--><?//=$consignee_billing_name?><!--" name="billing_address_id">-->
                                 <div class="table-responsive">
                                    <table class="table table-stripped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Sl. No</th>
                                            <th>Consignment No.</th>
                                            <th>Consignment Date</th>
                                            <th>Consignor Name</th>
                                            <th>Consignee Name</th>
                                            <th>Invoice Type</th>
                                            <th>Vehicle No</th>
                                            <th>Driver Name</th>
                                            <th>Consignment Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php  $billtype=["FTL","Part Load","Skip"]; $ctr=1; $total=0; foreach($transport_consignments as $row): ?>
                                        <tr>
                                        <td><?=$ctr?></td>
                                        <td>
                                            
                                            <?=$row['consignment_no']?></td>
                                        <td><?=date('d-M-Y',strtotime($row['consignment_date']))?></td>
                                        <td><?=$row['consignor_name']?></td>
                                        <td><?=$row['consignee_name']?></td>
                                        <td><?=$billtype[$row['bill_type']]?></td>
                                        <td><?=$row['vehicle_inward_no']?></td>
                                        <td><?=$row['driver_name']?></td>
                                        <?php if($row['consignment_status']=="0"){ ?>
                                        <td><span class="label label-danger">Pending</span></td>
                                        <?php } else { ?>
                                        <td><span class="label label-primary">Completed</span></td>
                                        <?php } ?>
                                        <td><input type='checkbox' name='consignment_id[]' value="<?=$row['consignment_id']?>"></td>
                                        </tr>
                                        <?php $ctr++; endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-info" id="">Save</button>
                                    <button type="button" class="btn btn-default">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view('footer'); ?>
</body>
</html>
