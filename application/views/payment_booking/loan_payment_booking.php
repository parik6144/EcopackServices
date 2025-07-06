<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 14:52
 */

// echo $booking_date; exit;
if(!isset($condition)) {
    $this->load->view('header');
    $this->load->view('left_sidebar');
    $this->load->view('topbar');
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Loan</h2>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Loan Booking Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('payment_booking') ?>"><i class="fa fa-angle-left"></i>Back</a></span>
                </div>
                <?php } ?>

                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_payment_booking" action="<?php echo site_url('payment_booking/add') ?>">

                        <div class="form-group  row"><label class="col-sm-2 control-label">Amount</label>
                            <div class="col-sm-10">
                                <input type="text" name="booking_date" class="form-control " value="<?=date("Y-m-d");?>">
                                <input type="text" class="form-control rec" value="<?=$form_data['loan']['0']['monthly_emi']?>" name="amount">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row" ><label class="col-sm-2 control-label">Expense Head</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control "  name="loan_id" value="<?=$loan_id?>">
                                <input type="text" class="form-control expense_head"  name="expense_head" value="15">
                                <input type="text" value="0" name="is_tds">
                            </div>
                        </div>

                        <div class="form-group  row" ><label class="col-sm-2 control-label">Receiver Type</label>
                            <div class="col-sm-10">
                                <select class="form-control rec" id="receiver_type"  name="receiver_type">
                                    <option value="">Select Receiver Type</option>
                                    <option value="2" selected='selected'>Other Party</option>                                    
                                </select>

                            </div>
                        </div>

                        <input type="number" class="form-control rec taxable_value" value="0" name="taxable_value">
                        <input type="number" class="form-control rec purchase_tax" value="0"  name="purchase_tax">
                       
                        <?php
                        $currentMonth = date('F');
                        $monthname= Date('F', strtotime($currentMonth . " last month"));
                        $loan_date = $loan_date;
                        $arr=explode("-", $loan_date);
                        if($arr['1']=="1")
                            $prevmonth="12";
                        else
                            $prevmonth=$arr['1']-1;
                        ?>

                        <input type="text" name="remarks" value="Interest on loan from <?=$booking_date. ' to '.$arr['0'].'-'.$arr['1'].'-'.$arr['2']?>">
                        <div class="form-group  row account_name select_user " ><label class="col-sm-2 control-label">Party Name</label>
                            <div class="col-sm-10">
                                <input class="form-control"  name="account_id" value="<?=$form_data['loan']['0']['account_id']?>">
                            </div>
                        </div>

                        <input type="hidden" name="payment_date" value="<?=$loan_date?>">
                        <button type="button" id="btn_save" class="btn btn-success">Save</button>
                        <?php //exit(); ?>
                    </form>
                </div>
                <?php if(!isset($condition)) { ?>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('footer'); } ?>

<script type="text/javascript">
$(document).ready(function () {
        $("form").submit();
    });
</script>

</body>
</html>
