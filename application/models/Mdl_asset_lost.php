<?php
class Mdl_asset_lost extends CI_Model{
	public function getassetlost($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        $arr=array("asset_lost_date","warehouse_name", "consignee_name", "item_name","qty", "lost_type", "remarks");
        if($start=='' && $length=='' && $searchstr=='')
        {

            $query=$this->db->select(' `asset_lost_id`, `asset_lost_date`, `warehouse_id`, `consignee_id`, `item_id`, `qty`, `lost_type`, `remarks`')
                ->from('tbl_asset_lost')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('`asset_lost_id`, `asset_lost_date`, `warehouse_name`, `consignee_name, `item_name`, `qty`,lost_type,remarks');
            if(!empty($searchstr))
            {
                $this->db->or_like('asset_lost_date', $searchstr);
                $this->db->or_like('consignee_name', $searchstr);
                $this->db->or_like('item_name', $searchstr);
                $this->db->or_like('qty', $searchstr);
                $this->db->or_like('remarks', $searchstr);

            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_asset_lost')
            ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_asset_lost.consignee_id', 'left')
            ->join('tbl_stock_rent_item', 'tbl_stock_rent_item.item_id = tbl_asset_lost.item_id', 'left')
            ->join('tbl_rent_item_master', 'tbl_rent_item_master.master_item_id = tbl_stock_rent_item.master_item_id', 'left')
            ->join('tbl_warehouse', 'tbl_warehouse.warehouse_id = tbl_asset_lost.warehouse_id', 'left')
            ->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_asset_lost');
            $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_asset_lost.consignee_id', 'left');
            $this->db->join('tbl_stock_rent_item', 'tbl_stock_rent_item.item_id = tbl_asset_lost.item_id', 'left');
            $this->db->join('tbl_rent_item_master', 'tbl_rent_item_master.master_item_id = tbl_stock_rent_item.master_item_id', 'left');
            $this->db->join('tbl_warehouse', 'tbl_warehouse.warehouse_id = tbl_asset_lost.warehouse_id', 'left');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function savestocktransfer($post)
    {
    	if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];

        if(empty($_POST['from_warehouse_id']))
            $from_warehouse_id="";
        else
            $from_warehouse_id=$_POST['from_warehouse_id'];

        if(empty($_POST['item_id']))
            $item_id="";
        else
            $item_id=$_POST['item_id'];

        if(empty($_POST['qty']))
            $qty="";
        else
            $qty=$_POST['qty'];

        if(empty($_POST['lost_type']))
            $lost_type="";
        else
            $lost_type=$_POST['lost_type'];

        if(empty($_POST['remarks']))
            $remarks="";
        else
            $remarks=$_POST['remarks'];


        $date=date('Y-m-d');
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        $data=array("asset_lost_date"=>$date,"consignee_id"=>$consignee_id,"item_id"=>$item_id,"qty"=>$qty,"warehouse_id"=>$from_warehouse_id,"lost_type"=>$lost_type,"remarks"=>$remarks,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_asset_lost',$data);
        return $this->db->insert_id();
    }
    
    public function updatestocktransfer($post)
    {
    	if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];

        if(empty($_POST['item_id']))
            $item_id="";
        else
            $item_id=$_POST['item_id'];

        if(empty($_POST['to_consignee_id']))
            $to_consignee_id="";
        else
            $to_consignee_id=$_POST['to_consignee_id'];

        if(empty($_POST['to_item_id']))
            $to_item_id="";
        else
            $to_item_id=$_POST['to_item_id'];

        if(empty($_POST['qty']))
            $qty="";
        else
            $qty=$_POST['qty'];

        $date=date('Y-m-d');
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $stock_transfer_id=encryptor("decrypt",$_POST['stock_transfer_id']);
        $data=array("asset_lost_date"=>$date,"consignee_id"=>$consignee_id,"to_consignee_id"=>$to_consignee_id,"item_id"=>$item_id,"to_item_id"=>$to_item_id,"qty"=>$qty,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->where('stock_transfer_id',$stock_transfer_id);
        $this->db->update('tbl_asset_lost',$data);
        return $this->db->insert_id();
    }
    public function deletebyid($asset_lost_id)
    {
         $this->db->where('asset_lost_id',$asset_lost_id);
        $this->db->delete('tbl_asset_lost');
        return "1";
    }
}