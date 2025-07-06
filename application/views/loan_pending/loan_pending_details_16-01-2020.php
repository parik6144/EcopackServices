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
                                <th class="text-center">Sl. No</th>
                                <th class="text-center">Party Name</th>
                                <th class="text-center">Loan Date</th>
                                <th class="text-center">Booking Date</th>
                                <th class="text-center">Pending Date</th>
                                <th class="text-center">Monthly EMI</th>
                                <th class="text-center">Loan Type</th>
                                <th class="text-center">#</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            $ctr=1;
                            $dateday=date('d'); $datemonth = date('m'); $dateyear=date('Y');
                            foreach($data as $row):
                            $bookingday= date("d",strtotime($row['booking_date']));
                            $bookingmonth= date("m",strtotime($row['booking_date']));
                            $bookingyear= date("Y",strtotime($row['booking_date']));
                            $loanday= date("d",strtotime($row['loan_date']));
                            $loanmonth= date("m",strtotime($row['loan_date']));
                            $loanyear= date("Y",strtotime($row['loan_date']));
                            $str = $loanday."-".$datemonth."-".$dateyear;
                                        
                            if(isset($row['booking_date'])){
                                $pendingmonth= (($dateyear - $bookingyear) * 12) + ($datemonth - $bookingmonth);
                                for($i=0;$i<$pendingmonth; $i++)
                                { ?>
                                    <tr>
                                        <td class="text-center"><?=$ctr?></td>
                                        <td class="text-center"><?=$row['party_name']?></td>
                                        <td class="text-center"><?=date("d-m-y",strtotime($row['loan_date']))?></td>
                                        <td class="text-center"><?php if(is_null($row['booking_date'])) { echo ""; } else { echo date("d-m-Y",strtotime($row['booking_date'])); }?></td>
                                        <td class="text-center"><?=$str?></td>
                                        <td class="text-center"><?=$row['monthly_emi']?></td>
                                        <?php if($row['loan_type']=="1")
                                            echo "<td class='text-center'>EMI</td>";
                                        else
                                            echo "<td class='text-center'>Interest</td>";
                                        ?>

                                        <?php
                                        if($i==0)
                                            echo "<td class='text-center'><a href='".base_url('payment_booking/loanbooking/').encryptor("encrypt",$row['loan_id'])."/".$str."' class='btn_book'>book</a></td>";
                                        else
                                            echo "<td class='text-center'>Book Above</td>";
                                        ?>
                                    </tr>
                                <?php }} else{ } ?>
                            <?php $ctr++;  endforeach; ?>
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
