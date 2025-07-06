<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 11/08/2017
 * Time: 12:27
 */
$str="";
$str1="";
$str7='';
if($this->session->userdata('user_id') != '1' && $this->session->userdata('user_id') != '2' && $this->session->userdata('user_id') != '4')
    $str="style='display:none;'";
if($this->session->userdata('user_id') == '4')
    $str1="style='display:none;'";
if($this->session->userdata('user_id') == '11')
    $str2="style='display:none;'";
if($this->session->userdata('user_id') == '12')
    $str3="style='display:none;'";
 if($this->session->userdata('user_id') == '13')
 {
     $str4="style='display:none;'";
     $str7="style='display:block'";
 }
 
  if($this->session->userdata('user_id') == '7')
 {
     $str10="style='display:block'";
 }
 
 if($this->session->userdata('user_id') == '15'){
     $str7="style='display:none;'";
     $str8="style='display:block'";
 }
 
  if($this->session->userdata('user_id') == '14' || $this->session->userdata('user_id') == '15'){
     $str7="style='display:none;'";
     $str18="style='display:block'";
 }


 
  if($this->session->userdata('user_id') == '16' && $this->session->userdata('user_id') == '15' && $this->session->userdata('user_id') == '03'){
     $str9="style='display:none;'";
 }
    
    $str5="style='display:block;'";
?>


<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="Ecopack" class="" src="<?php echo site_url();?>uploads/EcoPack1.png" style="width:100%;" />
                </div>
                <div class="logo-element">
                    EcoPack
                </div>
            </li>
            <?php
            if($this->session->userdata('user_id') != '8')
            {
                ?>
                <?php
            if($this->session->userdata('user_id') == '1')
            {
                $month=date('m');
                $year=date('Y');
                ?>
                <li><a href="<?php echo site_url('Dashboard?')."m=".$month."&y=".$year; ?>">Dashboard</a></li>
                <?php
            }
            ?>
            <li class="" <?=$str.$str1.$str4?> <?=$str7.$str9?>>

                    <a href="#"><i class="fa fa-bar-chart-o"></i> Master<span class="fa arrow"></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                        <li <?=$str.$str1?>>
                            <a href="<?php echo site_url('branch'); ?>" ><i class="fa fa-marker"></i>Branch</a>
                        </li>
                        <li <?=$str.$str1?>>
                            <a href="<?php echo site_url('place'); ?>" ><i class="fa fa-marker"></i>Place</a>
                        </li>
                        <li <?=$str.$str1?>>
                            <a href="<?php echo site_url('consignee_billing'); ?>"><i class="fa fa-envelope-open-o"></i>Billing Address Consigneee</a>
                        </li>
                        <li <?=$str.$str1?>>
                            <a href="<?php echo site_url('consignee'); ?>"><i class="fa fa-building-o"></i>Consignee</a>
                        </li>
                        <li <?=$str.$str1?>>
                            <a href="<?php echo site_url('consignor'); ?>"><i class="fa fa-building-o"></i>Consignor</a>
                        </li>
                        <li <?=$str.$str1?>>
                            <a href="<?php echo site_url('warehouse'); ?>"><i class="fa fa-building-o"></i>warehouse</a>
                        </li>
                        <li <?=$str.$str1?>>
                            <a href="<?php echo site_url('orderno'); ?>"><i class="fa fa-building-o"></i>Order No</a>
                        </li>
                    </ul>
                </li>
                
                <li class="" <?=$str7.$str9?>>
                    <a href="#"><i class="fa fa-bar-chart-o"></i> HR<span class="fa arrow"></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                        <li <?=$str7.$str.$str1.$str9?>>
                            <a href="<?php echo site_url('employee'); ?>"><i class="fa fa-user"></i>Staff</a>
                        </li>
                        <li <?=$str7.$str.$str1?>>
                            <a href="<?php echo site_url('inwardemployee'); ?>"><i class="fa fa-user"></i>Inward Employee</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('employee_type'); ?>"><i class="fa fa-user"></i>Department</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('designations'); ?>"><i class="fa fa-user"></i>Designations</a>
                        </li>
                        <li <?=$str9?>>
                            <a href="<?php echo site_url('staff'); ?>"><i class="fa fa-user"></i>Employee</a>
                        </li>
                        <li <?=$str7.$str.$str7?>>
                            <a href="<?php echo site_url('employee_salary'); ?>"><i class="fa fa-user"></i>Salary List</a>
                        </li>
                         <li <?=$str7.$str.$str7?>>
                            <a href="<?php echo site_url('holiday'); ?>"><i class="fa fa-user"></i>Holiday List</a>
                        </li>
                         <li <?=$str7.$str.$str7?>>
                            <a href="<?php echo site_url('working_day'); ?>"><i class="fa fa-user"></i>Other Working Day</a>
                        </li>
                        <li <?=$str7.$str.$str7?>>
                            <a href="<?php echo site_url('advance_salary'); ?>"><i class="fa fa-user"></i>Advance Salary</a>
                        </li>
                        
                         <li <?=$str7.$str.$str7?>>
                            <a href="<?php echo site_url('Attendance'); ?>"><i class="fa fa-user"></i>Attendance</a>
                        </li>
                    </ul>
                </li>
                
                <li class="" <?php if($this->session->userdata('user_id') != '15'){ echo "style='display:none;'"; } ?>>
                    <a href="#"><i class="fa fa-signal"></i> Finance <span class="fa arrow"></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                        <li>
                            <a href="<?php echo site_url('invoice'); ?>"><i class="fa fa-car"></i>Invoice</a>
                        </li>
                    </ul>
                </li>

                <li class="" <?=$str7.$str2.$str3.$str4?> <?=$str7.$str9?>>
                    <a href="#"><i class="fa fa-bar-chart-o"></i>Finance<span class="fa arrow"></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                        <li <?=$str.$str1?>>
                            <a href="<?php echo site_url('account'); ?>"><i class="fa fa-building-o"></i>Account</a>
                        </li>
                        <li <?=$str.$str1?>>
                            <a href="<?php echo site_url('invoicetype'); ?>"><i class="fa fa-inventory"></i>Invoice Type</a>
                        </li>
                        <li <?=$str.$str1?>>
                            <a href="<?php echo site_url('inwardrate'); ?>"><i class="fa fa-inr"></i>Inward Rate</a>
                        </li>
                        <li <?=$str.$str1?>>
                            <a href="<?php echo site_url('outwardrate'); ?>"><i class="fa fa-inr"></i>Outward vehicle Rate</a>
                        </li>
                        <li <?=$str.$str1?>>
                            <a href="<?php echo site_url('transport_invoice_rate'); ?>"><i class="fa fa-inr"></i>Transport Invoice Rate</a>
                        </li>
                        <li <?=$str.$str1?>>
                            <a href="<?php echo site_url('labor_invoice_rate'); ?>"><i class="fa fa-inr"></i>Labor Invoice Rate</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('invoice'); ?>"><i class="fa fa-car"></i>Invoice</a>
                        </li>
                        <li <?=$str?>>
                            <a href="<?php echo site_url('expense_head'); ?>"><i class="fa fa-inr"></i>Expense Head</a>
                        </li>
                        <li <?=$str7.$str?>>
                            <a href="<?php echo site_url('payment_booking'); ?>"><i class="fa fa-inr"></i>Expense Booking</a>
                        </li>
						<li <?=$str?>>
                            <a href="<?php echo site_url('booking_transfer'); ?>"><i class="fa fa-inr"></i>Due Booking Payment</a>
                        </li>
                        <li <?=$str.$str1.$str10?>>
                            <a href="<?php echo site_url('pending_advance'); ?>"><i class="fa fa-arrow-up"></i>Advance Pending</a>
                        </li>
                        <li <?=$str.$str10?>>
                            <a href="<?php echo site_url('pending_due'); ?>"><i class="fa fa-arrow-up"></i>Due Pending</a>
                        </li>
                        <li <?=$str?>>
                            <a href="<?php echo site_url('ledger'); ?>"><i class="fa fa-arrow-up"></i>Ledger</a>
                        </li>
						<li <?=$str?>>
                            <a href="<?php echo site_url('invoice/getbookdebts'); ?>"><i class="fa fa-arrow-up"></i>Bookdebts</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('receipt'); ?>"><i class="fa fa-arrow-up"></i>Receipt</a>
                        </li>
                        <li <?=$str?>>
                            <a href="<?php echo site_url('loan'); ?>"><i class="fa fa-arrow-up"></i>Loan</a>
                        </li>

                        <li <?=$str?>>
                            <a href="<?php echo site_url('loan_pending'); ?>"><i class="fa fa-arrow-up"></i>Loan Booking Pending</a>
                        </li>
                        <li <?=$str?>>
                            <a href="<?php echo site_url('tds'); ?>"><i class="fa fa-arrow-up"></i>TDS</a>
                        </li>
                        
                    </ul>
                </li>

                <li class="" <?=$str4?> <?=$str8.$str9?>>
                    <a href="#"><i class="fa fa-bar-chart-o"></i>AMS<span class="fa arrow"></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                        
                        <li <?=$str1?><?=$str8?>>
                            <a href="<?php echo site_url('itemmaster'); ?>"><i class="fa fa-inventory"></i>Ecopack Item Master</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('item'); ?>"><i class="fa fa-inventory"></i>CO. Wise Item</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('rentitem'); ?>"><i class="fa fa-inventory"></i>Rent Invoice Item</a>
                        </li>
                        <!-- <li <?=$str1?>>
                            <a href="<?php echo site_url('purchase_stock_item'); ?>"><i class="fa fa-inventory"></i>Fixed Assets Item</a>
                        </li> -->
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('rentwarehouse'); ?>"><i class="fa fa-inventory"></i>Rent Ware House</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('stocktransfer'); ?>"><i class="fa fa-inventory"></i>Stock Transfer</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('rentstocktransfer'); ?>"><i class="fa fa-inventory"></i>Rent Stock Transfer</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('asign_rent_item'); ?>"><i class="fa fa-inventory"></i>Assign Stock</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('asset_lost'); ?>"><i class="fa fa-inventory"></i>Asset Lost/Damage</a>
                        </li>
                    </ul>
                </li>
            
            <li class="" <?=$str4?> <?=$str8?>>
                    <a href="#"><i class="fa fa-bar-chart-o"></i> Operation<span class="fa arrow"></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
            
                        <li <?=$str.$str1?>>
                            <a href="<?php echo site_url('vehicletype'); ?>"><i class="fa fa-car"></i>Vehicle Type</a>
                        </li>            
                        
                        <li <?=$str.$str1?>>
                            <a href="<?php echo site_url('inwardowner'); ?>"><i class="fa fa-user"></i>Owner</a>
                        </li>
                        
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('vehicle_inward'); ?>"><i class="fa fa-car"></i>Vehicle</a>
                        </li>
                        
                        
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('inward'); ?>"><i class="fa fa-download"></i>Inward</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('consignment'); ?>"><i class="fa fa-arrow-up"></i>Consignment</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('pending_consignment'); ?>"><i class="fa fa-arrow-up"></i>Consignment Pending</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('contactDetails'); ?>"><i class="fa fa-building-o"></i>Contact Details</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('other_item'); ?>"><i class="fa fa-building-o"></i>Other Item</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('other_item_stock'); ?>"><i class="fa fa-building-o"></i>Other Item Stock</a>
                        </li>

                        <li <?=$str1?>>
                            <a href="<?php echo site_url('diesel_expense'); ?>"><i class="fa fa-building-o"></i>Diesel Expense</a>
                        </li>
                    </ul>
            </li>
            
            <li class="" <?=$str4?> <?=$str8.$str9?>>
                    <a href="#"><i class="fa fa-bar-chart-o"></i> Reports<span class="fa arrow"></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('stock_report'); ?>"><i class="fa fa-inventory"></i>Stock Report</a>
                        </li>
                         <li <?=$str1?>>
                            <a href="<?php echo site_url('co_stock_report'); ?>"><i class="fa fa-inventory"></i>Rent Stock Report</a>
                        </li>
                         <li <?=$str1?>>
                            <a href="<?php echo site_url('item_wise_report'); ?>"><i class="fa fa-inventory"></i>Item Wise Report</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('warehouse_wise_report'); ?>"><i class="fa fa-inventory"></i>IDLE Stock</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('followup'); ?>"><i class="fa fa-car"></i>Vehicle followup</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('followup_report'); ?>"><i class="fa fa-car"></i>followup Report</a>
                        </li>
                        <li <?=$str?>>
                            <a href="<?php echo site_url('driver_report'); ?>"><i class="fa fa-car"></i>Driver Report</a>
                        </li>
                        <li <?=$str?>>
                            <a href="<?php echo site_url('owner_report'); ?>"><i class="fa fa-car"></i>Owner Report</a>
                        </li>
                        
                        <li <?=$str?>>
                            <a href="<?php echo site_url('employee_report'); ?>"><i class="fa fa-car"></i>Employee Report</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('advance_payment'); ?>"><i class="fa fa-arrow-up"></i>Advance Payment</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('due_payment'); ?>"><i class="fa fa-arrow-up"></i>Due Payment</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('consignment_report'); ?>"><i class="fa fa-arrow-up"></i>Consignment Record</a>
                        </li>
                        <li <?=$str1?>>
                            <a href="<?php echo site_url('place_report'); ?>"><i class="fa fa-arrow-up"></i>Place Report</a>
                        </li>
                        <li <?=$str?>>
                            <a href="<?php echo site_url('invoice_report'); ?>"><i class="fa fa-car"></i>Invoice</a>
                        </li>
                        <li <?=$str?>>
                            <a href="<?php echo site_url('gst_report'); ?>"><i class="fa fa-car"></i>GST Report</a>
                        </li>
                    </ul>
                </li>
                
                <li <?=$str2.$str3?> <?=$str4?> <?=$str8.$str9?>>
                     <a href="#"><i class="fa fa-bar-chart-o"></i> Marketing<span class="fa arrow"></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                        <li>
                            <a href="<?php echo site_url('project'); ?>"><i class="fa fa-building-o"></i>New Project</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('project/ongoing'); ?>"><i class="fa fa-building-o"></i>Ongoing Project</a>
                        </li>
                    </ul>
                </li>

            
            <?php
                            if($this->session->userdata('user_id')=='2')
                            {
                                /*code for ravi*/
                                ?>
                             <li><a href="<?php echo site_url('monthly_booking_list'); ?>">Booking List</a></li>
                            <?php
                            }
                        ?>
            <li>
                <a href="https://ecopackservices.com:2096/" target="_blank">Email Login</a>
            </li>
            <?php

            }
            else
            {
            ?>
            <li><a href="<?php echo site_url('invoice_report'); ?>">Invoice</a></li>
            <li><a href="<?php echo site_url('ledger'); ?>">Ledger</a></li>
            <li><a href="<?php echo site_url('monthly_booking_list'); ?>">Booking List</a></li>
            <?php
            }
            ?>
            
            <li>
                <a href="#"><i class="fa fa-cogs"></i> Setting<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li>
                        <a href="<?php echo site_url('Setting/access');?>"><i class='fa fa-cogs'></i>Access Module</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
