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
        <h2>Other Item Stock</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Other Item Stock Form</h5>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_orderno">

                                    <label class="col-sm-2">Stock Date</label>
                                    <div class="input-group date col-sm-10 " id="data_1">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="stock_date" class="form-control stock_date rec" value="<?=date("d-m-Y");?>">
                                    </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-2 control-label">Consignee Name</label>

                            <div class="col-sm-10">
                                <select class="form-control rec consignee_id" name="consignee_id">
                                    <option value="">Select Consignee</option>
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
                        <div id="item_list">
                        </div>
                        <button type="button" class="btn btn-success" id="btn_save_orderno">Save</button>
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
    $('#data_1').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        autoclose: true,
        format:'dd-mm-yyyy'
    });
    $(document).ready(function () {
    	$(".consignee_id").change(function(){

            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('other_item/getItemByConsigneeId')?>',
                cache: false,
                async: false,
                data: {consignee_id:$(".consignee_id").val(),stock_date:$(".stock_date").val()},
                success: function (data) {
                	var result=JSON.parse(data);
                	var str="";
                	 $.each(result,function(k,v){
                        str+='   <div class="form-group  row"><label class="col-sm-2 control-label">'+v['other_item_name']+'</label>  '  + 
 '                               <div class="col-sm-10">  '  + 
 '                                   <input type="hidden" class="form-control" name="item_id[]" Value="'+v['other_item_id']+'">  '  + 
 '                                   <input type="text" class="form-control" name="qty[]" value="'+v['qty']+'">  '  + 
 '                               </div>  '  + 
 '                           </div>  '  + 
 '                          <div class="hr-line-dashed"></div>  ';
                   });
                	 $("#item_list").html(str);
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
    });

    $("#btn_save_orderno").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('other_item_stock/add')?>',
                cache: false,
                async: false,
                data: $("#frm_orderno").serialize(),
                success: function (data) {
                    swal("","Record Saved Successfully","success");
                    
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
