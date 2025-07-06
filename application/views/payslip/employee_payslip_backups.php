<?php
/**
 * Created by PhpStorm.
 * User: Amit Parik
 * Date: 16/08/2017
 * Time: 14:52
 */
$this->load->view('header');
$this->load->view('left_sidebar');
$this->load->view('topbar');
?>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2>Payslip</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?=base_url()?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Payslip</strong>
                        </li>
                    </ol>
                </div>

                <div class="col-lg-4">
                    <div class="title-action">
                        <a href="#" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Payslip </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="wrapper wrapper-content animated fadeInRight">
                        <div class="ibox-content p-xl">

                            <div class="row">
                            <div class="col-lg-10">
                            <table style="width: 100%">
                            <tbody>
                            <?php $res = $this->db->select('*')->from('sitedetails')->get()->row(); ?>
                            <tr>
                            <td class="text-center" colspan="12">
                                <h1 style="font-family: -webkit-body; font-size: 35px;"><?=$res->siteName?></h1>
                                <p style="padding: 2px 10px; border: 1px solid; margin-bottom: 0; border-left: none; border-right: none; font-size: 18px;">
                                <?=$res->address_1?>, <?=$res->address_2?>, <?=$res->area?>, <?=$res->city?>- <?=$res->pincode?>, Jharkhand<br>
                                Mobile : <?=$res->mobile?>,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E-mail : <?=$res->SiteEmail?>  <br>
                                GSTIN : <?=$res->gstin?>,&nbsp;&nbsp;&nbsp;State-Code : <?=$res->statecode?></p>
                            </td>
                            </tr>
                            </tbody>
                            </table>
                            </div>

                            <div class="col-lg-2">
                            <img src="<?=base_url('uploads/').$res->siteLogo?>" style="width: 165px; float: right;">
                            </div>
                            </div>

                           <div class="row">
                                <div class="col-sm-6">
                                <table>
                                <tbody>
                                <tr style="font-size:15px; padding: 10px;">
                                <td>Employee ID :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>34</td>
                                </tr>
                                <tr style="font-size:15px; padding: 10px;"><td>Employee ID :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>34</td></tr>
                                <tr style="font-size:15px; padding: 10px;"><td>Employee ID :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>34</td></tr>
                                <tr style="font-size:15px; padding: 10px;"><td>Employee ID :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>34</td></tr>
                                <tr style="font-size:15px; padding: 10px;"><td>Employee ID :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>34</td></tr>
                                </tbody>
                                </table>
                                </div>

                                <div class="col-sm-6 text-right">
                                    <h4>Invoice No.</h4>
                                    <h4 class="text-navy">INV-000567F7-00</h4>
                                    <span>To:</span>
                                    <address>
                                        <strong>Corporate, Inc.</strong><br>
                                        112 Street Avenu, 1080<br>
                                        Miami, CT 445611<br>
                                        <abbr title="Phone">P:</abbr> (120) 9000-4321
                                    </address>
                                    <p>
                                        <span><strong>Invoice Date:</strong> Marh 18, 2014</span><br>
                                        <span><strong>Due Date:</strong> March 24, 2014</span>
                                    </p>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                 <div class="table-responsive m-t">
                                <table class="table Payslip-table">
                                    <thead>
                                    <tr>
                                        <th>Item List</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Tax</th>
                                        <th>Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><div><strong>Admin Theme with psd project layouts</strong></div>
                                            <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small></td>
                                        <td>1</td>
                                        <td>$26.00</td>
                                        <td>$5.98</td>
                                        <td>$31,98</td>
                                    </tr>
                                    <tr>
                                        <td><div><strong>Wodpress Them customization</strong></div>
                                            <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                                Eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                            </small></td>
                                        <td>2</td>
                                        <td>$80.00</td>
                                        <td>$36.80</td>
                                        <td>$196.80</td>
                                    </tr>
                                    <tr>
                                        <td><div><strong>Angular JS & Node JS Application</strong></div>
                                            <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small></td>
                                        <td>3</td>
                                        <td>$420.00</td>
                                        <td>$193.20</td>
                                        <td>$1033.20</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /table-responsive -->
                                </div>

                                <div class="col-sm-6 text-right">
                                   <div class="table-responsive m-t">
                                <table class="table Payslip-table">
                                    <thead>
                                    <tr>
                                        <th>Item List</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Tax</th>
                                        <th>Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><div><strong>Admin Theme with psd project layouts</strong></div>
                                            <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small></td>
                                        <td>1</td>
                                        <td>$26.00</td>
                                        <td>$5.98</td>
                                        <td>$31,98</td>
                                    </tr>
                                    <tr>
                                        <td><div><strong>Wodpress Them customization</strong></div>
                                            <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                                Eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                            </small></td>
                                        <td>2</td>
                                        <td>$80.00</td>
                                        <td>$36.80</td>
                                        <td>$196.80</td>
                                    </tr>
                                    <tr>
                                        <td><div><strong>Angular JS & Node JS Application</strong></div>
                                            <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small></td>
                                        <td>3</td>
                                        <td>$420.00</td>
                                        <td>$193.20</td>
                                        <td>$1033.20</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /table-responsive -->
                                </div>
                            </div>

                            <div class="table-responsive m-t">
                                <table class="table Payslip-table">
                                    <thead>
                                    <tr>
                                        <th>Item List</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Tax</th>
                                        <th>Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><div><strong>Admin Theme with psd project layouts</strong></div>
                                            <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small></td>
                                        <td>1</td>
                                        <td>$26.00</td>
                                        <td>$5.98</td>
                                        <td>$31,98</td>
                                    </tr>
                                    <tr>
                                        <td><div><strong>Wodpress Them customization</strong></div>
                                            <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                                Eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                            </small></td>
                                        <td>2</td>
                                        <td>$80.00</td>
                                        <td>$36.80</td>
                                        <td>$196.80</td>
                                    </tr>
                                    <tr>
                                        <td><div><strong>Angular JS & Node JS Application</strong></div>
                                            <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small></td>
                                        <td>3</td>
                                        <td>$420.00</td>
                                        <td>$193.20</td>
                                        <td>$1033.20</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /table-responsive -->

                            <table class="table Payslip-total">
                                <tbody>
                                <tr>
                                    <td><strong>Sub Total :</strong></td>
                                    <td>$1026.00</td>
                                </tr>
                                <tr>
                                    <td><strong>TAX :</strong></td>
                                    <td>$235.98</td>
                                </tr>
                                <tr>
                                    <td><strong>TOTAL :</strong></td>
                                    <td>$1261.98</td>
                                </tr>
                                </tbody>
                            </table>

                            <div class="well m-t"><strong>Comments</strong>
                                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </br></br>

<?php $this->load->view('footer'); ?>