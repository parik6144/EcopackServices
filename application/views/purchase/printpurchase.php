<?php
function convertNumber($number)
{
    list($integer, $fraction) = explode(".", (string) $number);

    $output = "";

    if ($integer{0} == "-")
    {
        $output = "negative ";
        $integer    = ltrim($integer, "-");
    }
    else if ($integer{0} == "+")
    {
        $output = "positive ";
        $integer    = ltrim($integer, "+");
    }

    if ($integer{0} == "0")
    {
        $output .= "zero";
    }
    else
    {
        $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
        $group   = rtrim(chunk_split($integer, 3, " "), " ");
        $groups  = explode(" ", $group);

        $groups2 = array();
        foreach ($groups as $g)
        {
            $groups2[] = convertThreeDigit($g{0}, $g{1}, $g{2});
        }

        for ($z = 0; $z < count($groups2); $z++)
        {
            if ($groups2[$z] != "")
            {
                $output .= $groups2[$z] . convertGroup(11 - $z) . (
                        $z < 11
                        && !array_search('', array_slice($groups2, $z + 1, -1))
                        && $groups2[11] != ''
                        && $groups[11]{0} == '0'
                            ? " and "
                            : ", "
                    );
            }
        }

        $output = rtrim($output, ", ");
    }

    if ($fraction > 0)
    {
        $output .= " and";
        for ($i = 0; $i < strlen($fraction); $i++)
        {
            $output .= " " . convertDigit($fraction{$i});
        }
        $output=$output." paise ";
    }

    return $output;
}

function convertGroup($index)
{
    switch ($index)
    {
        case 11:
            return " decillion";
        case 10:
            return " nonillion";
        case 9:
            return " octillion";
        case 8:
            return " septillion";
        case 7:
            return " sextillion";
        case 6:
            return " quintrillion";
        case 5:
            return " quadrillion";
        case 4:
            return " trillion";
        case 3:
            return " billion";
        case 2:
            return " million";
        case 1:
            return " thousand";
        case 0:
            return "";
    }
}

function convertThreeDigit($digit1, $digit2, $digit3)
{
    $buffer = "";

    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
    {
        return "";
    }

    if ($digit1 != "0")
    {
        $buffer .= convertDigit($digit1) . " hundred";
        if ($digit2 != "0" || $digit3 != "0")
        {
            $buffer .= " ";
        }
    }

    if ($digit2 != "0")
    {
        $buffer .= convertTwoDigit($digit2, $digit3);
    }
    else if ($digit3 != "0")
    {
        $buffer .= convertDigit($digit3);
    }

    return $buffer;
}

function convertTwoDigit($digit1, $digit2)
{
    if ($digit2 == "0")
    {
        switch ($digit1)
        {
            case "1":
                return "ten";
            case "2":
                return "twenty";
            case "3":
                return "thirty";
            case "4":
                return "forty";
            case "5":
                return "fifty";
            case "6":
                return "sixty";
            case "7":
                return "seventy";
            case "8":
                return "eighty";
            case "9":
                return "ninety";
        }
    } else if ($digit1 == "1")
    {
        switch ($digit2)
        {
            case "1":
                return "eleven";
            case "2":
                return "twelve";
            case "3":
                return "thirteen";
            case "4":
                return "fourteen";
            case "5":
                return "fifteen";
            case "6":
                return "sixteen";
            case "7":
                return "seventeen";
            case "8":
                return "eighteen";
            case "9":
                return "nineteen";
        }
    } else
    {
        $temp = convertDigit($digit2);
        switch ($digit1)
        {
            case "2":
                return "twenty-$temp";
            case "3":
                return "thirty-$temp";
            case "4":
                return "forty-$temp";
            case "5":
                return "fifty-$temp";
            case "6":
                return "sixty-$temp";
            case "7":
                return "seventy-$temp";
            case "8":
                return "eighty-$temp";
            case "9":
                return "ninety-$temp";
        }
    }
}

function convertDigit($digit)
{
    switch ($digit)
    {
        case "0":
            return "zero";
        case "1":
            return "one";
        case "2":
            return "two";
        case "3":
            return "three";
        case "4":
            return "four";
        case "5":
            return "five";
        case "6":
            return "six";
        case "7":
            return "seven";
        case "8":
            return "eight";
        case "9":
            return "nine";
    }
}


// CONVERSION OF RUPEE INTO WORD.
function rupee_in_word($number)
{
    $no = round($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array('0' => '', '1' => 'One', '2' => 'Two',
        '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
        '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
        '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
        '13' => 'Thirteen', '14' => 'Fourteen',
        '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
        '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
        '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
        '60' => 'Sixty', '70' => 'Seventy',
        '80' => 'Eighty', '90' => 'Ninety');
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] .
                " " . $digits[$counter] . $plural . " " . $hundred
                :
                $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
        } else $str[] = null;
    }
    $str = array_reverse($str);
    $result = implode('', $str);
    $points = ($point) ?
        "." . $words[$point / 10] . " " .
        $words[$point = $point % 10] : '';
    echo $result . " only";

}
?>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg1 td{font-family:Arial, sans-serif;font-size:14px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-yw4l{vertical-align:top}
th.tg-yw4l {text-align: left;}
span.bold {
    font-weight: 700;
}
@media print
   {
div.header {
    position:fixed;
    top:0px;
    left:0px;
    width:100%;
    color:#CCC;
    background:#333;
    padding:8px;
}
div.footer {
    position:fixed;
    bottom:0px;
    left:0px;
    width:100%;
    color:#CCC;
    background:#333;
    padding:8px;
}
}
</style>

<!-- BEGIN CONTENT -->


   <table class="tg header" style="width:900px;">
  <tr>
    <th colspan="6" style="text-align: -webkit-center;"><span class="bold">Purchase Invoice</span></th>
  </tr>

    <tr>
     
      <th class="tg-yw4l" rowspan="3">
      <span class="bold" style="font-size: 25px;">Aashvi Innovations Pvt LTD</span><br>
      152 shardha enclave Dalbhum Road<br>
      Jamshedpur - 831001, JHARKHAND<br>
      Mobile :8603195753, Phone No:8603195753<br>
      E-mail :test@test.com<br>
      GSTNO : GST/1718/00/12<br>
      PAN : Pan No<br>
      State code :&nbsp;20<br>
      </th>
    <th class="tg-yw4l" colspan="4">Purchase No : <span class="bold"><?=$item['0']['purchase_no']?></span></th>
    <th class="tg-yw4l" colspan="3">Date : <span class="bold"><?=date("d-m-Y", strtotime($item['0']['purchase_date']))?></span></th>
   </tr>

  <tr>
    <td class="tg-yw4l" colspan="4">Delivery Note :</td>
    <td class="tg-yw4l" colspan="3">Mode/Terms of Payment :<span class="bold"></span></td>
  </tr>

  <tr>
    <td class="tg-yw4l" colspan="4">Supplier's Ref : </td>
    <td class="tg-yw4l" colspan="3">Others Reference(s)</td>
  </tr>

  <tr>
    <td class="tg-yw4l" rowspan="6">
    <span class="bold">Buyer : &nbsp; <?=$item['0']['account_name']?></span></br>
    Address :&nbsp; <?=$item['0']['address_line1']?></br>
			<?=$item['0']['address_line2']?><br/>
    City :&nbsp; <?=$item['0']['city_name']?>, Pincode :&nbsp; <?=$item['0']['zip_code']?></br>
    Contact :&nbsp; <?=$item['0']['mobile']?></br>
    GSTIN :&nbsp; </br>
    PAN :&nbsp; </br>
    State :&nbsp;<?=$item['0']['city_name']?>, Code :20</td></br>
    <td class="tg-yw4l" colspan="4">Buyers's Order No.</td>
    <td class="tg-yw4l" colspan="3">Dated</td>
  </tr>

  <tr>
    <td class="tg-yw4l" colspan="4">Despatch Document No.</td>
    <td class="tg-yw4l" colspan="3">Delivery Note Date</td>
  </tr>
  <tr>
    <td class="tg-yw4l" colspan="4">Despatched Through</td>
    <td class="tg-yw4l" colspan="3">Destination</td>
  </tr>
  <tr>
    <td class="tg-yw4l" colspan="8" rowspan="3">Terms of Delivery</td>
  </tr>
  <tr>
  </tr>
  <tr>
  </tr>
</table>

<table class="tgn tg" style="width:900px;border:none;">
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tgn td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-baqh{text-align:center;vertical-align:top}
.tg .tg-lqy6{text-align:right;vertical-align:top}
.tg .tg-yw4l{vertical-align:top}
.tg td.sum{
border-bottom:none;
border-top:none;
}
</style>
  <tr>
    <th class="tg-031e" style="text-align: center;">Sl.No.</th>
    <th class="tg-031e" style="text-align: center;">Description Of Good</th>
    <th class="tg-031e" style="text-align: center;">HSN/SAC</th>
    <th class="tg-yw4l" style="text-align: center;">Quality</th>
    <th class="tg-yw4l" style="text-align: center;">Rate</th>
    <th class="tg-yw4l" style="text-align: center;">per</th>
    <th class="tg-yw4l" style="text-align: center;">Disc%</th>
    <th class="tg-yw4l" style="text-align: center;">Amount</th>
  </tr>

  <?php
  $totalqty=0;
  $rowprice=0;
  $i=1;
  $hsnarr=[];
  $pricearr=[];
  $taxarr=[];
  foreach($item_details as $row)
  {
	  
	  $totalqty+=$row['qty'];
  ?>
  <tr>
    <td class="tg-031e sum" style="text-align: center;"><?=$i?></td>
    <td class="tg-031e sum" style="border-bottom:none;">
    <span class="bold"><?=$row['item_name']?></span>

    </td>
    <td class="tg-031e sum" style="text-align: center;"><?=$row['hsn_code'];?></td>
    <?php

		if (!in_array($row['hsn_code'], $hsnarr)) {
		    array_push($hsnarr,$row['hsn_code']);
		    array_push($pricearr,$row['total_price']);
		    array_push($taxarr,$row['purchase_tax_id']);

		}
		else
		{
			$key = array_search($row['hsn_code'], $hsnarr);
			$pricearr[$key]=$pricearr[$key]+$row['total_price'];
		}

    ?>
    <td class="tg-yw4l sum" style="text-align: center;"><span class="bold"><?=$row['qty']. $row['short_name']?></span></td>
    <td class="tg-yw4l sum" style="text-align: center;"><?=$row['price']?></td>
    <td class="tg-yw4l sum" style="text-align: center;"><?=$row['short_name']?></td>
    <td class="tg-yw4l sum" style="text-align: center;">
    <?=$row['discount']?>
	</td>
    <td class="tg-yw4l sum" style="text-align: center;"><span class="bold"><?=$row['total_price']?></span></td>
  </tr>
  <?php $rowprice+=$row['total_price']; $i++; } ?>

  <tr>
    <td class="tg-yw4l sum"></td>
    <td class="tg-lqy6 sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum" style="text-decoration: overline; text-align: center;"><?= $rowprice; ?></td>
  </tr>
  
  <tr>
    <td class="tg-yw4l sum"></td>
    <td class="tg-lqy6 sum">Other Charges</td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum" style="text-align: center;"><?= $item['0']['other_charge']; ?></td>
  </tr>	
  <?php
  	 $total=($rowprice+$item['0']['other_charge'])-$item['0']['bill_discount'];
  	 $taxamt=$item['0']['grand_total']-$total;
   ?>
  <tr>
    <td class="tg-yw4l sum"></td>
    <td class="tg-lqy6 sum">CGST</td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum" style=" text-align: center;"><?= ($taxamt/2); ?></td>
  </tr>
  <tr>
    <td class="tg-yw4l sum"></td>
    <td class="tg-lqy6 sum">SGST</td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum" style=" text-align: center;"><?= ($taxamt/2); ?></td>
  </tr>

  <tr>
    <td class="tg-yw4l sum"></td>
    <td class="tg-lqy6 sum">Bill Discount</td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum" style="text-align: center;"><?= $item['0']['bill_discount'] ?></td>
  </tr>	

  <tr>
    <td class="tg-yw4l sum"></td>
    <td class="tg-lqy6 sum">Round Off</td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum"></td>
    <td class="tg-yw4l sum" style="text-align: center;"><?= $item['0']['round_off'] ?></td>
  </tr>	

  <tr>
    <td class="tg-yw4l"></td>
    <td class="tg-lqy6">Total</td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l" style="text-align: center;"><span class="bold"><?=$totalqty?> Nos.</span></td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l"></td>
    <td class="tg-yw4l" style="text-align: center;">
    <span class="bold">
     <?=$item['0']['grand_total'] ?>
    </span>
    </td>
    <?php //$grand_total=$row_debtor['purchase_gross_amt']; ?>
  </tr>
  </table>
  <table class="tg" style="width:900px;">
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:2px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-baqh{text-align:center;vertical-align:top}
.tg .tg-lqy6{text-align:right;vertical-align:top}
.tg .tg-yw4l{vertical-align:top}
</style>
  <tr>
    <td class="tg-yw4l" colspan="7" style="border-right:none;">Amount Chargable (in word) :&nbsp;&nbsp;<span class="bold">INR <?= convertNumber($item['0']['grand_total']).' only '?></span></td>
  <td style="border-left:none;text-align:right;">E. &amp;O.E</td>
  </tr>
  <tr>
    <td class="tg-yw4l" rowspan="2" style="text-align: center;">HSN/SAC</td>
    <td class="tg-yw4l" rowspan="2" style="text-align: center;">Taxable Value</td>
    <td class="tg-baqh" colspan="2" style="text-align: center;">Central Tax</td>
    <td class="tg-baqh" colspan="2" style="text-align: center;">State Tax</td>
    <td class="tg-baqh" colspan="2" rowspan="2" style="text-align: center;">Total Tax Amount</td>
  </tr>
  <tr>
    <td class="tg-yw4l" style="text-align: center;">Rate</td>
    <td class="tg-yw4l" style="text-align: center;">Amont</td>
    <td class="tg-yw4l" style="text-align: center;">Rate</td>
    <td class="tg-yw4l" style="text-align: center;">Amount</td>
  </tr>
  <?php
  $taxablevalue=0;
  $cgsttax=0;
  $sgsttax=0;
  $taxtotal=0;
  for($j=0;$j<sizeof($hsnarr);$j++)
  {

  	?>
  		<tr>
  		<td class="tg-yw4l" style="text-align: center;"><?= $hsnarr[$j];?></td>
        <td class="tg-yw4l" style="text-align: center;"><?=$pricearr[$j];?></td>
        <td class="tg-yw4l" style="text-align: center;"><?=($taxarr[$j]/2); ?>%</td>
        <td class="tg-yw4l" style="text-align: center;"><?php
        	$taxamtc=$pricearr[$j]*($taxarr[$j]/2)/100;
        	echo $taxamtc;

        ?></td>
        <td class="tg-yw4l" style="text-align: center;"><?=($taxarr[$j]/2); ?>%</td>
        <td class="tg-yw4l" style="text-align: center;"><?php
        	$taxamts=$pricearr[$j]*($taxarr[$j]/2)/100;
        	echo $taxamts;

        ?></td>
        <td class="tg-yw4l" colspan="2" style="text-align: center;">
        	<?php 
        		$totaltaxamount=($pricearr[$j]*($taxarr[$j]/2)/100)+($pricearr[$j]*($taxarr[$j]/2)/100);
        		echo $totaltaxamount;
        	 ?>
        	 	
        	 </td>
    </tr>
  	<?php
	  	$taxablevalue+=$pricearr[$j];
	  	$cgsttax+=$taxamtc;
	  	$sgsttax+=$taxamts;
	  	$taxtotal+=$totaltaxamount;
	}
  ?>
   <tr>
    <td class="tg-yw4l" style="text-align: center;"><span class="bold">Total</span></td>
    <td class="tg-yw4l" style="text-align: center;"><span class="bold"><?=$taxablevalue?></span></td>
    <td class="tg-yw4l" style="text-align: center;"></td>
    <td class="tg-yw4l" style="text-align: center;"><span class="bold"><?=$cgsttax?></span></td>
    <td class="tg-yw4l" style="text-align: center;"></td>
    <td class="tg-yw4l" style="text-align: center;"><span class="bold"><?=$sgsttax?></span></td>
    <td class="tg-yw4l" colspan="2" style="text-align: center;"><span class="bold"><?=$taxtotal?></span></td>
  </tr>

  <tr>
    <td class="tg-yw4l" colspan="8" rowspan="2">Tax Amount (in word): 
    <span class="bold">INR <?=convertNumber($taxtotal).' only '?></span>
    <br><!-- <br><br>
    <span class="bold">Company's VAT Tin : <?=$company_tin?></span>
    <span class="bold" style="float: right;">Company's PAN     : <?=$company_pan?></span> -->
   </td>
   </tr>
</table>
</table>
<script type="text/javascript">
	window.print();
</script>
