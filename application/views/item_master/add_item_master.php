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
                        <div class="form-group  row"><label class="col-sm-3 control-label">Item Name</label>
                            <div class="col-sm-9"><input type="text" class="form-control rec"  name="item_name"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        
                        <div class="form-group  row"><label class="col-sm-3 control-label">Item Code</label>
                            <div class="col-sm-9"><input type="text" class="form-control"  name="item_code"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Item price</label>
                            <div class="col-sm-9"><input type="number" class="form-control"  name="price"></div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <?php
                        foreach ($warehouse as $row) {
                            # code...
                        ?>
                                <div class="form-group  row"><label class="col-sm-3 control-label"><?=$row['warehouse_name']?> OP Stock</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="warehouse_id[]" value="<?=$row['warehouse_id']?>">
                                        <input type="number" class="form-control"  name="opening_stock[]">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                        <?php
                            }
                        ?>
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
    var lastid="";
   
 
    $("#btn_save_item").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('itemmaster/add')?>',
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
        
    });
</script>
</body>
</html>
