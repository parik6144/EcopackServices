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

//var_dump($form_data['item']['0']['item_name']);
//exit;
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Item</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Item Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('Item') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_item">
                        <input type="hidden" name="item_id" value="<?=encryptor("encrypt",$form_data['item']['0']['item_id']);?>">
                        <div class="form-group  row"><label class="col-sm-3 control-label">Item Name</label>
                            <div class="col-sm-9"><select name="item_name" class="form-control rec">
                                    <option value="">Select Item</option>
                                    <?php
                                        foreach ($item as $row) {
                                            $str="";
                                            if($row['master_item_id']==$form_data['item']['0']['master_item_id'])
                                                $str="selected='selected'";
                                            echo "<option value='".$row['master_item_id']."' ".$str.">".$row['item_name']."</option>";
                                        }
                                    ?>
                                </select></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Consignee Name</label>
                            <div class="col-sm-9">
                                <select name="consignee_id" class="form-control">
                                    <option value="">Select Consignee</option>
                                    <?php
                                        foreach ($consignee as $row) {
                                            $str="";
                                            if($row['consignee_id']==$form_data['item']['0']['consignee_id'])
                                                $str="selected='selected'";
                                            echo "<option value='".$row['consignee_id']."' ".$str.">".$row['consignee_name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                       <div class="hr-line-dashed"></div>
                       <div class="form-group  row"><label class="col-sm-3 control-label">Opening Stock</label>
                            <div class="col-sm-9"><input type="text" class="form-control"  name="opening_stock" value="<?=$form_data['item']['0']['opening_stock']?>"></div>
                            <input type="hidden" value="<?=$form_data['item']['0']['item_type']?>" class="form-control rec" name="item_type">
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Warehouse</label>
                            <div class="col-sm-9"><select class="form-control rec" name="warehouse_id">
                                <option value="">Select warehouse</option>
                                <?php
                                foreach ($warehouse as $row) {
                                    $str="";
                                    if($row['warehouse_id']==$form_data['item']['0']['warehouse_id'])
                                    $str="selected='selected'";
                                    ?>
                                    <option value="<?=$row['warehouse_id']?>" <?=$str?>><?=$row['warehouse_name']?></option>
                                    <?php
                                }
                                ?>
                            </select></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Warehouse Opening Stock</label>
                            <div class="col-sm-9"><input type="number" class="form-control" value="<?=$form_data['item']['0']['warehouse_opening_stock']?>"  name="warehouse_opening_stock"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        
                        <button type="button" class="btn btn-success" id="btn_save_item">Save</button>
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
      
    $("#btn_save_item").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('item/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_item").serialize(),
                success: function (data) {
                    swal("","Record Saved Successfully","success");
                    $("#frm_item")[0].reset();                     
                    $('#itemModal').modal('hide');
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
