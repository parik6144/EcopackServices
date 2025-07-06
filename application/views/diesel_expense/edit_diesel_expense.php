<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 14:52
 */
if(!isset($condition))
{
    $this->load->view('header');
    $this->load->view('left_sidebar');
    $this->load->view('topbar');

//var_dump($form_data['account']['0']['account_name']);
//exit;
?>
<link href="<?php echo base_url() ?>assets/css/select2.min.css" rel="stylesheet" />
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Diesel Expense</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Diesel expense Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('diesel_expense') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php 
            } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_diesel_expense">
                        <input type="hidden" value="<?=$this->input->get('id')?>" name="expense_id">
                        <div class="form-group  row"><label class="col-sm-2 control-label">Booking Date</label>
                            <div class="col-sm-10"><input type="date" class="form-control rec"  name="booking_date" value="<?=$form_data['diesel_expense']['0']['expense_date']?>" required></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Vehicle No</label>

                            <div class="col-sm-10">
                                <select class="form-control rec vehicle_no" name="vehicle_id" required>
                                    <option value="">Select Vehicle</option>
                                    <?php
                                    foreach ($vehicle as $row) {
                                        $str='';
                                        if($form_data['diesel_expense']['0']['vehicle_id']==$row['vehicle_inward_id'])
                                            $str="selected='selected'";
                                        echo "<option value='".$row['vehicle_inward_id']."' ".$str.">".$row['vehicle_inward_no']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Amount</label>

                            <div class="col-sm-10"><input type="number" class="form-control rec" value="<?=$form_data['diesel_expense']['0']['amount']?>" name="amount" required></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="submit" class="btn btn-success" id="">Save</button>
                    </form>
                </div>
                <?php
                if(!isset($condition)) {
                    ?>
            </div>
        </div>
    </div>
</div>
<?php

    $this->load->view('footer');
}
?>
<script src="<?php echo base_url() ?>assets/js/select2.min.js"></script>

<script type="text/javascript">
$('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format:'dd-mm-yyyy'
    });
    var lastid="";
    $(document).ready(function () {
        $('.vehicle_no').select2();
    });
</script>
</body>
</html>
