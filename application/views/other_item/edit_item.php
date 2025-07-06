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

//var_dump($form_data['other_item']['0']['other_item_name']);
//exit;
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>other_item</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>other_item Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('other_item') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php }?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_other_item">
                        <input type="hidden" name="other_item_id" value="<?=encryptor("encrypt",$form_data['other_item']['0']['other_item_id']);?>">
                        <div class="form-group  row"><label class="col-sm-3 control-label">other Item Name</label>
                            <div class="col-sm-9"><input type="text" class="form-control rec"  name="other_item_name" value="<?=$form_data['other_item']['0']['other_item_name']?>"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Consignee Name</label>
                            <div class="col-sm-9">
                                <select name="consignee_id" class="form-control">
                                    <option value="">Select Consignee</option>
                                    <?php
                                        foreach ($consignee as $row) {
                                            $str="";
                                            if($row['consignee_id']==$form_data['other_item']['0']['consignee_id'])
                                                $str="selected='selected'";
                                            echo "<option value='".$row['consignee_id']."' ".$str.">".$row['consignee_name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                       <div class="hr-line-dashed"></div>
                       <div class="form-group  row"><label class="col-sm-3 control-label">Opening Stock</label>
                            <div class="col-sm-9"><input type="text" class="form-control"  name="opening_stock" value="<?=$form_data['other_item']['0']['opening_stock']?>"></div>
                            <input type="hidden" value="transport" class="form-control rec" name="item_type">
                        </div>
                        <div class="hr-line-dashed"></div>
                        
                        
                        <button type="button" class="btn btn-success" id="btn_save_other_item">Save</button>
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
      
    $("#btn_save_other_item").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('other_item/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_other_item").serialize(),
                success: function (data) {
                    swal("","Record Saved Successfully","success");
                    $("#frm_other_item")[0].reset();                     
                    $('#other_itemModal').modal('hide');
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
