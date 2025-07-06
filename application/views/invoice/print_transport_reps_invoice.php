<?php

function getIndianCurrency(float $number)

{

    $decimal = round($number - ($no = floor($number)), 3) * 100;

    

    $hundred = null;

    $digits_length = strlen($no);

    $i = 0;

    $str = array();

    $words = array(0 => '', 1 => 'one', 2 => 'two',

        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',

        7 => 'seven', 8 => 'eight', 9 => 'nine',

        10 => 'ten', 11 => 'eleven', 12 => 'twelve',

        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',

        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',

        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',

        40 => 'forty', 50 => 'fifty', 60 => 'sixty',

        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');

    $digits = array('', 'hundred','thousand','lakh', 'crore');

    while( $i < $digits_length ) {

        $divider = ($i == 2) ? 10 : 100;

        $number = floor($no % $divider);

        $no = floor($no / $divider);

        $i += $divider == 10 ? 1 : 2;

        if ($number) {

            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;

            $hundred = ($counter == 1 && $str[0]) ? ' ' : null;

            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;

        } else $str[] = null;

    }

    $Rupees = implode('', array_reverse($str));

  $paise="";

  if($decimal>0)

    {

      $paise="and " .$words[(floor($decimal/10)*10)]." ".$words[$decimal%10];

    }

                        //$paise = ($decimal) ? "and " . ($words[floor($decimal)] . " " . $words[$decimal%10]) . ' Paise' : '';

    if(!empty($paise))

      return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise." Paise only";

    else

      return ($Rupees ? $Rupees . 'Rupees ' : '')." Only";

}

?>



<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">



</head>

<body>

<style type="text/css">

.tg  {border-collapse:collapse;border-spacing:0;}

.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}

.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}

.tg .tg-l711{border-color:inherit}

.tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}

.tg .tg-us36{border-color:inherit;vertical-align:top}

.tg .tg-dvpl{border-color:inherit;text-align:right;vertical-align:top}

@media all {

  .page-break { display: none; }

}



@media print {

  .page-break { display: block; page-break-before: always; }

}

</style>

<table class="tg" style="width:100%;">

  <tr>

    <th class="tg-us36" colspan="7">TAX INVOICE</th>

  </tr>

  <tr>

    <td class="tg-us36" colspan="3" rowspan="1" style="width:40%;">

	<img src="<?=base_url('uploads/')?>EcoPack.jpg" width="150px"/>

	<br/>

	<strong>ECOPACK SERVICES PVT LTD</strong><br>H.No-15A,A-road,Zone No-<br>1B,Birsanagar,telco,Jamshedpur<br>Jharkhand,pin-831019 STATE CODE :-20<br/>Email-saroj@ecopackservices.com<br><strong>GST No-20AAECE1697G1ZV</strong>

  <br>

  <?php 

    $long = array(

      '',

  'December',

  'January', 

  'February', 

  'March', 

  'April', 

  'May', 

  'June', 

  'July', 

  'August', 

  'September', 

  'October',

  'November'

);

    if(!empty($record['invoice']->vendor_code))

      echo "Vendor Code:- ".$record['invoice']->vendor_code;

    ?>

    <br>

  <?php 

    if(!empty($record['invoice']->order_no))

      echo "Order No:- ".$record['invoice']->order_no;
    ?>



	</td>

    <td class="tg-us36" colspan="3" style="padding-top:34px;">Billed to : 

    <strong><?=$record['consignee']->consignee_name."</strong>,<br/>

    ".$record['consignee']->address.",<br/>

    ".$record['consignee']->city.",

    ".$record['consignee']->state.",

    ".$record['consignee']->pincode.",

     State Code : ".$record['consignee']->state_code."<br/>".

     "<strong>GST No-".$record['consignee']->gstin."</strong><br/>"?>

	 </td>

    <!-- <td class="tg-us36" colspan="2"><strong>Invoice No:- <?=$record['invoice']->invoice_no?></strong></td> -->

    <td class="tg-us36" colspan="2" style="width:20%;"><strong>Date:- <?=date('d-m-Y',strtotime($record['invoice']->invoice_date))?></strong></td>

  </tr>

  <tr>

    <td class="tg-us36" colspan="3">Dispatch Details: Annexure 1, 

      <?php

        if(isset($record['location']))

        {
          echo $record['location']->source."-".$record['location']->destination;
          echo $record['location']->source_id."-".$record['location']->destination_id;

        }
        else
        {
          echo "JAMSHEDPUR LOCAL";
        }
        if(($record['invoice']->invoice_date)>'2019-01-30')
        {
          $monthnum=date("n",strtotime($record['invoice']->invoice_date));
          echo ", ".$long[$monthnum+1];
        }
        else
          echo ", ".$long[date("n",strtotime($record['invoice']->invoice_date))];

      ?>

    </td>

    <td class="tg-us36" colspan="3"><strong>Invoice No:- <?=$record['invoice']->invoice_no?></strong></td>

    <td class="tg-us36"><strong>Transportation</strong></td>

  </tr>

  

  <tr>

    <td class="tg-c3ow">Sl.No.</td>

    <td class="tg-c3ow">Description of Goods</td>

    <td class="tg-c3ow">HSN CODE</td>

    <td class="tg-c3ow">GST RATE</td>

    <td class="tg-c3ow">Qty (pcs)</td>

    <td class="tg-c3ow">Rate</td>

    <td class="tg-c3ow">Amount (in Rs)</td>

  </tr>

  <?php

  $total=0;

  $ctr=1;

  $tempqty=0;

  $tempprice=0;

  $tblnm="";



  foreach ($record['item'] as $row) {

    if(($row['ref_table_name']=="tbl_vehicle_inward") && ($row['item_id']=='10' || $row['item_id']=='11') && $record['invoice']->billing_address_id=='2' )

      {

        $tempqty+=$row['qty'];

        $tempprice=$row['price'];

      }

      else

      {

    ?>

  <tr>

    <td class="tg-c3ow"><?=$ctr?></td>

    <td  class="tg-c3ow">Transportation & Loading Unloading</td>

      

    

    <td class="tg-c3ow"><?=$record['tax_details']->hsn_code?></td>

    <td class="tg-c3ow"><?=$row['gst_rate']?>%</td>

    <td class="tg-c3ow tg-dvpl"><?=$row['qty']?></td>

    <td class="tg-c3ow tg-dvpl"><?=$row['price']?></td>

    <td class="tg-dvpl"><?=$row['qty']*$row['price']?></td>

  </tr>

  <?php

    $ctr++;

    }

    

    $total+=$row['qty']*$row['price'];

    

  }

  if($tempqty>0)

  {

    ?>

    <td class="tg-c3ow"><?=$ctr?></td>

    <td class="tg-c3ow">LPT 1109 -7MT</td>

    <td class="tg-c3ow"><?=$record['tax_details']->hsn_code?></td>

    <td class="tg-c3ow"><?=$row['gst_rate']?>%</td>

    <td class="tg-c3ow tg-dvpl"><?=$tempqty?></td>

    <td class="tg-c3ow tg-dvpl"><?=$tempprice?></td>

    <td class="tg-dvpl"><?=$tempqty*$tempprice?></td>

    <?php

  }

  ?>

  <tr>

    <td class="tg-dvpl" colspan="6">Sub-Total</td>

    <td class="tg-dvpl"><?=$total?></td>

  </tr>

  <?php

    if($record['consignee']->state_code=="20")

    {

      ?>

  <tr>

    <td class="tg-dvpl" colspan="6">CGST @ <?=$row['gst_rate']/2?>%</td>

    <td class="tg-dvpl"><?=$record['invoice']->total_tax/2?></td>

  </tr>

  <tr>

    <td class="tg-dvpl" colspan="6">SGST  @ <?=$row['gst_rate']/2?>%</td>

    <td class="tg-dvpl"><?=$record['invoice']->total_tax/2?></td>

  </tr>

  <?php



    }

    else

    {

      ?>

      <tr>

        <td class="tg-dvpl" colspan="6">IGST  @ <?=$row['gst_rate']?>%</td>

        <td class="tg-dvpl"><?=$record['invoice']->total_tax?></td>

      </tr>

    <?php



    }

      ?>

  <tr>

    <td class="tg-dvpl" colspan="6">Total Tax</td>

    <td class="tg-dvpl"><?=$record['invoice']->total_tax?></td>

  </tr>

  <tr>

    <td class="tg-dvpl" colspan="6">Round OFF</td>

    <!-- <td class="tg-dvpl"><?=($record['invoice']->invoice_total-($record['invoice']->total_tax+$total))?></td> -->

    <td class="tg-dvpl"><?=$record['invoice']->round_off?></td>

  </tr>

  <tr>

    <td class="tg-dvpl">TOTAL</td>

    <td class="tg-dvpl" colspan="5">Invoice Value</td>

    <td class="tg-dvpl"><strong><?=$record['invoice']->invoice_total?></strong></td>

  </tr>

  <tr>

    <td class="tg-us36" colspan="7">Bill Amount in words - <span style="text-transform:capitalize"><?=getIndianCurrency($record['invoice']->invoice_total)?></span></td>

  </tr>

  <tr>

    <td class="tg-us36" colspan="7">Tax Amount in words - <span style="text-transform:capitalize"><?=getIndianCurrency($record['invoice']->total_tax)?></span></td>

  </tr>

  <tr>

    <td class="tg-us36" colspan="4" rowspan="3">

      <strong>Bank Details</strong>

        <br/>

	ECOPACK SERVICES PVT LTD<br>

	Bank Name: STATE BANK OF INDIA<br>

	IFSC:SBIN0005301

	<br>

	Account No-36946582226

	</td>

    <td class="tg-us36" colspan="3" rowspan="3"><br><br><br><br>For,ECOPACK SERVICES PVT.LTD.</td>

  </tr>

  <tr>

  </tr>

  <tr>

  </tr>

</table>

<div class="page-break"></div>





<?php

if(isset($record['annexure']))

{

  ?>

  <div style="text-align:center"> <h3>Annexure 1 </h3>

  <?php

  if(sizeof($record['annexure']['inward'])>0)

  {



  ?>

  <div style="text-align:center"> <h3>Inward </h3></div>

  

  <table class="tg" align="center">

    <tr>

      <th class="tg-us36">SL No.</th>

      <th class="tg-us36">DC No.</th>

      <th class="tg-us36">Consignment No</th>

      <th class="tg-us36">Date</th>

      

  <?php

  if($tblnm=="tbl_item")

  {

    ?>

    <th class="tg-us36">Item Name</th>

    <th class="tg-us36">QTY</th>

    <?php

  }

  else

  {

    ?>

    <th class="tg-us36">Vehicle Type</th>

    <?php

  }

  ?>

  <th class="tg-us36">Way Bill No</th>

  </tr>

  </thead>

  <tbody>



    <?php

      $ctr=0;

      foreach ($record['annexure']['inward'] as $row) {

        $ctr++;

        ?>

        <tr>

          <td class="tg-dvpl" ><?=$ctr?></td>

          <td class="tg-dvpl" ><?=$row['d_c_no']?></td>

          <td class="tg-dvpl" ><?=$row['consignment_no']?></td>

          <td class="tg-dvpl" ><?=date('d-m-Y',strtotime($row['consignment_date']))?></td>

          <?php

          if($tblnm=="tbl_item")

          {

            ?>

            <td class="tg-dvpl" ><?=$row['item_name']?></td>

            <td class="tg-dvpl" ><?=$row['qty']?></td>

          <?php

          }

          else

          {

            

            ?>

            <td class="tg-dvpl" ><?=$row['vehicle_type']?></td>

            <?php

            

          }

          ?>

          <td class="tg-dvpl" ><?=$row['way_bill_no']?></td>

        </tr>

        <?php

      }

    ?>

  </tbody>

</table>

<?php

  }

  ?>

  <?php

  if(sizeof($record['annexure']['outward'])>0)

  {



  ?>

  <div style="text-align:center"> <h3>Outward </h3></div>

  

  <table class="tg" align="center">

    <tr>

      <th class="tg-us36">SL No.</th>

      <th class="tg-us36">DC No.</th>

      <th class="tg-us36">Consignment No</th>

      <th class="tg-us36">Date</th>

      

  <?php

  if($tblnm=="tbl_item")

  {

    ?>

    <th class="tg-us36">Item Name</th>

    <th class="tg-us36">QTY</th>

    <?php

  }

  else

  {

    ?>

    <th class="tg-us36">Vehicle Type</th>

    <?php

  }

  ?>

  <th class="tg-us36">Way Bill No</th>

  </tr>

  </thead>

  <tbody>



    <?php

      $ctr=0;

      foreach ($record['annexure']['outward'] as $row) {

        $ctr++;

        ?>

        <tr>

          <td class="tg-dvpl" ><?=$ctr?></td>

          <td class="tg-dvpl" ><?=$row['d_c_no']?></td>

          <td class="tg-dvpl" ><?=$row['consignment_no']?></td>

          <td class="tg-dvpl" ><?=date('d-m-Y',strtotime($row['consignment_date']))?></td>

          <?php

          if($tblnm=="tbl_item")

          {

            ?>

            <td class="tg-dvpl" ><?=$row['item_name']?></td>

            <td class="tg-dvpl" ><?=$row['qty']?></td>

          <?php

          }

          else

          {

            if($record['invoice']->billing_address_id=='2')

            {

              if($row['vehicle_type_id']=="12" || $row['vehicle_type_id']=="13")

              {

                //echo "<td class='tg-dvpl'>H Frame 7 MT</td>";

                echo "<td class='tg-dvpl'>".$row['vehicle_type']."</td>";

              }

              else if($row['qty']>0)

              {

                echo "<td class='tg-dvpl'>Nafeb 7 MT</td>";

              }

              else

              {

              ?>

              <td class="tg-dvpl" >H Frame 7 MT</td>

              <?php

              }

            }

            else

            {

              echo "<td class='tg-dvpl'>".$row['vehicle_type']."</td>";

            }

            

          }

          ?>

          <td class="tg-dvpl" ><?=$row['way_bill_no']?></td>

        </tr>

        <?php

      }

    ?>

  </tbody>

</table>

<?php

  }

  ?>

</div>

  <?php

}



?>

<script type="text/javascript">

setTimeout(function(){

//	window.print();

	//window.close();

},2000);



</script>

</body>



</html>