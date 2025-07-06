<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 11/08/2017
 * Time: 12:36
 */
?>
<div id="page-wrapper" class="gray-bg">

<div class="row border-bottom">
        <nav class="navbar navbar-fixed-top  " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Hi <span style="text-transform: capitalize;"><?=$this->session->userdata('full_name')?></span>&nbsp;&nbsp;,&nbsp;Welcome to Ecopack Services PVT LTD.</span>
                </li>
                <li class="dropdown">
                    

                <li>
                    <a href="<?=base_url('logout')?>">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
