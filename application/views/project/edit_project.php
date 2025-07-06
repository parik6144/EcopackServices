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
        <h2>Project</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Project Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('project') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>

                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group"><label class=" control-label" >Company Name</label>
                                    <div class=""><input type="text" class="form-control rec" value="<?=$form_data['project']['0']['company_name']?>"  name="company_name"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group"><label class=" control-label" >Contact Person Name</label>
                                    <div class=""><input type="text" class="form-control rec" value="<?=$form_data['project']['0']['contact_person_name']?>"  name="contact_person_name"></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group"><label class=" control-label" >Project Name</label>
                                    <div class=""><input type="text" class="form-control rec" value="<?=$form_data['project']['0']['project_name']?>"  name="project_name"></div>
                                </div>
                            </div>
                        </div>
                        
                            <div class="form-group  row"><label class="col-sm-3 control-label" >Company Address</label>

                                <div class="col-sm-9"><textarea class="form-control" name="company_address" rows="3"><?=$form_data['project']['0']['company_address']?></textarea></div>
                            </div>
                        <div class="col-sm-4">
                            <div class="form-group  row"><label class="col-sm-12 control-label"  style="text-align:left;">Rotation Per Month</label>

                                <div class="col-sm-12"><input type="text" class="form-control rec rotation_per_month" value="<?=$form_data['project']['0']['rotation_per_month']?>" name="rotation_per_month"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group  row"><label class="col-sm-12 control-label" style="text-align:left;">Source</label>

                                <div class="col-sm-12">
                                    <select class="consignor_place rec form-control"  name="source_id" >
                                        <option value="">Select Place</option>
                                            <?php
                                            foreach ($place as $row) {
                                                $str="";
                                                if($form_data['project']['0']['source_id']==$row['place_id'])
                                                    $str='selected="selected"';
                                                ?>
                                                <option value="<?=$row['place_id']?>" <?=$str?>><?=$row['place_name']?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group  row"><label class="col-sm-12 control-label"  style="text-align:left;">Destination</label>

                                <div class="col-sm-12">
                                    <select class="consignee_place rec form-control"  name="destination_id">
                                            <option value="">Select Place</option>
                                            <?php
                                            foreach ($place as $row) {

                                                $str="";
                                                if($form_data['project']['0']['destination_id']==$row['place_id'])
                                                    $str='selected="selected"';
                                                ?>
                                                <option value="<?=$row['place_id']?>" <?=$str?>><?=$row['place_name']?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="hr-line-dashed"></div>
                        <div class="row">

                            <div class="col-sm-7">
                                <div class="table-responsive">
                                    <table class="table table-stripped">
                                        <thead>
                                            <tr>
                                                <th style="width:40%">Asset Name</th>
                                                <th>Life In Months</th>
                                                <th>Purchase Cost</th>
                                                <th>Total Qty</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody class="asset_tbody">
                                            <?php
                                            for($i=0;$i<sizeof($form_data['project_asset'] );$i++){
                                               ?>
                                               <tr>
                                                    <td><input type="text" name="asset_name[]" class="form-control asset_name" value="<?=$form_data['project_asset'][$i]['assets_name']?>"></td>
                                                    <td><input type="number" name="life_in_months[]" class="form-control life" value="<?=$form_data['project_asset'][$i]['life_in_month']?>" placeholder="In month"></td>
                                                    <td><input type="number" name="purchase_cost[]"  value="<?=$form_data['project_asset'][$i]['purchase_cost']?>" class="form-control purchase_cost" placeholder=""></td>
                                                    <td><input type="number" name="total_qty[]" class="form-control total_qty" placeholder="" value="<?=$form_data['project_asset'][$i]['total_qty']?>"></td>
                                                    <td><button type="button" class="del btn btn-danger btn-circle"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                               <?php 
                                            }
                                            ?>
                                            <tr>
                                                <td><input type="text" name="asset_name[]" class="form-control asset_name"></td>
                                                <td><input type="number" name="life_in_months[]" class="form-control life" placeholder="In month"></td>
                                                <td><input type="number" name="purchase_cost[]" class="form-control purchase_cost" placeholder=""></td>
                                                <td><input type="number" name="total_qty[]" class="form-control total_qty" placeholder=""></td>
                                                <td><button type="button" class="btn  btn-info btn-circle add"><i class="fa fa-plus"></i></button></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">Total</td>
                                                <td><input type="text" name="" class="form-control disabled total_asset_value" disabled></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Interest In %</td>
                                                <td ><input type="text" name="interest_rate" value="<?=$form_data['project']['0']['assets_interest_rate']?>" class="form-control disabled assets_interest"></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Profit In %</td>
                                                <td ><input type="text" name="profit_rate" value="24" class="form-control disabled profit"></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Required Loan Amount</td>
                                                <td ><input type="text" name="principal" value="" class="form-control principal" readonly="readonly"></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Time in month</td>
                                                <td ><input type="text" name="time" value="36" class="form-control disabled time"></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <table class="table table-stripped">
                                        <thead>
                                            <tr>
                                                <th style="width:50%">Operation</th>
                                                <th style="width:40%">Amount</th>
                                                <!-- <th>Type</th> -->
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody class="operation_tbody">
                                            <?php
                                            for($i=0;$i<sizeof($form_data['project_operation'] );$i++)
                                            {
                                                ?>
                                            <tr>
                                                <td><input type="text" name="operation_name[]" class="form-control operation_name" value="<?=$form_data['project_operation'][$i]['operation_name']?>"></td>
                                                <td><input type="number" name="operation_amount[]" class="form-control operation_amount"  value="<?=$form_data['project_operation'][$i]['operation_cost']?>" placeholder=""></td>
                                                <td><button type="button" class="del_operation btn btn-danger btn-circle"><i class="fa fa-trash"></i></button></td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                            <tr>
                                                <td><input type="text" name="operation_name[]" class="form-control operation_name"></td>
                                                <td><input type="number" name="operation_amount[]" class="form-control operation_amount" placeholder=""></td>
                                                <td><button type="button" class="btn  btn-info btn-circle add_operation"><i class="fa fa-plus"></i></button></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>Total</td>
                                                <td><input type="text" name="" class="form-control disabled total_operation_value"></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Interest In %</td>
                                                <td ><input type="text" name="operation_rate"  value="<?=$form_data['project']['0']['operation_interest_rate']?>" class="form-control disabled operation_interest"></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>

                                    </table>
                            </div>
                        </div>
                         <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group  row"><label class="col-sm-2 control-label" >Remarks</label>

                                    <div class="col-sm-10"><textarea rows="3" class="form-control"  name="remarks"><?=$form_data['project']['0']['remarks']?></textarea></div>
                                </div>
                            </div>
                        </div>
                        <label>Per Box Rate:<span id="per_month_rate"></span></label><br/>
                        <label>Per Year Rate:<span id="per_year_rate"></span></label><br/>
                        <!-- <button type="button" class="btn btn-success" id="btn_save_place">Save</button> -->
                        <button type="button" class="btn btn-success btn_calculate">Calculate</button>
                        <button type="submit" class="btn btn-success" style="float:right">Save</button>
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
        $(".btn_calculate").click();
    });

    $(document).on('click','.add',function(){
            $(this).html('<i class="fa fa-trash"></i>');
            $(this).attr('class','del btn btn-danger btn-circle');
            var appendTxt =   '   <tr>  '  + 
 '                                                   <td><input type="text" name="asset_name[]" class="form-control asset_name"></td>  '  + 
 '                                                   <td><input type="number" name="life_in_months[]" class="form-control life" placeholder="In month"></td>  '  + 
 '                                                   <td><input type="number" name="purchase_cost[]" class="form-control purchase_cost" placeholder=""></td>  '  +
 '                                                   <td><input type="number" name="total_qty[]" class="form-control total_qty" placeholder=""></td>  '  +  
 '                                                   <td><button type="button" class="btn  btn-info btn-circle add"><i class="fa fa-plus"></i></button></td>  '  + 
 '                                              </tr>  ' ; 
            $(".asset_tbody").append(appendTxt);          
        });
    $(document).on('click','.del',function(){
            $(this).parent().parent().remove();
        });

    $(document).on('click','.add_operation',function(){
            $(this).html('<i class="fa fa-trash"></i>');
            $(this).attr('class','del_operation btn btn-danger btn-circle');
            var appendTxt =    '   <tr>  '  + 
 '                                                   <td><input type="text" name="operation_name[]" class="form-control operation_name"></td>  '  + 
 '                                                   <td><input type="number" name="operation_amount[]" class="form-control operation_amount" placeholder=""></td>  '  + 
 // '                                                   <td><select class="form-control operation_type">  '  + 
 // '                                                       <option value="0">Per Rot</option>  '  + 
 // '                                                       <option value="1">Monthly</option>  '  + 
 // '                                                   </select>  '  + 
 // '     '  + 
 // '                                                   </td>  '  + 
 '                                                   <td><button type="button" class="btn  btn-info btn-circle add_operation"><i class="fa fa-plus"></i></button></td>  '  + 
 '                                              </tr>  ' ; 
            $(".operation_tbody").append(appendTxt);          
        });
    $(document).on('click','.del_operation',function(){
            $(this).parent().parent().remove();
        });
    $(".btn_calculate").click(function(){
        var asset_total=0;
        var total=0;
        var principal=0;
        var rotation=parseFloat($(".rotation_per_month").val());
        $(".asset_tbody tr").each(function(){
            if($(this).find(".life").val()!=="" && $(this).find(".purchase_cost").val()!=="")
            {
                var life=parseFloat($(this).find(".life").val());
                var purchase_cost=parseFloat($(this).find(".purchase_cost").val());
                var totalqty=parseFloat($(this).find(".total_qty").val());
                
                var rowtotal=purchase_cost/(life*rotation);
                asset_total+=purchase_cost;
                total+=rowtotal;
                principal+=purchase_cost*totalqty;
            }
        });
        $(".principal").val(principal);
        $(".total_asset_value").val(asset_total.toFixed(2));
        /*custom*/
        var a = asset_total;
        var b = parseFloat($(".assets_interest").val());
        var c = parseInt($(".time").val());
        var n = c;         
       var r = b / (12 * 100);
        var p = (a * r * Math.pow((1 + r), n)) / (Math.pow((1 + r), n) - 1);
        var print = Math.round(p);
        var r1 = print.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        Totalpayment=print*c;
        Totalinterest=Totalpayment-asset_total;
        permonthinterest=Totalinterest/c;
        perRotationInterest=permonthinterest/rotation;


        /*custom*/
        //alert(total);
        //alert("interest"+perRotationInterest);
        var total_asset_expense=total+perRotationInterest;
        //alert(total_asset_expense);
        var total_asset_expense_yearly=total_asset_expense*12;



        var operation_total=0;
        var total=0;
        $(".operation_tbody tr").each(function(){
            if($(this).find(".operation_amount").val()!=="")
            {
                
                var operation_amount=parseFloat($(this).find(".operation_amount").val());
                var rotation=parseFloat($(".rotation_per_month").val());
                /*if($(this).find(".operation_type").val()=="0")
                {
                    var rowtotal=operation_amount;

                }
                else
                {
                    var rowtotal=operation_amount/rotation;
                }*/
                var rowtotal=operation_amount;
                operation_total+=rowtotal;
                total+=rowtotal;
            }
            
        });
        $(".total_operation_value").val(operation_total.toFixed(2));
        var toalopcost=operation_total*rotation;
        var operation_interest_rate=parseFloat($(".operation_interest").val());

        var interest_on_operation=(toalopcost*operation_interest_rate)/100;
        var total_operation_expense=total+(interest_on_operation/12);
        //var total_operation_expense_yearly=total_operation_expense*12;
        var profitinpercent=parseFloat($(".profit").val());
        var totalexp=total_asset_expense+total_operation_expense;
        var profit=(totalexp*profitinpercent)/100;
        $("#per_month_rate").html((totalexp+profit).toFixed(2));
    });
</script>
</body>
</html>
