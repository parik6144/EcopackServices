<?php
$this->load->view('header');
$this->load->view('left_sidebar');
$this->load->view('topbar');
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Loan Booking Pending</h2>
    </div>
    <div class="col-lg-2"></div>
</div>


        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#" class="dropdown-item">Config option 1</a>
                                    </li>
                                    <li><a href="#" class="dropdown-item">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>

                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example">
                                    <thead>
                                    <tr role="row">
                                        <th class="text-center">Sl. No</th>
                                        <th class="text-center">Party Name</th>
                                        <th class="text-center">Loan Date</th>
                                        <th class="text-center">Last Booking Date</th>
                                        <th class="text-center">Pending Date</th>
                                        <th class="text-center">Monthly EMI</th>
                                        <th class="text-center">Loan Type</th>
                                        <th class="text-center">#</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php foreach($data as $row): ?>
                                        <?php $ctr++;
                                        if(is_null($row['booking_date'])){ $str='Not-Available'; } else {
                                            $str = date('d-m-Y',strtotime($row['booking_date'])); }

                                        // Today's Date starts here.
                                        $today_full_date = date('d-m-Y');
                                        $today_date=date('d');
                                        $today_month=date('m');
                                        $today_year=date('Y');
                                        // Today's Date ends here.

                                        // Loan's Date starts here.
                                        $loan_date= date('d',strtotime($row['loan_date']));
                                        $loan_month= date('m',strtotime($row['loan_date']));
                                        $loan_year= date('Y',strtotime($row['loan_date']));
                                        // Loan's Date ends here.

                                        // Last Paid Booking's Date starts here.
                                        $booking_date= date('d',strtotime($row['booking_date']));
                                        $booking_month= date('m',strtotime($row['booking_date']));
                                        $booking_year= date('Y',strtotime($row['booking_date']));
                                        // Last Paid Booking's Date ends here.

                                        if($row['booking_date']=='')
                                        {
                                            $pending_month = (($today_year-$loan_year)*12)+$today_month-$loan_month;
                                        }
                                        else
                                        {
                                            $pending_month = (($today_year-$booking_year)*12)+$today_month-$booking_month;
                                        }

                                        // $pending_date = $loan_date.'-'.$today_month.'-'.$today_year;
                                        $pending_date = $loan_date.'-'.$today_month.'-'.$today_year;

                                        //echo strtotime($pending_date); echo "</br>";
                                        //echo strtotime($today_full_date); echo "</br>"; echo "</br>";
                                        if(strtotime($pending_date)<=strtotime($today_full_date)){ ?>
                                            <?php for($i=0; $i<$pending_month; $i++){  ?>
                                            <tr>
                                                <td class="text-center"><?=$ctr?></td>
                                                <td class="text-center"><?=$row['party_name']?></td>
                                                <td class="text-center"><?=date("d-m-y",strtotime($row['loan_date']))?></td>
                                                <td class="text-center"><?=$str?></td>
                                                <td class="text-center"><?= $pending_date?></td>
                                                <td class="text-center"><?=$row['monthly_emi']?></td>
                                                <?php if($row['loan_type']=="1") { echo "<td class='text-center'>EMI</td>"; }
                                                else { echo "<td class='text-center'>Interest</td>"; } ?>
                                                <?php
                                                if($i==0)
                                                echo "<td class='text-center'><a href='".base_url('payment_booking/loanbooking/').encryptor("encrypt",$row['loan_id'])."/".$pending_date."' class='btn_book label label-primary'>book</a></td>";
                                                else
                                                echo "<td class='text-center'>Book Above</td>";
                                                ?>
                                            </tr>
                                        <?php }} endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>




<?php $this->load->view('footer'); ?>
<script src="<?php echo base_url() ?>assets/js/plugins/dataTables/datatables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url() ?>js/inspinia.js"></script>
<script src="<?php echo base_url() ?>js/plugins/pace/pace.min.js"></script>

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                    customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ]

        });

    });

</script>

</body>

</html>
