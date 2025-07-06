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

//var_dump($form_data['warehouse']['0']['warehouse_name']);
//exit;
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>warehouse</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>warehouse Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('rentwarehouse') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_rent_warehouse">
                        <input type="hidden" name="rent_warehouse_id" value="<?=encryptor("encrypt",$form_data['rent_warehouse']['0']['rent_warehouse_id']);?>">
                        
                        <div class="form-group  row"><label class="col-sm-3 control-label">Consignee Name</label>
                            <div class="col-sm-9">
                                <select name="consignee_id" class="form-control">
                                    <option value="">Select Consignee</option>
                                    <?php
                                        foreach ($consignee as $row) {
                                            $str="";
                                            if($row['consignee_id']==$form_data['rent_warehouse']['0']['consignee_id'])
                                                $str="selected='selected'";
                                            echo "<option value='".$row['consignee_id']."' ".$str.">".$row['consignee_name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                       <div class="hr-line-dashed"></div>
                       <div class="form-group  row"><label class="col-sm-3 control-label">Rent per Sq.Ft</label>
                            <div class="col-sm-9"><input type="text" class="form-control"  name="price" value="<?=$form_data['rent_warehouse']['0']['price']?>"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Rent warehouse Area</label>
                            <div class="col-sm-9"><input type="text" class="form-control rec"  name="rent_warehouse_area" value="<?=$form_data['rent_warehouse']['0']['rent_warehouse_area']?>"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="button" class="btn btn-success" id="btn_save_rent_warehouse">Save</button>
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
      
    $("#btn_save_rent_warehouse").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('rentwarehouse/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_rent_warehouse").serialize(),
                success: function (data) {
                    swal("","Record Saved Successfully","success");
                    $("#frm_rent_warehouse")[0].reset();                     
                    $('#rent_warehouseModal').modal('hide');
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
        else
        {

        }

    });
   
</script>
</body>
</html>
