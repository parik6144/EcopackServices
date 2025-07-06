<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 14:52
 */
if(!isset($condition)) {
    $this->load->view('header');
    $this->load->view('left_sidebar');
    $this->load->view('topbar');

?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Account</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Account Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('account') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_orderno">
                        <input type="hidden" value="<?php echo $this->input->get('id'); ?>" name="orderno_id">
                        
                        <div class="form-group  row"><label class="col-sm-2 control-label">Consignee Name</label>

                            <div class="col-sm-10">
                                <select class="form-control rec" name="consignee_id">
                                    <option value="">Select Consignee</option>
                                    <?php
                                        foreach ($consignee as $row) {
                                            $str="";
                                            if($row['consignee_id']==$form_data['order_no']['0']['consignee_id'])
                                                $str="selected='selected'";
                                            ?>
                                            <option value="<?=$row['consignee_id']?>" <?=$str?>><?=$row['consignee_name']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Invoice Type</label>

                            <div class="col-sm-10">
                                <select class="form-control rec" name="invoice_type_id">
                                    <option value="">Select Invoice Type</option>
                                    <?php
                                        foreach ($invoicetype as $row) {
                                            $str="";
                                            if($row['category_id']==$form_data['order_no']['0']['invoice_type_id'])
                                                $str="selected='selected'";
                                            ?>
                                            <option value="<?=$row['category_id']?>" <?=$str?>><?=$row['category_name']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Order No.</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?=$form_data['order_no']['0']['order_no']?>" name="order_no">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Vendor Code</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?=$form_data['order_no']['0']['vendor_code']?>" name="vendor_code">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="button" id="btn_save" class="btn btn-success">Save</button>
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

<script type="text/javascript">
    $("#btn_save").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('orderno/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_orderno").serialize(),
                success: function (data) {
                    //alert("Record Saved Successfully");
                    $("#frm_orderno")[0].reset();
                    $('#ordernoModal').modal('hide');
                },
                error: function (data) {
                    // alert("error");
                },
                timeout: 5000,
                error: function(jqXHR, textStatus, errorThrown) {
                    swal("","Please check your internet connection.","error");
                },
             beforeSend: function() {
                 $('#loader').show();
              },
              complete: function(){
                 $('#loader').hide();
              }
            });
        }
    });
</script>
</body>
</html>
