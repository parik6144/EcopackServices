<?php
$this->load->view('header');
$this->load->view('left_sidebar');
$this->load->view('topbar');
?>
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <style>
            td{
                border:1px solid #000000;
            }
            .logo{
                width:25%;
            }
            .description{
                height:200px;
            }
            .item{
                border-right: none;
                text-align: center;
            }
            .item_border{
                border-bottom: 0px solid !important;
                text-align: center;
                /*border-right: 0px solid;*/
            }
            td,.noborder{
                border-bottom: ;
                text-align: center;
            }
        </style>
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->

                <!-- BEGIN PAGE BAR -->
                <div class="page-bar">
                    <ul class="page-breadcrumb">
                        <li>
                            <a href="#"></a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span>Tax Invoice</span>
                        </li>
                    </ul>
                </div>
                <!-- END PAGE BAR -->

                <!-- END PAGE HEADER-->
                <br>

                <!-- For Recipients -->
                <div class="invoice1">
                    <table style="width: 1021px; height: 95%; float: left;">
                        <tr>
                            <td colspan="5" style="text-align:center;">
                                <div class="col-xs-12 text-center">
                                    <span style="margin-left: 125px"><b>Tax Invoice</b></span>
                                    <span style="float: right">Original :For Customer</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p> <strong style="font-size: 20px;">Moonka Automobiles</strong><br>
                                    Panna Tower,Station Road,<br>
                                    Jugsalai,Jamshedpur<br>Jharkhand-831006<br>
                                    E-Mail : moonkaautomobiles@yahoo.com<br>
                                    Phone : 657-2290436/6537842<br>
                                    GSTIN : 20AADFM4285C1ZS<br>
                                    PAN : AADFM4285C<br>
                                    State Code :20</br>
                                </p>
                            </td>

                            <td>

                            <td class="logo" style="padding: 15px; text-align: left">
                                <table style="float: left;">
                                    <tbody>
                                    <tr><div>Buyer :&nbsp; <strong>MD. MOJIB ASHRAF</strong></div></tr>
                                    <tr><div>Address :&nbsp; <strong>MANGO</strong></div></tr>
                                    <tr><div>City :&nbsp; <strong>JAMSHEDPUR</strong></div></tr>
                                    <tr><div>Pincode :&nbsp; <strong>832110</strong></tr>
                                    <tr><div>Email :&nbsp; <strong></strong></div></tr>
                                    <tr><div>Contact :&nbsp; <strong>0</strong></div></tr>
                                    <tr><div>GSTIN :&nbsp; <strong></strong></div></tr>
                                    <tr><div>PAN :&nbsp; <strong></strong></div></tr>
                                    <tr><div>State :&nbsp;<strong>Jharkhand</strong></div></tr>
                                    </tbody>
                                </table>
                            </td>
                            </td>





                            <td class="logo" style="padding: 10px; text-align: left">
                                <table style="float: left;">
                                    <tbody>
                                    <tr><div>Invoice NO :<strong>MA/AC/1920/00001</strong></div></tr>
                                    <tr><div>Supplier's Ref :<strong>MA/AC/1920/00001</strong></div></tr>
                                    <tr><div>Date : &nbsp;&nbsp;<strong>01-04-2019</strong></div></tr>
                                    <tr><div>Delivery Note :<strong></strong></div></tr>
                                    <tr><div style="display:none">Payment mode :<strong>Cash</strong></div></tr>
                                    <tr><div>State Code :&nbsp;<strong>20</strong></div></tr>
                                    <tr><div>Place of Delivery :&nbsp;<strong>Jamshedpur</strong></div></tr>
                                    </tbody>
                                </table>
                            </td>
                            <td class="logo">
                                <img src="logo.png"></img><br>
                                website : moonkahonda.com
                            </td>
                        </tr>
                    </table>

                    <table style="width: 1021px; height: 95%; float: left;">
                        <tbody>
                        <tr style="height: 32px;">
                            <td style="width: 54px; height: 32px; padding: 10px;">Sl.No.</td>
                            <td style="width: 226px; height: 32px; padding: 10px;">Description of Goods</td>
                            <td style="width: 44px; height: 32px; padding: 10px;">HSN/SAC</td>
                            <td style="width: 67px; height: 32px; padding: 10px;">Unit Price</td>
                            <td style="width: 63px; height: 32px; padding: 10px;">Quantity</td>
                            <td style="width: 47px; height: 32px; padding: 10px;">Uom</td>

                            <td style="width: 117px;" colspan="2">Discount
                                <table>
                                    <tr>
                                        <td style="width:126px;border left: none;border-bottom: none;border-left: none;">&nbsp;Rate&nbsp;</td>
                                        <td style="width:126px;border left: none;border-bottom: none;border-left: none;border-right: none;">&nbsp;Amt&nbsp;</td>
                                    </tr>
                                </table>
                            </td>

                            <td style="width: 47px; height: 32px; padding: 10px;">Taxable Amt.</td>

                            <td style="width: 117px;" colspan="2">CGST Tax
                                <table>
                                    <tr>
                                        <td style="width:126px;border left: none;border-bottom: none;border-left: none;">Rate</td>
                                        <td style="width:126px;border left: none;border-bottom: none;border-left: none;border-right: none;">Amt</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 117px;" colspan="2">&nbsp;SGST Tax
                                <table>
                                    <tr>
                                        <td style="width:126px;border left: none;border-bottom: none;border-left: none;"><span>Rate</span></td>
                                        <td style="width:126px;border left: none;border-bottom: none;border-left: none;border-right: none;"><span>Amt</span></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 117px;" colspan="2">&nbsp;IGST Tax
                                <table>
                                    <tr>
                                        <td style="width:126px;border left: none;border-bottom: none;border-left: none;">&nbsp;Rate&nbsp;</td>
                                        <td style="width:126px;border left: none;border-bottom: none;border-left: none;border-right: none;">&nbsp;Amt&nbsp;</td>
                                    </tr>
                                </table>
                            </td>

                            <td style="width: 69px; height: 32px; padding: 10px;">Amount</td>
                        </tr>
                        <tr>
                            <td class="noborder">1</td>
                            <td class="item">&nbsp;All Round Guard Set-Dio&nbsp;</td>
                            <td class="item">&nbsp;87141090&nbsp;</td>
                            <td class="item">&nbsp;1412.50&nbsp;</td>
                            <td class="item">&nbsp;1&nbsp;</td>
                            <td class="item">&nbsp;Nos.</td>
                            <td class="item">&nbsp;20%&nbsp;</td>
                            <td class="item">&nbsp;282.50&nbsp;</td>
                            <td class="item">&nbsp;1130.00&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;158.20&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;158.20&nbsp;</td>
                            <td class="item">&nbsp;0.00%&nbsp;</td>
                            <td class="item">&nbsp;0.00&nbsp;</td>
                            <td>1446.4</td>
                        </tr>
                        <tr>
                            <td class="noborder">2</td>
                            <td class="item">&nbsp;Side Stand&nbsp;</td>
                            <td class="item">&nbsp;87141090&nbsp;</td>
                            <td class="item">&nbsp;260.16&nbsp;</td>
                            <td class="item">&nbsp;1&nbsp;</td>
                            <td class="item">&nbsp;Nos.</td>
                            <td class="item">&nbsp;20%&nbsp;</td>
                            <td class="item">&nbsp;52.03&nbsp;</td>
                            <td class="item">&nbsp;208.13&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;29.14&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;29.14&nbsp;</td>
                            <td class="item">&nbsp;0.00%&nbsp;</td>
                            <td class="item">&nbsp;0.00&nbsp;</td>
                            <td>266.41</td>
                        </tr>
                        <tr>
                            <td class="noborder">3</td>
                            <td class="item">&nbsp;Foot Rest&nbsp;</td>
                            <td class="item">&nbsp;87141090&nbsp;</td>
                            <td class="item">&nbsp;649.22&nbsp;</td>
                            <td class="item">&nbsp;1&nbsp;</td>
                            <td class="item">&nbsp;Nos.</td>
                            <td class="item">&nbsp;20%&nbsp;</td>
                            <td class="item">&nbsp;129.84&nbsp;</td>
                            <td class="item">&nbsp;519.38&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;72.71&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;72.71&nbsp;</td>
                            <td class="item">&nbsp;0.00%&nbsp;</td>
                            <td class="item">&nbsp;0.00&nbsp;</td>
                            <td>664.8</td>
                        </tr>
                        <tr>
                            <td class="noborder">4</td>
                            <td class="item">&nbsp;Mat - Dio&nbsp;</td>
                            <td class="item">&nbsp;87141090&nbsp;</td>
                            <td class="item">&nbsp;136.71&nbsp;</td>
                            <td class="item">&nbsp;1&nbsp;</td>
                            <td class="item">&nbsp;Nos.</td>
                            <td class="item">&nbsp;20%&nbsp;</td>
                            <td class="item">&nbsp;27.34&nbsp;</td>
                            <td class="item">&nbsp;109.37&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;15.31&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;15.31&nbsp;</td>
                            <td class="item">&nbsp;0.00%&nbsp;</td>
                            <td class="item">&nbsp;0.00&nbsp;</td>
                            <td>139.99</td>
                        </tr>
                        <tr>
                            <td class="noborder">5</td>
                            <td class="item">&nbsp;Grip Cover&nbsp;</td>
                            <td class="item">&nbsp;87141090&nbsp;</td>
                            <td class="item">&nbsp;43.75&nbsp;</td>
                            <td class="item">&nbsp;1&nbsp;</td>
                            <td class="item">&nbsp;Nos.</td>
                            <td class="item">&nbsp;20%&nbsp;</td>
                            <td class="item">&nbsp;8.75&nbsp;</td>
                            <td class="item">&nbsp;35.00&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;4.90&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;4.90&nbsp;</td>
                            <td class="item">&nbsp;0.00%&nbsp;</td>
                            <td class="item">&nbsp;0.00&nbsp;</td>
                            <td>44.8</td>
                        </tr>
                        <tr>
                            <td class="noborder">6</td>
                            <td class="item">&nbsp;Number Plate&nbsp;</td>
                            <td class="item">&nbsp;87141090&nbsp;</td>
                            <td class="item">&nbsp;39.06&nbsp;</td>
                            <td class="item">&nbsp;2&nbsp;</td>
                            <td class="item">&nbsp;Nos.</td>
                            <td class="item">&nbsp;20%&nbsp;</td>
                            <td class="item">&nbsp;15.62&nbsp;</td>
                            <td class="item">&nbsp;62.50&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;8.75&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;8.75&nbsp;</td>
                            <td class="item">&nbsp;0.00%&nbsp;</td>
                            <td class="item">&nbsp;0.00&nbsp;</td>
                            <td>80</td>
                        </tr>
                        <tr>
                            <td class="noborder">7</td>
                            <td class="item">&nbsp;Kick Rubber&nbsp;</td>
                            <td class="item">&nbsp;87141090&nbsp;</td>
                            <td class="item">&nbsp;15.62&nbsp;</td>
                            <td class="item">&nbsp;1&nbsp;</td>
                            <td class="item">&nbsp;Nos.</td>
                            <td class="item">&nbsp;20%&nbsp;</td>
                            <td class="item">&nbsp;3.12&nbsp;</td>
                            <td class="item">&nbsp;12.50&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;1.75&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;1.75&nbsp;</td>
                            <td class="item">&nbsp;0.00%&nbsp;</td>
                            <td class="item">&nbsp;0.00&nbsp;</td>
                            <td>16</td>
                        </tr>
                        <tr>
                            <td class="noborder">8</td>
                            <td class="item">&nbsp;Bumfer Guard-4g&nbsp;</td>
                            <td class="item">&nbsp;87141090&nbsp;</td>
                            <td class="item">&nbsp;296.87&nbsp;</td>
                            <td class="item">&nbsp;1&nbsp;</td>
                            <td class="item">&nbsp;Nos.</td>
                            <td class="item">&nbsp;24%&nbsp;</td>
                            <td class="item">&nbsp;72.44&nbsp;</td>
                            <td class="item">&nbsp;224.43&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;31.42&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;31.42&nbsp;</td>
                            <td class="item">&nbsp;0.00%&nbsp;</td>
                            <td class="item">&nbsp;0.00&nbsp;</td>
                            <td>287.27</td>
                        </tr>
                        <tr>
                            <td class="noborder">9</td>
                            <td class="item">&nbsp;Seat Cover-act-5G&nbsp;</td>
                            <td class="item">&nbsp;87141090&nbsp;</td>
                            <td class="item">&nbsp;214.84&nbsp;</td>
                            <td class="item">&nbsp;1&nbsp;</td>
                            <td class="item">&nbsp;Nos.</td>
                            <td class="item">&nbsp;20%&nbsp;</td>
                            <td class="item">&nbsp;42.97&nbsp;</td>
                            <td class="item">&nbsp;171.87&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;24.06&nbsp;</td>
                            <td class="item">&nbsp;14.00%&nbsp;</td>
                            <td class="item">&nbsp;24.06&nbsp;</td>
                            <td class="item">&nbsp;0.00%&nbsp;</td>
                            <td class="item">&nbsp;0.00&nbsp;</td>
                            <td>219.99</td>
                        </tr>



                        <tr>
                            <td class="item" colspan="15"> <strong>Total ( with Round off )</strong></td>
                            <td><strong>3166</strong></td>
                        </tr>

                        <td colspan="16">Amount chargable in Word: <strong>INR three thousand, one hundred sixty-six Only </strong></td>
                        </tbody>
                    </table>

                    <table style="width: 1021px; height: 95%; float: left;">
                        <tbody>
                        <tr>
                            <td style="width: 116px;">&nbsp;HSN/SAC</td>
                            <td style="width: 117px;">Taxable value</td>
                            <td style="width: 117px;" colspan="2">Central Tax
                                <table>
                                    <tr>
                                        <td style="width:126px;">Rate</td>
                                        <td style="width:127px;">Amt</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 117px;" colspan="2">&nbsp;State Tax
                                <table>
                                    <tr>
                                        <td style="width:126px;">Rate</td>
                                        <td style="width:129px;">Amt</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 117px;" colspan="2">&nbsp;IGST Tax
                                <table>
                                    <tr>
                                        <td style="width:126px;">Rate</td>
                                        <td style="width:128px;">Amt</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 116px;">&nbsp;87141090</td>
                            <td style="width: 117px;">2473.18</td>
                            <td style="width: 116px;">&nbsp;14.00%</td>
                            <td style="width: 117px;">346.24</td>
                            <td style="width: 116px;">&nbsp;14.00%</td>
                            <td style="width: 117px;">346.24</td>
                            <td style="width: 116px;">&nbsp;0.00%</td>
                            <td style="width: 117px;">0.00</td>
                        </tr>

                        <tr>
                            <td colspan="8" style="width: 927px;">Total Tax Amount(in words):<strong>INR six hundred ninety-two and four nine paise  Only </strong></td>
                        </tr>
                        </tbody>
                    </table>

                    <table style="width: 1021px; height: 95%; float: left;">
                        <tbody>
                        <tr>
                            <td style="width: 927px; text-align: left">
                                <b>Declaration:</b>
                                <div>1.) WE declare that this invoice shows that actual price of the goods describe and that all particulars are true and correct.</div>
                                <div>2.) All disputes are subject to jamshedpur Jurisdiction.</div>
                            </td>
                            <td style="width: 927px;">
                                <strong>For Moonka Automobiles</strong>
                                <p>&nbsp;</p>
                                <p>Authorised Signatory</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-xs-12 text-center">
                            This is Computer Generated Invoice
                        </div>
                    </div>
                </div>
                </br></br></br>
                <!-- For Recipients -->

            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

<?php $this->load->view('footer'); ?>

</body>
</html>



