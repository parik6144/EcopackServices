<html>
<head>
	<title><?=$title?></title>
</head>
<body>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:13px;padding:5px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
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
    <th class="tg-88nc" colspan="4">ECOPACK SERVICES PVT. LTD.<br>H.No. 15A, 'A' Road, Zone No. 1B, Birsanagar, Jamshedpur-19<br>Mobile No.:9162186500, 7488419179<br><br>MATERIAL INWARD CHALLAN</th>
  </tr>
  <tr>
    <td class="tg-l711" style="width:80%;">
      <span style="width:48%;float:left;">
        From,<br><strong>Name: <?=$data['data']->consignor_name?></strong>
      	<br>Address: <?=$data['data']->address?><br/>
      	<?=$data['data']->city?>,
      	<?=$data['data']->state?>, <?=$data['data']->pincode?><br/>
      	Mobile No: <?=$data['data']->mobile_no?>
      </span>
      <span style="width:48%;float:right;">
        To,<br><strong>Name: <?=$data['data']->c_consignee_name?></strong>
        <br>Address: <?=$data['data']->c_address?><br>
        <?=$data['data']->c_city?>,
        <?=$data['data']->state?>, <?=$data['data']->c_pincode?><br>
        Mobile No: <?=$data['data']->c_mobile_no?>
      </span>
    </td>
    <td class="tg-l711 right_text" colspan="3">
      Sl.No: <?=$data['data']->inward_id?><br/>
      Inward No : <?=$data['data']->inward_no?>
      <br/>
      Date: <?=date('d-m-Y',strtotime($data['data']->inward_date))?>
    </td>
  </tr>
  <tr>
    <td class="tg-l711"  colspan="4">Vehicle Number: <?=$data['data']->vehicle_inward_no?></td>
  </tr>
  <tr>
    <td class="tg-l711"  colspan="4">Driver Name: <?=$data['data']->driver_name?></td>
  </tr>
  <tr>
    <td class="tg-l711"  colspan="4">Mobile No: <?=$data['data']->mobile_no?></td>
  </tr>
  <tr>
    <td class="tg-l711"  colspan="4">Gatepass No: <?=$data['data']->gatepass_no?></td>
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
  foreach ($data['item'] as $row) {
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
  	Received By
  </div> -->
<script type="text/javascript">
	window.print();
//	window.close();
</script>
</body>
</html>