<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 14:52
 */
$this->load->model('mdl_account');
if(!isset($condition)) {
    $this->load->view('header');
    $this->load->view('left_sidebar');
    $this->load->view('topbar');

//var_dump($form_data['account']['0']['account_name']);
//exit;
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
                    <form method="POST" class="form-horizontal" id="frm_account">
                        <input type="hidden" value="<?php echo $this->input->get('id'); ?>" name="account_id">
                        <div class="form-group  row"><label class="col-sm-2 control-label">Account Name</label>

                            <div class="col-sm-10"><input type="text" class="form-control rec" value="<?php if(isset($form_data['account']['0']['account_name'])) echo $form_data['account']['0']['account_name'];?>" name="account_name"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10"><input type="tel" class="form-control" name="email" value="<?php if(isset($form_data['account']['0']['email'])) echo $form_data['account']['0']['email'];?>"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Mobile</label>
                            <div class="col-sm-10"><input type="tel" class="form-control" name="mobile" value="<?php if(isset($form_data['account']['0']['mobile'])) echo $form_data['account']['0']['mobile'];?>"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Mobile 2</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="mobile2" value="<?php if(isset($form_data['account']['0']['mobile2'])) echo $form_data['account']['0']['mobile2'];?>"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="phone" value="<?php if(isset($form_data['account']['0']['phone'])) echo $form_data['account']['0']['phone'];?>"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-2 control-label">Phone 2</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="phone2" value="<?php if(isset($form_data['account']['0']['phone2'])) echo $form_data['account']['0']['phone2'];?>"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Account type</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="account_type" value="<?php if(isset($form_data['account']['0']['account_type'])) echo $form_data['account']['0']['account_type'];?>"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <?php
                            if(isset($form_data['address']))
                            for($i=0;$i<sizeof($form_data['address']);$i++) {
                                if(isset($form_data['address'][$i])) {
                                    ?>
                                    <div id="extra_address">
                                        <div class="form-group  row"><label class="col-sm-2 control-label">Address
                                                Type</label>
                                            <div class="col-sm-10"><input type="text" class="form-control"
                                                                          name="address_type[]"
                                                                          value="<?php echo $form_data['address'][$i]['address_type']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group  row"><label class="col-sm-2 control-label">Address line
                                                1</label>
                                            <div class="col-sm-10"><input type="text" class="form-control rec"
                                                                          name="address_line_1[]"
                                                                          value="<?php echo $form_data['address'][$i]['address_line1']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group  row"><label class="col-sm-2 control-label">Address line
                                                2</label>

                                            <div class="col-sm-10"><input type="text" class="form-control"
                                                                          name="address_line_2[]"
                                                                          value="<?php echo $form_data['address'][$i]['address_line2']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group  row"><label class="col-sm-2 control-label">Country</label>

                                            <div class="col-sm-10"><select class="form-control country rec" name="country[]"
                                                                           id="country">
                                                    <option value="">Select Country</option>
                                                    <?php
                                                    foreach ($country as $row)
                                                        if ($form_data['address'][$i]['country_id'] == $row['country_id'])
                                                            echo "<option value='" . $row['country_id'] . "' selected='selected'>" . $row['country_name'] . "</option>";
                                                        else
                                                            echo "<option value='" . $row['country_id'] . "'>" . $row['country_name'] . "</option>";
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group  row"><label class="col-sm-2 control-label">State</label>
                                            <div class="col-sm-10"><select class="form-control state rec" name="state[]"
                                                                           id="state">
                                                    <option value="">Select State</option>
                                                    <?php
                                                    if(!empty($form_data['address'][$i]['country_id']))
                                                    {
                                                        $state=$this->mdl_account->getstate($form_data['address'][$i]['country_id']);
                                                        if(sizeof($state)>0)
                                                        {
                                                            foreach ($state as $row)
                                                            {
                                                                if ($form_data['address'][$i]['state_id'] == $row['state_id'])
                                                                    echo "<option value='" . $row['state_id'] . "' selected='selected'>" . $row['state_name'] . "</option>";
                                                                else
                                                                    echo "<option value='" . $row['state_id'] . "'>" . $row['state_name'] . "</option>";
                                                            }
                                                        }
                                                    }


                                                    ?>
                                                </select></div>
                                        </div>
                                        <div class="form-group  row"><label class="col-sm-2 control-label">City</label>
                                            <div class="col-sm-10"><select class="form-control city rec" name="city[]"
                                                                           id="city">
                                                    <option value="">Select City</option>
                                                    <?php
                                                    if(!empty($form_data['address'][$i]['state_id']))
                                                    {
                                                        $state=$this->mdl_account->getcity($form_data['address'][$i]['state_id']);
                                                        if(sizeof($state)>0)
                                                        {
                                                            foreach ($state as $row)
                                                            {
                                                                if ($form_data['address'][$i]['city_id'] == $row['city_id'])
                                                                    echo "<option value='" . $row['city_id'] . "' selected='selected'>" . $row['city_name'] . "</option>";
                                                                else
                                                                    echo "<option value='" . $row['city_id'] . "'>" . $row['city_name'] . "</option>";
                                                            }
                                                        }
                                                    }


                                                    ?>
                                                </select></div>
                                        </div>
                                        <div class="form-group  row"><label class="col-sm-2 control-label">Zip Code</label>
                                            <div class="col-sm-10"><input type="number" class="form-control"
                                                                          name="zip_code"></div>
                                        </div>
                                        <div style="width: 100%;height: 40px">
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-danger" id="removeaddress">Remove Address</button>
                                            </div>
                                        </div>

                                    </div>
                                    <?php
                                }
                            }
                        ?>

                        <div id="address_div"></div>
                        <div>
                            <div class="pull-right">
                                <button type="button" class="btn btn-success" id="add_more_address">Add More Address</button>
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
    var countrystring="";
    $(document).ready(function () {
        countrystring=$("#country").html();
    });
    $(document).on('change',".country",function () {
        var countryid=$(this).val();
        var ref=$(this);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('account/getstate')?>',
            cache: false,
            async: false,
            data: {countryid: countryid},
            success: function (data) {
                var state=JSON.parse(data);
                var str='<option value="">Select State</option>';
                $.each(state,function (k,v) {
                    str+='<option value="'+v['state_id']+'">'+v['state_name']+'</option>';
                });
                ref.parent().parent().parent().find(".state").html(str);
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
    });
    $(document).on('change',".state",function () {
        var stateid=$(this).val();
        var ref=$(this);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('account/getcity')?>',
            cache: false,
            async: false,
            data: {stateid: stateid},
            success: function (data) {
                var state=JSON.parse(data);
                var str='<option value="">Select City</option>';
                $.each(state,function (k,v) {
                    str+='<option value="'+v['city_id']+'">'+v['city_name']+'</option>';
                });
                ref.parent().parent().parent().find(".city").html(str);
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
    });
    $("#add_more_address").click(function () {
        //var countrystring=$("#country").html();
        var myvar = '<div class="extra_address"><div class="form-group  row"><label class="col-sm-2 control-label">Address Type</label>'+
            '                                <div class="col-sm-10"><input type="text" class="form-control" name="address_type[]"></div>'+
            '                            </div>'+
            '                            <div class="form-group  row"><label class="col-sm-2 control-label">Address line 1</label>'+
            '                                <div class="col-sm-10"><input type="text" class="form-control" name="address_line_1[]"></div>'+
            '                            </div>'+
            '                            <div class="form-group  row"><label class="col-sm-2 control-label">Address line 2</label>'+
            ''+
            '                                <div class="col-sm-10"><input type="text" class="form-control" name="address_line_2[]"></div>'+
            '                            </div>'+
            '                            <div class="form-group  row"><label class="col-sm-2 control-label">Country</label>'+
            ''+
            '                                <div class="col-sm-10"><select  class="form-control country" name="country[]" id="country">'+
            +''+countrystring+''+
            '                                    </select>'+
            '                                </div>'+
            '                            </div>'+
            '                            <div class="form-group  row"><label class="col-sm-2 control-label">State</label>'+
            '                                <div class="col-sm-10"><select class="form-control state" name="state[]" id="state"></select></div>'+
            '                            </div>'+
            '                            <div class="form-group  row"><label class="col-sm-2 control-label">City</label>'+
            '                                <div class="col-sm-10"><select class="form-control city" name="city[]" id="city"></select></div>'+
            '                            </div>'+
            '                            <div class="form-group  row"><label class="col-sm-2 control-label">Zip Code</label>'+
            '                                <div class="col-sm-10"><input type="number" class="form-control" name="zip_code"></div>'+
            '                            </div>'+
            '<div style="width: 100%;height: 40px"><div class="pull-right"><button type="button" class="btn btn-danger" id="removeaddress">Remove Address</button></div></div></div>';
        $("#address_div").append(myvar);


    });
    $(document).on("click","#removeaddress",function () {
        $(this).parent().parent().parent().remove();
    });
    $("#btn_save").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('account/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_account").serialize(),
                success: function (data) {
                    alert("Record Saved Successfully");
                    $("#frm_account")[0].reset();
                    $("#extra_address").remove();
                    $('#myModal').modal('hide');
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
