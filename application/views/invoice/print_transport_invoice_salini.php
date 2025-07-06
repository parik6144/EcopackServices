<?php
function getIndianCurrency(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
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
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise ;
}
?>

<html>
<head>

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
<table class="tg">
  <tr>
    <th class="tg-us36" colspan="7">TAX INVOICE</th>
  </tr>
  <tr>
    <td class="tg-us36" colspan="3" rowspan="2">
	<!-- <img src="<?=base_url('uploads/')?>EcoPack.jpg" width="200px"/> -->
	<!-- <br/> -->
	<strong>SALINI LOGISTIC</strong><br>Vendor Code-NA<br>Address of consignee<br>H.No-15A,A-road,Zone No-<br>1B,Birsanagar,telco,Jamshedpur<br>Jharkhand,pin-831019 STATE CODE :-20<br/>Email-salinilogistick@gmail.com<br><strong>GST No-20AEMPJ4862R1ZZ</strong></td>
    <td class="tg-us36" colspan="2"><strong>Invoice No:- <?=$record['invoice']->invoice_no?></strong></td>
    <td class="tg-us36" colspan="2"><strong>Date:- <?=date('d-m-Y',strtotime($record['invoice']->invoice_date))?></strong></td>
  </tr>
  <tr>
    <td class="tg-us36" colspan="2">Dispatch Through: NA </td>
    <td class="tg-us36" colspan="2">Destination - <?php
      $arr=explode(" ",$record['consignee']->consignee_name);
      echo $arr['0'];
     ?> <?=$record['consignee']->city?></td>
  </tr>
  <tr>
    <td class="tg-us36" colspan="3" style="width:80px">Buyer : 
    <?=$record['consignee']->consignee_name.",
    ".$record['consignee']->address.",
    ".$record['consignee']->city.",
    ".$record['consignee']->state.",
    ".$record['consignee']->pincode.",
     State Code".$record['consignee']->state_code."<br/>".
     "<strong>GST No-".$record['consignee']->gstin."</strong><br/>"?></td>
	<td class="tg-us36" colspan="2">Source : Jamshedpur </td>
	<td class="tg-us36" colspan="2">Destination : <?=$record['consignee']->city?> </td>
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
  $tblnm="";
  foreach ($record['item'] as $row) {
    ?>
  <tr>
    <td class="tg-c3ow"><?=$ctr?></td>
    <?php
    if($row['ref_table_name']=="tbl_item")
    {
      $tblnm="tbl_item";
      ?>
      <td class="tg-c3ow"><?=$row['item_name']?></td>
      <?php
    }
    else
    {
      $tblnm="tbl_vehicle_type"; 
    ?>
      <td class="tg-c3ow"><?=$row['vehicle_type']?></td>
      <?php
    }
      ?>
    
    <td class="tg-c3ow"><?=$record['tax_details']->hsn_code?></td>
    <td class="tg-c3ow"><?=$record['tax_details']->tax_rate?>%</td>
    <td class="tg-c3ow"><?=$row['qty']?></td>
    <td class="tg-c3ow"><?=$row['price']?></td>
    <td class="tg-dvpl"><?=$row['qty']*$row['price']?></td>
  </tr>
  <?php
    $total+=$row['qty']*$row['price'];
    $ctr++;
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
    <td class="tg-dvpl" colspan="6">CGST @ <?=$record['tax_details']->tax_rate/2?>%</td>
    <td class="tg-dvpl"><?=$record['invoice']->total_tax/2?></td>
  </tr>
  <tr>
    <td class="tg-dvpl" colspan="6">SGST  @ <?=$record['tax_details']->tax_rate/2?>%</td>
    <td class="tg-dvpl"><?=$record['invoice']->total_tax/2?></td>
  </tr>
  <?php

    }
    else
    {
      ?>
      <tr>
        <td class="tg-dvpl" colspan="6">IGST  @ <?=$record['tax_details']->tax_rate?>%</td>
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
    <td class="tg-dvpl"><?=$record['invoice']->round_off?></td>
  </tr>
  <tr>
    <td class="tg-dvpl">TOTAL</td>
    <td class="tg-dvpl" colspan="5">Invoice Value</td>
    <td class="tg-dvpl"><?=$record['invoice']->invoice_total?></td>
  </tr>
  <tr>
    <td class="tg-us36" colspan="7">Bill Amount in words - <span style="text-transform:capitalize"><?=getIndianCurrency($record['invoice']->invoice_total)?></span></td>
  </tr>
  <tr>
    <td class="tg-us36" colspan="7">Tax Amount in words - <span style="text-transform:capitalize"><?=getIndianCurrency($record['invoice']->total_tax)?></span></td>
  </tr>
  <tr>
    <td class="tg-us36" colspan="4" rowspan="3">
	<br>
	<br>
	<br>
	</td>
    <td class="tg-us36" colspan="3" rowspan="3"><br><br><br>For, SALANI LOGISTIC</td>
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
  <div style="text-align:center"> <h3>Annexure1 </h3>
  <table class="tg" style="margin-left:30px">
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
  </tr>
  </thead>
  <tbody>

    <?php
      $ctr=0;
      foreach ($record['annexure'] as $row) {
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
          
        </tr>
        <?php
      }
    ?>
  </tbody>
</table>
</div>
  <?php
}

?>
    
<script type="text/javascript">
//window.print();
//window.close();
</script>
</body>

</html>