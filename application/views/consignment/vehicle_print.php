<html>
<head>
	<title><?=$title?></title>
</head>
<body>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-88nc{font-weight:bold;border-color:inherit;text-align:center}
.tg .tg-l711{border-color:inherit}
.tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-us36{border-color:inherit;vertical-align:top}
.right_text{
	text-align: right;
}
.bold_text{
	font-weight: bold;
}
</style>
<table class="tg" style="width:100%;">
  <tr>
    <th class="tg-88nc" colspan="4">ECOPACK SERVICES PVT. LTD.<br>H.No. 15A, 'A' Road, Zone No. 1B, Birsanagar, Jamshedpur-19<br>Mobile No.:7250980021, 9162186500<br><br>MATERIAL OUTWARD CHALLAN</th>
  </tr>
  <tr>
    <td class="tg-l711">To,<br><strong>Name: <?=$form_data['consignment']->consignee_name?></strong>
    	<br>Address: <?=$form_data['consignment']->c_address?><br>
    	<?=$form_data['consignment']->c_city?>,
    	<?=$form_data['consignment']->c_state?>, <?=$form_data['consignment']->c_pincode?><br>
    	Mobile No: <?=$form_data['consignment']->c_mobile_no?></td>
    <td class="tg-l711 right_text" colspan="3" style="width:150px;">Date: <?=date('d-m-Y',strtotime($form_data['consignment']->consignment_date))?></td>
  </tr>
  <tr>
    <td class="tg-l711"  colspan="4">Vehicle Number: <?=$form_data['consignment']->vehicle_inward_no?></td>
  </tr>
  <tr>
    <td class="tg-l711"  colspan="4">Driver Name: <?=$form_data['consignment']->driver_name?></td>
  </tr>
  <tr>
    <td class="tg-l711"  colspan="4">Mobile No: <?=$form_data['consignment']->v_mobile_no?></td>
  </tr>
  <tr>
    <td class="tg-us36" colspan="4"></td>
  </tr>
  <tr>
    <td class="tg-c3ow bold_text" colspan="2">Item</td>
    <td class="tg-c3ow bold_text" colspan="2">Quantity</td>
  </tr>
  <?php
  $ctr=0;
  foreach ($form_data['consignment_stock_item'] as $row) {
  	$ctr++;
  	?>
  	<tr>
	    <td class="tg-us36" colspan="2"><?=$ctr?>) <?=$row['item_name']?><br></td>
	    <td class="tg-us36 right_text" colspan="2" ><?=$row['qty']?></td>
	  </tr>
  	<?php
  }
  ?>
  
</table>
<!-- <div style="text-align:right;margin-top:120px;">
  	Dispached By
  </div> -->
<script type="text/javascript">
	window.print();
	window.close();
</script>
</body>
</html>