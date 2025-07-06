<?php


$this->load->view('header');
$this->load->view('left_sidebar');
$this->load->view('topbar');
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Loan Booking Pending</h2>
        
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>loan Pending Records</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-wrench"></i>
                </a>
                
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example" id="example">
                    <thead>
                    <tr role="row">
                        <th>Sl. No</th>
                        <th>Party Name</th>
                        <th>Loan Date</th>  
                        <th>Pending Date</th>  
                        <th>Monthly EMI</th>
                        <th>Loan Type</th>
                        <th>#</th>

                    </tr>
                    </thead>
                    <tbody>
                        <?php $ctr=0; $dateday=date('d');
                            $datemonth=date('m');$dateyear=date('Y'); foreach ($data as $row):   ?>
                            <?php
                            
                            if(is_null($row['booking_date']))
                            {
                                $tempday=date('d',strtotime($row['loan_date']));
                                $tempmonth=date('m',strtotime($row['loan_date']));
                            }
                            else{
                                $tempday=date('d',strtotime($row['booking_date']));
                                $tempmonth=date('m',strtotime($row['booking_date']));
                            }   
                                
                            $pending=0;
                            $j=0;
                            if($tempmonth<$datemonth)
                            {

                                $pending=$datemonth-$tempmonth;
                                $pending=$pending-1;
                                $j=$pending;
                                if($dateday>=$tempday)
                                    $pending++;

                            }
                            
                            for($i=0;$i<$pending;$i++)
                            {
                                $ctr++;
                                $str=date("d",strtotime($row['loan_date']))."-".($datemonth-$j)."-".$dateyear;
                                $str1=date("d",strtotime($row['loan_date']))."-".($datemonth-$j)."-".$dateyear;
                                ?>
                                <tr>
                                    <td><?=$ctr?></td>
                                    <td><?=$row['party_name']?></td>
                                    <td><?=date("d-m-y",strtotime($row['loan_date']))?></td>
                                    <td><?=$str ?></td>
                                    <td><?=$row['monthly_emi']?></td>
                                   <?php if($row['loan_type']=="1")
                                        echo "<td>EMI</td>";
                                    else
                                        echo "<td>Interest</td>";
                                    ?>

                                    <?php
                                    if($i==0)
                                     echo "<td><a href='".base_url('payment_booking/loanbooking/').encryptor("encrypt",$row['loan_id'])."/".$str1."' class='btn_book'>book</a></td>";
                                    else
                                        echo "<td>Book Above</td>";
                                     ?>
                                </tr>
                                <?php
                                $j--;
                            }
                            ?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            

        </div>
    </div>
</div>
    </div>
</div>
<?php
$this->load->view('footer');
?>
<script src="<?php echo base_url() ?>assets/js/plugins/dataTables/datatables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
