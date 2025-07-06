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

//var_dump($form_data['loan']['0']['party_name']);
//exit;
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Loan</h2>

    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Loan Form</h5>
                    <span class="pull-right"><a href="<?php echo site_url('loan') ?>"><i class="fa fa-angle-left"></i>Back</a> </span>
                </div>
                <?php } ?>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" id="frm_loan">
                        <div class="form-group  row"><label class="col-sm-3 control-label">Party Name</label>
                            <div class="col-sm-9">
                                <select class="form-control rec" name="account_id">
                                    <option value=''>Select Party</option>
                                    <?php
                                    foreach ($account as $row) {
                                        echo "<option value='".$row['account_id']."'>".$row['party_name']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Loan Date</label>
                            <div class="col-sm-9"><input type="date" class="form-control rec"  name="loan_date"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Type</label>
                            <div class="col-sm-9">
                                <select class="form-control rec loan_type" name="loan_type">
                                    <option value="">Select Loan Type</option>
                                    <option value="1">EMI</option>
                                    <option value="2">Interest</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Loan Amount</label>
                            <div class="col-sm-9"><input type="number" class="form-control rec loan_amount"  name="loan_amount"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row due_amount_div"><label class="col-sm-3 control-label">Due Amount</label>
                            <div class="col-sm-9"><input type="number" class="form-control due_amount"  name="due_amount"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                         
                        <div class="form-group  row"><label class="col-sm-3 control-label">Interest Rate</label>
                            <div class="col-sm-9"><input type="number" class="form-control rec interest_rate"  name="interest_rate"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row time_div"><label class="col-sm-3 control-label">Tennure in months</label>
                            <div class="col-sm-9"><input type="number" class="form-control time"  name="loan_time"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 control-label">Monthly EMI</label>
                            <div class="col-sm-9"><input type="text" class="form-control rec monthly_emi"  name="monthly_emi"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <button type="button" class="btn btn-success" id="btn_save_loan">Save</button>
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
   $(".due_amount_div, .time_div").hide();
    
    $("#btn_save_loan").click(function () {
        var ref=$(this);
        if(validate(ref))
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('loan/add')?>',
                cache: false,
                async: false,
                data: $("#frm_loan").serialize(),
                success: function (data) {
                    swal("","Record Saved Successfully","success");
                    $("#frm_loan")[0].reset();
                    $('#loanModal').modal('hide');
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
    $(".loan_type").change(function(){
        $(".due_amount_div, .time_div").hide();
        if($(this).val()=="")
        {
            alert("select Loan Type");
        }
        else if($(this).val()=="1")
        {
            $(".due_amount_div, .time_div").show();
        }
    });
    $(".interest_rate, .loan_amount, .time, .loan_type").change(function(){
        var interest_rate=parseFloat($(".interest_rate").val());
        var loan_amount=parseFloat($(".loan_amount").val());
        var emi=0;
        if(!isNaN(interest_rate))
        {
            if($(".loan_type").val()=="2")
            {
                 emi=(loan_amount*interest_rate)/100;
                
            }
            else
            {
                if(!isNaN(loan_amount) && $(".time").val()!="")
                {
                    var a = loan_amount;
                    var b = interest_rate;
                    var c = parseInt($(".time").val())
                    var n = c;   
                                      
                    var r = b / (12 * 100);
                    var p = (a * r * Math.pow((1 + r), n)) / (Math.pow((1 + r), n) - 1);
                    emi = Math.round(p);
                    //emi = print.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            }
        }
        
        $(".monthly_emi").val(emi);
    });
    
</script>
</body>
</html>
