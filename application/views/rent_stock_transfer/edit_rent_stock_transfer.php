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
        <h2>Stock Transfer</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Stock Transfer</h5>
                    <span class="pull-right"><a href="<?php echo site_url('stocktransfer') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_stocktransfer">
                        <div class="form-group  row"><label class="col-sm-2 control-label">From</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="stock_transfer_id" value="<?=$this->input->get('id')?>">
                                <select class="form-control rec from_consignee_id" name="from_consignee_id">
                                    <option value="">From</option>
                                    <?php
                                        foreach ($consignee as $row) {
                                            $str="";
                                            if($form_data->from_consignee_id==$row['consignee_id'])
                                                $str="selected='selected'";
                                            ?>
                                            <option <?=$str?> value="<?=$row['consignee_id']?>"><?=$row['consignee_name']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Item</label>
                            <div class="col-sm-10">
                                <select class="form-control rec from_item_name" name="from_item_id">
                                    <?php
                                        foreach ($from_item as $row) {
                                            $str="";
                                            if($form_data->from_item_id==$row['item_id'])
                                                $str="selected='selected'";
                                            ?>
                                            <option <?=$str?> value="<?=$row['item_id']?>"><?=$row['item_name']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Stock</label>
                            <div class="col-sm-10">
                                <input class="form-control stock" name="" readonly="readonly" value="<?=$stock?>">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">To</label>
                            <div class="col-sm-10">
                                <select class="form-control rec to_consignee_id" name="to_consignee_id">
                                    <option value="">TO</option>
                                    <?php
                                        foreach ($consignee as $row) {
                                            $str="";
                                            if($form_data->to_consignee_id==$row['consignee_id'])
                                                $str="selected='selected'";
                                            ?>
                                            <option <?=$str?> value="<?=$row['consignee_id']?>"><?=$row['consignee_name']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Item</label>
                            <div class="col-sm-10">
                                <select class="form-control rec to_item_name" name="to_item_id">
                                    <?php
                                        foreach ($to_item as $row) {
                                            $str="";
                                            if($form_data->to_item_id==$row['item_id'])
                                                $str="selected='selected'";
                                            ?>
                                            <option <?=$str?> value="<?=$row['item_id']?>"><?=$row['item_name']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Qty</label>
                            <div class="col-sm-10">
                                <input class="form-control rec qty" name="qty" value="<?=$form_data->qty?>">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="button" class="btn btn-success" id="btn_save_stocktransfer">Save</button>
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

    $("#btn_save_stocktransfer").click(function () {
        var ref=$(this);
        var ref=$(this);
        if(validate(ref))
        {
            
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('rentstocktransfer/edit')?>',
                cache: false,
                async: false,
                data: $("#frm_stocktransfer").serialize(),
                success: function (data) {
                    //swal("","Record Saved Successfully","success");
                    lastid=data;
                    $("#frm_stocktransfer")[0].reset();
                    $('#stocktransferModal').modal('hide');
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
    $(".to_consignee_id").change(function(){
        var consignee_id=$(this).val();
        $.ajax({
                type: 'POST',
                url: '<?php echo site_url('item/getrentstockitem')?>',
                cache: false,
                async: false,
                data: {'consignee_id':consignee_id},
                success: function (data) {
                    var rec=JSON.parse(data);
                    var str="<option value=''>Select Item</option>";
                    $.each(rec,function(k,v){
                        str+="<option value='"+v['item_id']+"'>"+v['item_name']+"</option>";
                    });
                    $(".to_item_name").html(str);
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
        if(item_id!="")
        {
           $.ajax({
                type: 'POST',
                url: '<?php echo site_url('stocktransfer/getRentStockByItem')?>',
                cache: false,
                async: false,
                data: {'item_id':item_id},
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
