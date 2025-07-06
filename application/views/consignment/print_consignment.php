<html>
<head>
  <title><?=$title?></title>
</head>
<body>
<style type="text/css">                                                                                                                                                                       <style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:5px 3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-uys7{border-color:inherit;text-align:center}
.tg .tg-us36{border-color:inherit;vertical-align:top}
@media print {
    table {page-break-after:always}
}
</style>
<table class="tg">
    <tr>
        <th class="tg-uys7" colspan="3" >
          <div style="font-weight:800;">L R Sheet</div>
          <div style="text-align:left;width:40%;float:left;font-weight:bold;" >GST No: 20AAECE1697G1ZV</div>
          <div style="text-align:right;width:40%;float:right;" >Consignee Copy</div></th>
    </tr>
    
  <tr>
    <th class="tg-uys7" colspan="3">ECOPACK SERVICES PVT. LTD.<br>H.No. 15A, 'A' Road, Zone No. 1B, Birsanagar, Jamshedpur-19<br>Mobile No.:9835731721, 9162186500<br></th>
  </tr>
  <tr>
    <td class="tg-us36" colspan="2"></td>
    <td class="tg-c3ow">
      Consignment
      <br/>
      <?=$form_data['consignment']->consignment_no?>
    </td>
  </tr>
  <tr>
    <td class="tg-us36" colspan="1" rowspan="3" style="width:40%">CONSIGNOR:<?=$form_data['consignment']->consignor_name?>
      <br/>
      <?=$form_data['consignment']->address?>, 
      <?=$form_data['consignment']->city?>, 
      <?=$form_data['consignment']->state?>, 
      <?=$form_data['consignment']->pincode?>
      <br/>
      <?=$form_data['consignment']->mobile_no?>
      <br/>
      <strong>GST No:
      <?=$form_data['consignment']->consignor_gstin?></strong>

    </td>
    <td class="tg-us36" colspan="1" rowspan="3" style="width:40%">CONSIGNEE:<?=$form_data['consignment']->consignee_name?>
      <br/>
      <?=$form_data['consignment']->c_address?>, 
      <?=$form_data['consignment']->c_city?>, 
      <?=$form_data['consignment']->c_state?>, 
      <?=$form_data['consignment']->c_pincode?>
      <br/>
      <?=$form_data['consignment']->c_mobile_no?>
      <br/>
      <strong>GST No:
      <?=$form_data['consignment']->gstin?></strong>
    </td>
    <td class="tg-c3ow"><?=$form_data['consignment']->source?><br><br/><div style="border-top:1px solid #000;">TO</div></td>
  </tr>
  <tr>
    <td class="tg-c3ow"><?=$form_data['consignment']->destination?></td>
  </tr>
  <tr>
    <td class="tg-us36">Date: <?=date("d-m-Y",strtotime($form_data['consignment']->consignment_date))?></td>
  </tr>
  <tr>
    <td class="tg-us36">No Of Package</td>
    <td class="tg-us36">Description Of Goods</td>
    <td class="tg-us36">Qty</td>
    <!-- <td class="tg-us36">Freight Rate</td>
    <td class="tg-us36">Amount</td> -->
  </tr>
  <?php
    $ctr=1;
    foreach ($form_data['consignment_item'] as $row) {
    ?>
  <tr>
    <td class="tg-us36"><?=$ctr?></td>
    <td class="tg-us36"><?=$row['item_name']?></td>
    <td class="tg-us36"><?=$row['qty']?></td>
  </tr>
    <?php
    $ctr++;
    }
    ?>
    <?php
    $ctr=1;
    $total=0;
    foreach ($form_data['consignment_stock_item'] as $row) {
    ?>
  <tr>
    <td class="tg-us36"><?=$ctr?></td>
    <td class="tg-us36"><strong><?=$row['item_name']?></strong></td>
    <td class="tg-us36"><strong><?=$row['qty']?></strong></td>
  </tr>
    <?php
    $ctr++;
    if($form_data['consignment']->consignment_type==0 && ($row['item_id']=="57" || $row['item_id']=="59") )
    {

    }
    else
    $total+=$row['qty'];
    }
    ?>
    <tr>
    <td class="tg-us36" colspan="2">Total</td>
    <td class="tg-us36"><strong><?=$total?></strong></td>
  </tr>
  
  <tr>
    <td class="tg-us36" colspan="2">GST Paid By<br>CONSIGNOR</td>
    <td class="tg-us36">To be Billed &#10004;</td>
    <!-- <td class="tg-us36">St. Charges</td>
    <td class="tg-us36">100</td> -->
  </tr>
  
  <tr>
    <td class="tg-us36" colspan="1">Value : <?=$form_data['consignment']->consignment_value?></td>
    <td class="tg-us36" colspan="2" rowspan="2">To Pay Rs.</td>
  </tr>
  <tr>
    <td class="tg-us36" colspan="1">D.C. No.: <?=$form_data['consignment']->d_c_no?></td>
  </tr>
  <tr>
    <td class="tg-us36" colspan="1">Party GST No.: <?=$form_data['consignment']->gstin?></td>
    <td class="tg-us36" colspan="2">Owner : ECOPACK SERVICES PVT. LTD</td>
  </tr>
  <tr>
    <td class="tg-us36" colspan="1">Way Bill No. <?=$form_data['consignment']->way_bill_no?></td>
    <td class="tg-us36" colspan="2" rowspan="3">Address:Jamshedpur
    </td>
  </tr>
  <tr>
    <td class="tg-us36" colspan="1">Driver's Name: <?=$form_data['consignment']->driver_name?></td>
  </tr>
  <tr>
    <td class="tg-us36" colspan="1">Mobile no. <?=$form_data['consignment']->v_mobile_no?></td>
  </tr>
  <!--<tr>
    <td class="tg-c3ow" colspan="3">I/We hereby carefully read and agree the condition of company stipulated overleaf and declare the particulars are correct</td>
  </tr>-->
  <tr>
    <td class="tg-us36"><br/><br/><br/><br/><br/><br/><br/>Lorry No. <?=$form_data['consignment']->vehicle_inward_no?></td>
    <td class="tg-us36"><br/><br/><br/><br/><br/><br/><br/>Driver's Signature</td>
    <td class="tg-us36"><br/><br/><br/><br/><br/><br/><br/>For Ecopack Services Pvt. Ltd.</td>
  </tr>
  <tr>
    <td class="tg-us36 break" colspan="3" style="text-align: center;">Note: Kindly submit the receiving copy to the transporter through courier or in hand within 10 days of delivery,or else transporter will not be responsible for the rest payment</td>
  </tr>
  
</table>

<table class="tg">
   <th class="tg-uys7" colspan="3" >
          <div style="font-weight:800;">L R Sheet</div>
          <div style="text-align:left;width:40%;float:left;font-weight:bold;">GST No: 20AAECE1697G1ZV</div>
          <div style="text-align:right;width:40%;float:right;" >Transporter Copy</div></th>
   <tr>
       <th class="tg-uys7" colspan="3">ECOPACK SERVICES PVT. LTD.<br>H.No. 15A, 'A' Road, Zone No. 1B, Birsanagar, Jamshedpur-19<br>Mobile No.:9835731721, 9162186500<br></th>
   </tr>
   <tr>
       <td class="tg-us36" colspan="2"></td>
       <td class="tg-c3ow">
           Consignment
           <br/>
           <?=$form_data['consignment']->consignment_no?>
       </td>
   </tr>
   <tr>
       <td class="tg-us36" colspan="1" rowspan="3" style="width:40%">CONSIGNOR:<?=$form_data['consignment']->consignor_name?>
           <br/>
           <?=$form_data['consignment']->address?>,
           <?=$form_data['consignment']->city?>,
           <?=$form_data['consignment']->state?>,
           <?=$form_data['consignment']->pincode?>
           <br/>
           <?=$form_data['consignment']->mobile_no?>
           <br/>
          <strong>GST No:
          <?=$form_data['consignment']->consignor_gstin?></strong>
       </td>
       <td class="tg-us36" colspan="1" rowspan="3" style="width:40%">CONSIGNEE:<?=$form_data['consignment']->consignee_name?>
           <br/>
           <?=$form_data['consignment']->c_address?>,
           <?=$form_data['consignment']->c_city?>,
           <?=$form_data['consignment']->c_state?>,
           <?=$form_data['consignment']->c_pincode?>
           <br/>
           <?=$form_data['consignment']->c_mobile_no?>
           <br/>
            <strong>GST No:
            <?=$form_data['consignment']->gstin?></strong>

       </td>
       <td class="tg-c3ow"><?=$form_data['consignment']->source?><br><br/><div style="border-top:1px solid #000;">TO</div></td>
   </tr>
   <tr>
       <td class="tg-c3ow"><?=$form_data['consignment']->destination?></td>
   </tr>
   <tr>
       <td class="tg-us36">Date: <?=date("d-m-Y",strtotime($form_data['consignment']->consignment_date))?></td>
   </tr>
   <tr>
       <td class="tg-us36">No Of Package</td>
       <td class="tg-us36">Description Of Goods</td>
       <td class="tg-us36">Qty</td>
       <!-- <td class="tg-us36">Freight Rate</td>
       <td class="tg-us36">Amount</td> -->
   </tr>
   <?php
   $ctr=1;
   foreach ($form_data['consignment_item'] as $row) {
       ?>
       <tr>
           <td class="tg-us36"><?=$ctr?></td>
           <td class="tg-us36"><?=$row['item_name']?></td>
           <td class="tg-us36"><?=$row['qty']?></td>
       </tr>
       <?php
       $ctr++;
   }
   ?>
   <?php
   $ctr=1;
   $total=0;
   foreach ($form_data['consignment_stock_item'] as $row) {
       ?>
       <tr>
           <td class="tg-us36"><?=$ctr?></td>
           <td class="tg-us36"><strong><?=$row['item_name']?></strong></td>
           <td class="tg-us36"><strong><?=$row['qty']?></strong></td>
       </tr>
       <?php
       $ctr++;
       if($form_data['consignment']->consignment_type==0 && ($row['item_id']=="57" || $row['item_id']=="59") )
      {

      }
      else
      $total+=$row['qty'];
   }
   ?>
   <tr>
       <td class="tg-us36" colspan="2">Total</td>
       <td class="tg-us36"><strong><?=$total?></strong></td>
   </tr>

   <tr>
       <td class="tg-us36" colspan="2">GST Paid By<br>CONSIGNOR</td>
       <td class="tg-us36">To be Billed &#10004;</td>
       <!-- <td class="tg-us36">St. Charges</td>
       <td class="tg-us36">100</td> -->
   </tr>

   <tr>
       <td class="tg-us36" colspan="1">Value : <?=$form_data['consignment']->consignment_value?></td>
       <td class="tg-us36" colspan="2" rowspan="2">To Pay Rs.</td>
   </tr>
   <tr>
       <td class="tg-us36" colspan="1">D.C. No.: <?=$form_data['consignment']->d_c_no?></td>
   </tr>
   <tr>
       <td class="tg-us36" colspan="1">Party GST No.: <?=$form_data['consignment']->gstin?></td>
       <td class="tg-us36" colspan="2">Owner : ECOPACK SERVICES PVT. LTD</td>
   </tr>
   <tr>
       <td class="tg-us36" colspan="1">Way Bill No. <?=$form_data['consignment']->way_bill_no?></td>
       <td class="tg-us36" colspan="2" rowspan="3">Address:Jamshedpur
       </td>
   </tr>
   <tr>
       <td class="tg-us36" colspan="1">Driver's Name: <?=$form_data['consignment']->driver_name?></td>
   </tr>
   <tr>
       <td class="tg-us36" colspan="1">Mobile no. <?=$form_data['consignment']->v_mobile_no?></td>
   </tr>
   <!--<tr>
     <td class="tg-c3ow" colspan="3">I/We hereby carefully read and agree the condition of company stipulated overleaf and declare the particulars are correct</td>
   </tr>-->
   <tr>
       <td class="tg-us36"><br/><br/><br/><br/><br/><br/><br/>Lorry No. <?=$form_data['consignment']->vehicle_inward_no?></td>
       <td class="tg-us36"><br/><br/><br/><br/><br/><br/><br/>Driver's Signature</td>
       <td class="tg-us36"><br/><br/><br/><br/><br/><br/><br/>For Ecopack Services Pvt. Ltd.</td>
   </tr>
   <tr>
       <td class="tg-us36" colspan="3" style="text-align: center;">Note: Kindly submit the receiving copy to the transporter through courier or in hand within 10 days of delivery,or else transporter will not be responsible for the rest payment</td>
   </tr>

</table>
<script type="text/javascript">
  window.print();
  //window.close();
  setTimeout(function(){window.close();}, 10000); 
</script>
</body>
</html>