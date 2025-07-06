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
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Asset Lost</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Asset Lost</h5>
                    <span class="pull-right"><a href="<?php echo site_url('asset_lost') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_asset_lost">
                        <div class="form-group  row"><label class="col-sm-2 control-label">Warehouse</label>
                            <div class="col-sm-10">
                                <select class="form-control rec from_warehouse_id" name="from_warehouse_id">
                                    <option value="">From warehouse</option>
                                    <?php
                                        foreach ($warehouse as $row) {
                                            ?>
                                            <option value="<?=$row['warehouse_id']?>"><?=$row['warehouse_name']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">From</label>
                            <div class="col-sm-10">
                                <select class="form-control rec from_consignee_id" name="consignee_id">
                                    <option value="">From</option>
                                    <?php
                                        foreach ($consignee as $row) {
                                            ?>
                                            <option value="<?=$row['consignee_id']?>"><?=$row['consignee_name']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Item</label>
                            <div class="col-sm-10">
                                <select class="form-control rec from_item_name" name="item_id">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Stock</label>
                            <div class="col-sm-10">
                                <input class="form-control stock" name="" readonly="readonly">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Qty</label>
                            <div class="col-sm-10">
                                <input class="form-control rec qty" name="qty">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-2 control-label">Type</label>
                            <div class="col-sm-10">
                                <select class="form-control rec" name="lost_type">
                                    <option value="">Select Type</option>
                                    <option value="1">Lost</option>
                                    <option value="2">Damage</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row"><label class="col-sm-2 control-label">Remarks</label>
                            <div class="col-sm-10">
                                <textarea class="form-control rec" name="remarks" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="button" class="btn btn-success" id="btn_save_asset_lost">Save</button>
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
    var lastid="";
    $(document).ready(function () {

    });

    $("#btn_save_asset_lost").click(function () {
        var ref=$(this);
        var ref=$(this);
        if(validate(ref))
        {
            
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('asset_lost/add')?>',
                cache: false,
                async: false,
                data: $("#frm_asset_lost").serialize(),
                success: function (data) {
                    swal("","Record Saved Successfully","success");
                    lastid=data;
                    $("#frm_asset_lost")[0].reset();
                    
                    $('#asset_lostModal').modal('hide');
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
    $(".from_consignee_id").change(function(){
        var consignee_id=$(this).val();
        $.ajax({
                type: 'POST',
                url: '<?php echo site_url('item/getrentstockitem')?>',
                cache: false,
                async: false,
                data: {consignee_id:consignee_id},
                success: function (data) {
                    var rec=JSON.parse(data);
                    var str="<option value=''>Select Item</option>";
                    $.each(rec,function(k,v){
                        str+="<option value='"+v['item_id']+"'>"+v['item_name']+"</option>";
                    });
                    $(".from_item_name").html(str);
                },
                error: function (data) {
                    // alert("error");
                },
                timeout: 5000,
                error: function(jqXHR, textStatus, errorThrown) {
                    swal("","Please check your internet connection.","error");
                }
            });
     });
   
    $(".from_item_name").change(function(){
        var item_id=$(this).val();
        var from_warehouse_id=$(".from_warehouse_id").val();
        if(item_id!="" && from_warehouse_id!="")
        {
           $.ajax({
                type: 'POST',
                url: '<?php echo site_url('rentstocktransfer/getRentStockByItem')?>',
                cache: false,
                async: false,
                data: {'item_id':item_id,'from_warehouse_id':from_warehouse_id},
                success: function (data) {
                    console.log(data);
                    $(".stock").val(data);
                },
                error: function (data) {
                    // alert("error");
                },
                timeout: 5000,
                error: function(jqXHR, textStatus, errorThrown) {
                    swal("","Please check your internet connection.","error");
                }
            }); 
        }
        else
        {
            $(".stock").val("0");
            alert("Please Select warehouse and item");
        }
        
     });
    $(".qty").change(function(){
        var stock=parseInt($(".stock").val());
        var qty=parseInt($(this).val());
        if(!isNaN(qty))
        {
            if(qty>stock)
           {
             alert("Invalid Stock entered");
             $(this).val("");
           } 
        }
    })
</script>
</body>
</html>
