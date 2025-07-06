<?php
class Mdl_stock extends CI_Model{
	public function getStockByItem($itemid)
	{
		$query=$this->db->select('sum(qty) as qty')
				->from('tbl_inward_details')
				->where('item_id',$itemid)
				->get();
		$totalinward=$query->row();
		$query=$this->db->select('sum(qty) as qty')
				->from('tbl_stock_transfer')
				->where('to_item_id',$itemid)
				->get();
		$totalinwardstock=$query->row();
		/*Outward stock*/
		$query=$this->db->select('sum(qty) as qty')
				->from('tbl_stock_transfer')
				->where('from_item_id',$itemid)
				->get();
		$totaloutwardstock=$query->row();

		$query=$this->db->select('sum(qty) as qty')
				->from('tbl_consignment_stock_item')
				->where('item_id',$itemid)
				->get();
		$totaloutward=$query->row();
		$query=$this->db->select('opening_stock')
				->from('tbl_item')
				->where('item_id',$itemid)
				->get();
		$openingstock=$query->row();
		$totalin=$totalinward->qty+$totalinwardstock->qty+$openingstock->opening_stock;
		$totalout=$totaloutwardstock->qty+$totaloutward->qty;
		return $totalin-$totalout;
	}

	public function getRentIdleStockByItem($itemid,$warehouse_id)
	{
		$query=$this->db->select('qty')
		->from('tbl_warehouse_opening_stock')
		->where(array('item_id' =>$itemid ,'warehouse_id'=>$warehouse_id ))
		->get();
		$openingstock=$query->row();

		$query=$this->db->select('sum(qty) as qty')
		->from('purchase_stock_item')
		->where(array('item_id' =>$itemid ,'warehouse_id'=>$warehouse_id ))
		->get();
		$totalpurchase=$query->row();

		$query=$this->db->select('sum(qty) as qty')
		->from('tbl_asign_rent_item')
		->where(array('master_item_id' =>$itemid ,'from_warehouse_id'=>$warehouse_id ))
		->get();
		$totalassign=$query->row();
		$opstock=0;
		if(isset($openingstock->qty))
			$opstock=$openingstock->qty;
		$totalpur=0;
		if(isset($totalpurchase->qty))
			$totalpur=$totalpurchase->qty;
		$totalasgn=0;
		if(isset($totalassign->qty))
			$totalasgn=$totalassign->qty;
		return ($opstock+$totalpur)-($totalasgn);
	}
	

	public function getRentStockByItemInTable($itemid,$warehouse_id="0")
	{
		$this->db->select('sum(qty) as qty');
		$this->db->from('tbl_inward_rent_item');
		if($warehouse_id!="0")
			$this->db->where('warehouse_id',$warehouse_id);
		$this->db->where('item_id',$itemid);
		$query=$this->db->get();
		$totalinward=$query->row();

		$this->db->select('sum(qty) as qty');
		$this->db->from('tbl_rent_stock_transfer');
		if($warehouse_id!="0")
			$this->db->where('to_warehouse_id',$warehouse_id);
		$this->db->where('to_item_id',$itemid);
		$query=$this->db->get();
		$totalinwardstock=$query->row();
		
		$this->db->select('warehouse_opening_stock');
		$this->db->from('tbl_stock_rent_item');
		if($warehouse_id!="0")
			$this->db->where('warehouse_id',$warehouse_id);
		$this->db->where('item_id',$itemid);
		$query=$this->db->get();
		$warehouseopeningstock=$query->row();

		$this->db->select('opening_stock');
		$this->db->from('tbl_stock_rent_item');
		if($warehouse_id!="0")
			$this->db->where('warehouse_id',$warehouse_id);
		$this->db->where('item_id',$itemid);
		$query=$this->db->get();
		$openingstock=$query->row();

		$this->db->select('sum(qty) as qty');
		$this->db->from('tbl_asign_rent_item');
		$this->db->where('item_id',$itemid);
		if($warehouse_id!="0")
			$this->db->where('to_warehouse_id',$warehouse_id);
		$query=$this->db->get();
		$totalassign=$query->row();


		/*Outward stock*/
		$this->db->select('sum(qty) as qty');
		$this->db->from('tbl_rent_stock_transfer');
		if($warehouse_id!="0")
			$this->db->where('from_warehouse_id',$warehouse_id);
		$this->db->where('from_item_id',$itemid);
		$query=$this->db->get();
		$totaloutwardstock=$query->row();
		$this->db->select('sum(qty) as qty');
		$this->db->from('tbl_consignment_rent_stock_item');
		$this->db->join('tbl_consignment','tbl_consignment.consignment_id=tbl_consignment_rent_stock_item.consignment_id','left');
		if($warehouse_id!="0")
			$this->db->where('tbl_consignment.consignment_warehouse_id',$warehouse_id);
		$this->db->where('item_id',$itemid);
		$query=$this->db->get();
		$totaloutward=$query->row();
		
		
		$totalin=$totalinward->qty+$totalinwardstock->qty;
		$totalout=$totaloutward->qty+$totaloutwardstock->qty+$openingstock->opening_stock+$warehouseopeningstock->warehouse_opening_stock+$totalassign->qty;
		return $totalout-$totalin;
	}

	public function getRentStockByItem($itemid,$warehouse_id="0")
	{

		$this->db->select('sum(qty) as qty');
		$this->db->from('tbl_inward_rent_item');
		if($warehouse_id!="0")
			$this->db->where('warehouse_id',$warehouse_id);
		$this->db->where('item_id',$itemid);
		$query=$this->db->get();
		$totalinward=$query->row();
		//echo $this->db->last_query();
		//print_r($totalinward->qty);
		//exit;
		$this->db->select('sum(qty) as qty');
		$this->db->from('tbl_rent_stock_transfer');
		if($warehouse_id!="0")
			$this->db->where('to_warehouse_id',$warehouse_id);
		$this->db->where('to_item_id',$itemid);
		$query=$this->db->get();
		$totalinwardstock=$query->row();
		
		$this->db->select('warehouse_opening_stock');
		$this->db->from('tbl_stock_rent_item');
		if($warehouse_id!="0")
			$this->db->where('warehouse_id',$warehouse_id);
		$this->db->where('item_id',$itemid);
		$query=$this->db->get();
		$openingstock=$query->row();

		$this->db->select('sum(qty) as qty');
		$this->db->from('tbl_asign_rent_item');
		$this->db->where('item_id',$itemid);
		if($warehouse_id!="0")
			$this->db->where('to_warehouse_id',$warehouse_id);
		$query=$this->db->get();
		$totalassign=$query->row();


		/*Outward stock*/
		$this->db->select('sum(qty) as qty');
		$this->db->from('tbl_rent_stock_transfer');
		if($warehouse_id!="0")
			$this->db->where('from_warehouse_id',$warehouse_id);
		$this->db->where('from_item_id',$itemid);
		$query=$this->db->get();
		$totaloutwardstock=$query->row();
		$this->db->select('sum(qty) as qty');
		$this->db->from('tbl_consignment_rent_stock_item');
		$this->db->join('tbl_consignment','tbl_consignment.consignment_id=tbl_consignment_rent_stock_item.consignment_id','left');
		if($warehouse_id!="0")
			$this->db->where('tbl_consignment.consignment_warehouse_id',$warehouse_id);
		$this->db->where('item_id',$itemid);
		$query=$this->db->get();
		$totaloutward=$query->row();
		
		
		$totalin=$totalinward->qty+$totalinwardstock->qty+$openingstock->warehouse_opening_stock+$totalassign->qty;
		$totalout=$totaloutward->qty+$totaloutwardstock->qty;
		return $totalin-$totalout;
	}


	public function getStockReportByItem($itemid,$date_from,$date_to,$consignee_id)
	{
		$query=$this->db->query("select sum(qty) as qty from tbl_inward_details where inward_id in(select inward_id from tbl_inward where inward_date <'".$date_from."' and destiantion_id='".$consignee_id."') and item_id=".$itemid);
		$totalinward=$query->row();

		$query=$this->db->query("select sum(qty) as qty from tbl_stock_transfer where to_consignee_id='".$consignee_id."' and  stock_transfer_date <='".$date_to."' and  to_item_id=".$itemid);
		$totalinwardstock=$query->row();
		
		/*Outward stock*/
		$query=$this->db->query("select sum(qty) as qty from tbl_stock_transfer where from_consignee_id='".$consignee_id."' and stock_transfer_date <='".$date_to."' and  from_item_id=".$itemid);
		$totaloutwardstock=$query->row();

		$query=$this->db->query("select sum(qty) as qty from tbl_consignment_stock_item where consignment_id in(select consignment_id from tbl_consignment where consignment_date <'".$date_from."' and consignee_id='".$consignee_id."') and item_id=".$itemid);
		$totaloutward=$query->row();
		$totalin=$totalinward->qty+$totalinwardstock->qty;
		$totalout=$totaloutwardstock->qty+$totaloutward->qty;
		return $totalin-$totalout;
	}
	public function getRentStockReportByItemdate($itemid,$date_from,$date_to,$consignee_id)
	{
		$query=$this->db->query("select sum(qty) as qty from tbl_inward_rent_item where inward_id in(select inward_id from tbl_inward where inward_date <'".$date_from."' and rent_consignee_id='".$consignee_id."') and item_id=".$itemid);
		$totalinward=$query->row();

		$query=$this->db->query("select sum(qty) as qty from tbl_rent_item_stock_transfer where to_id='".$consignee_id."' and stock_transfer_date <'".$date_from."' and  to_item_id=".$itemid);
		$totalinwardstock=$query->row();
		/*Outward stock*/
		$query=$this->db->query("select sum(qty) as qty from tbl_rent_item_stock_transfer where from_id='".$consignee_id."' and stock_transfer_date <'".$date_from."' and  from_item_id=".$itemid);
		$totaloutwardstock=$query->row();

		$query=$this->db->query("select sum(qty) as qty from tbl_asign_rent_item where consignee_id='".$consignee_id."' and asign_date <'".$date_from."' and  item_id=".$itemid);
		$totalasignstock=$query->row();

		$query=$this->db->query("select sum(qty) as qty from tbl_consignment_rent_stock_item where consignment_id in(select consignment_id from tbl_consignment where consignment_date <'".$date_from."' and consignee_id='".$consignee_id."') and item_id=".$itemid);
		$totaloutward=$query->row();
		$totalin=$totalinward->qty+$totalinwardstock->qty+$totalasignstock->qty;
		$totalout=$totaloutwardstock->qty+$totaloutward->qty;
		return $totalin-$totalout;
	}
	public function getstockbyconsignee()
	{
		$date_from=date("Y-m-d", strtotime($_POST['date_from']));
        $date_to=date("Y-m-d", strtotime($_POST['date_to']));
        $consignee_id=$_POST['consignee_name'];
        $response=array();
        $query=$this->db->select('`item_id`, `item_name`,opening_stock')
            ->from('tbl_item')
            ->where(array("consignee_id"=>$consignee_id))
            ->get();
		$record=$query->result_array();
		$response['other_item']=array();
		$response['other_item']=$record;


        //var_dump($record);
        $response['item']=array();
		foreach ($record as $row) {
			$temp=[];
			$temp['item_id']=$row['item_id'];
			$temp['item_name']=$row['item_name'];
			$temp['stock']=(($this->getStockReportByItem($row['item_id'],$date_from,$date_to,$consignee_id))+$row['opening_stock']);
			array_push($response['item'], $temp);
		}
		$query=$this->db->query("SELECT inward_date as date,item_id,sum(qty) as qty,'0' as type,'' as consignment_no,'' as vehicle_inward_no,'' as mobile_no, '' as d_c_no FROM `tbl_inward`  LEFT JOIN tbl_inward_details on tbl_inward_details.inward_id=tbl_inward.inward_id where tbl_inward.destiantion_id='".$consignee_id."' and inward_date>='".$date_from."' and inward_date<='".$date_to."' GROUP by inward_date,item_id
union
SELECT consignment_date as date,item_id,sum(qty) as qty,'1' as type,consignment_no,vehicle_inward_no,mobile_no,d_c_no FROM `tbl_consignment`  LEFT JOIN tbl_consignment_stock_item on tbl_consignment_stock_item.consignment_id=tbl_consignment.consignment_id
	LEFT JOIN tbl_vehicle_inward on tbl_vehicle_inward.vehicle_inward_id=tbl_consignment.vehicle_id
	where consignee_id='".$consignee_id."' and consignment_date>='".$date_from."' and consignment_date<='".$date_to."'
 GROUP by consignment_date,item_id,consignment_no  
ORDER BY `date`,consignment_no,item_id asc, type desc");
		$response['inward']=$query->result_array();
		
		return $response;
	}

	public function getrentstockbyconsignee()
	{
		$date_from=date("Y-m-d", strtotime($_POST['date_from']));
        $date_to=date("Y-m-d", strtotime($_POST['date_to']));
        $consignee_id=$_POST['consignee_name'];
        $query=$this->db->select('`item_id`, `item_name`,tbl_stock_rent_item.opening_stock,warehouse_opening_stock')
            ->from('tbl_stock_rent_item')
            ->join('tbl_rent_item_master', 'tbl_rent_item_master.master_item_id = tbl_stock_rent_item.master_item_id', 'left')
            ->where(array("consignee_id"=>$consignee_id))
            ->get();
        $record=$query->result_array();
		$response=array();
		$response['item']=array();
		foreach ($record as $row) {
			$temp=[];
			$temp['item_id']=$row['item_id'];
			$temp['item_name']=$row['item_name'];
			$temp['stock']=(($this->getRentStockReportByItemdate($row['item_id'],$date_from,$date_to,$consignee_id))+$row['opening_stock']);
			array_push($response['item'], $temp);
		}
		$query=$this->db->query("SELECT inward_date as date,item_id,sum(qty) as qty,'0' as type,'' as consignment_no,'' as vehicle_inward_no,'' as mobile_no FROM `tbl_inward`  LEFT JOIN tbl_inward_rent_item on tbl_inward_rent_item.inward_id=tbl_inward.inward_id where (tbl_inward.destiantion_id='".$consignee_id."' or rent_consignee_id='".$consignee_id."') and inward_date>='".$date_from."' and inward_date<='".$date_to."' GROUP by inward_date,item_id
union
SELECT consignment_date as date,item_id,sum(qty) as qty,'1' as type,consignment_no,vehicle_inward_no,mobile_no FROM `tbl_consignment`  LEFT JOIN tbl_consignment_rent_stock_item on tbl_consignment_rent_stock_item.consignment_id=tbl_consignment.consignment_id
	LEFT JOIN tbl_vehicle_inward on tbl_vehicle_inward.vehicle_inward_id=tbl_consignment.vehicle_id
	where consignee_id='".$consignee_id."'  and consignment_date>='".$date_from."' and consignment_date<='".$date_to."'
 GROUP by consignment_date,item_id,consignment_no  
ORDER BY `date`,consignment_no,item_id asc, type desc");
		
		$response['inward']=$query->result_array();
		return $response;
	}

	public function getwarehousestock($itemid,$consignee_id)
	{
		$query=$this->db->query("select sum(qty) as qty,warehouse_id,inward_id from tbl_inward_rent_item where inward_id in(select inward_id from tbl_inward where rent_consignee_id='".$consignee_id."') and item_id=".$itemid. " group by warehouse_id");
		$totalinward=$query->result_array();
		//var_dump($totalinward);
		//exit;
		$query=$this->db->query("select sum(qty) as qty,to_warehouse_id as warehouse_id from tbl_rent_item_stock_transfer where to_id='".$consignee_id."' and to_item_id=".$itemid." group by to_warehouse_id");
		$totalinwardstock=$query->result_array();
		/*Outward stock*/
		$query=$this->db->query("select sum(qty) as qty,from_warehouse_id as warehouse_id from tbl_rent_item_stock_transfer where from_id='".$consignee_id."'  and  from_item_id=".$itemid. " group by from_warehouse_id");
		$totaloutwardstock=$query->result_array();

		$query=$this->db->query("select sum(qty) as qty,to_warehouse_id as warehouse_id from tbl_asign_rent_item where consignee_id='".$consignee_id."'  and  item_id=".$itemid." group by to_warehouse_id");
		$totalasignstock=$query->result_array();

		$query=$this->db->query("select sum(qty) as qty,warehouse_id,consignment_id from tbl_consignment_rent_stock_item where consignment_id in(select consignment_id from tbl_consignment where  consignee_id='".$consignee_id."') and item_id=".$itemid. " group by warehouse_id");
		$totaloutward=$query->result_array();
		$query=$this->db->select('warehouse_id')
		->from('tbl_warehouse')
		->get();
		$warehouse_id=$query->result_array();
		$query=$this->db->select("warehouse_opening_stock,warehouse_id")
		->from('tbl_stock_rent_item')
		->where('item_id',$itemid)
		->get();
		$opstock=$query->row();
		$warehouse_id_array=array();
		$inwardarray=array();
		$ctr=0;
		foreach ($warehouse_id as $row) {
			# code...
			array_push($warehouse_id_array, $row['warehouse_id']);
			$inwardarray[$ctr]=0;
			$ctr++;
		}
		foreach ($totalinward as $row) {
			# code...
			$pos=array_search($row['warehouse_id'], $warehouse_id_array);
			$inwardarray[$pos]=$inwardarray[$pos]+$row['qty'];
		}

		foreach ($totalinwardstock as $row) {
			# code...
			$pos=array_search($row['warehouse_id'], $warehouse_id_array);
			$inwardarray[$pos]=$inwardarray[$pos]+$row['qty'];
		}
		//var_dump($inwardarray);

		foreach ($totalasignstock as $row) {
			# code...
			$pos=array_search($row['warehouse_id'], $warehouse_id_array);
			$inwardarray[$pos]=$inwardarray[$pos]+$row['qty'];
		}
		
		foreach ($totaloutwardstock as $row) {
			# code...
			$pos=array_search($row['warehouse_id'], $warehouse_id_array);
			$inwardarray[$pos]=$inwardarray[$pos]-$row['qty'];
		}
		//var_dump($inwardarray);
		//echo "<br/>";
		//var_dump($totaloutward);
		//exit;
		foreach ($totaloutward as $row) {
			# code...
			$pos=array_search($row['warehouse_id'], $warehouse_id_array);
			$inwardarray[$pos]=$inwardarray[$pos]-$row['qty'];
		}
		
		$pos=array_search($opstock->warehouse_id, $warehouse_id_array);
		//echo $pos;

		$inwardarray[$pos]=$inwardarray[$pos]+$opstock->warehouse_opening_stock;
		return $inwardarray;
	}
	public function getcostock($itemid,$consignee_id)
	{
		$query=$this->db->query("select sum(qty) as qty from tbl_inward_rent_item where inward_id in(select inward_id from tbl_inward where rent_consignee_id='".$consignee_id."') and item_id=".$itemid);
		$totalinward=$query->row();

		

		$query=$this->db->query("select sum(qty) as qty from tbl_consignment_rent_stock_item where consignment_id in(select consignment_id from tbl_consignment where  consignee_id='".$consignee_id."') and item_id=".$itemid);
		$totaloutward=$query->row();
		$totalin=$totalinward->qty;
		
		
		$totalout=$totaloutward->qty;

		$query=$this->db->select("opening_stock,warehouse_id")
		->from('tbl_stock_rent_item')
		->where('item_id',$itemid)
		->get();
		$opstock=$query->row();
		$stock=$totalout-$totalin;
		return $opstock->opening_stock+$stock;
	}
	public function getCoWiseStock()
	{
		$date_from=date("Y-m-d", strtotime($_POST['date_from']));
        $date_to=date("Y-m-d", strtotime($_POST['date_to']));
        $consignee_id=$_POST['consignee_name'];
		$query=$this->db->select('tbl_stock_rent_item.item_id,tbl_rent_item_master.master_item_id,item_name,tbl_stock_rent_item.opening_stock,warehouse_opening_stock')
		->from('tbl_rent_item_master')
		->join('tbl_stock_rent_item','tbl_stock_rent_item.master_item_id=tbl_rent_item_master.master_item_id','left')
		->where('tbl_stock_rent_item.consignee_id',$consignee_id)
		->order_by('tbl_stock_rent_item.item_id','asc')
		->get();
		$record=$query->result_array();
		$response=array();
		$response['item']=array();
		foreach ($record as $row) {
			# code...
			$temp=[];
			$temp['item_id']=$row['item_id'];
			$temp['item_name']=$row['item_name'];
			$totalstock=$this->getRentStockReportByItemdate($row['item_id'],$date_from,$date_to,$consignee_id);
			$temp['co_stock']=$totalstock+$row['opening_stock'];
			$temp['warehouse_stock']=$totalstock+$row['warehouse_opening_stock'];
			$temp['current_warehouse_stock']=$this->getwarehousestock($row['item_id'],$consignee_id);
			$temp['current_co_stock']=$this->getcostock($row['item_id'],$consignee_id);
			array_push($response['item'], $temp);
		}
		$query=$this->db->query("SELECT inward_date as date,item_id,sum(qty) as qty,'0' as type,tbl_inward.inward_id as consignment_no,'' as vehicle_inward_no,'' as mobile_no FROM `tbl_inward`  LEFT JOIN tbl_inward_rent_item on tbl_inward_rent_item.inward_id=tbl_inward.inward_id where (tbl_inward.rent_consignee_id='".$consignee_id."') and inward_date>='".$date_from."' and inward_date<='".$date_to."' and inward_type='1'  GROUP by tbl_inward.inward_id,inward_date,item_id
union
SELECT stock_transfer_date as date,to_item_id as item_id,sum(qty) as qty,'1' as type,'' as consignment_no,'' as vehicle_inward_no,'' as mobile_no FROM `tbl_rent_item_stock_transfer`  where (tbl_rent_item_stock_transfer.to_id='".$consignee_id."') and stock_transfer_date>='".$date_from."' and stock_transfer_date<='".$date_to."' GROUP by stock_transfer_date,to_item_id
union
SELECT asign_date as date, item_id,sum(qty) as qty,'2' as type,'' as consignment_no,'' as vehicle_inward_no,'' as mobile_no FROM `tbl_asign_rent_item`  where (tbl_asign_rent_item.consignee_id='".$consignee_id."') and asign_date>='".$date_from."' and asign_date<='".$date_to."' GROUP by asign_date,item_id
union
SELECT stock_transfer_date as date,from_item_id as item_id,sum(qty) as qty,'3' as type,'' as consignment_no,'' as vehicle_inward_no,'' as mobile_no FROM `tbl_rent_item_stock_transfer`  where (tbl_rent_item_stock_transfer.from_id='".$consignee_id."') and stock_transfer_date>='".$date_from."' and stock_transfer_date<='".$date_to."' GROUP by stock_transfer_date,from_item_id
union
SELECT consignment_date as date,item_id,sum(qty) as qty,'4' as type,consignment_no,vehicle_inward_no,mobile_no FROM `tbl_consignment`  LEFT JOIN tbl_consignment_rent_stock_item on tbl_consignment_rent_stock_item.consignment_id=tbl_consignment.consignment_id
	LEFT JOIN tbl_vehicle_inward on tbl_vehicle_inward.vehicle_inward_id=tbl_consignment.vehicle_id
	where consignee_id='".$consignee_id."'  and consignment_date>='".$date_from."' and consignment_date<='".$date_to."' and consignment_type='1' 
 GROUP by consignment_date,item_id,consignment_no 
ORDER BY `date`,type,consignment_no,item_id asc");
	//echo $this->db->last_query();
		$response['inward']=$query->result_array();
		return $response;
	}
	
}

?>