<?php
class Mdl_asign_rent_item extends CI_Model{
	public function getasignitem($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        $arr=array("asign_rent_item_id","asign_date", "from_warehouse", "from_item_name","to_warehouse","to_item_name", "qty");
        if($start=='' && $length=='' && $searchstr=='')
        {

            $query=$this->db->select(' `asign_rent_item_id`, `stock_transfer_date`, `from_id`, `consignee_id`,`from_item_id`, `item_id`, `qty`')
                ->from('tbl_asign_rent_item')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('`asign_rent_item_id`, `asign_date`,tbl_consignee.consignee_name, `qty`,tbl_rent_item_master.item_name as from_item_name,to_rent_item_master.item_name as to_item_name,from_warehouse.warehouse_name as from_warehouse,to_warehouse.warehouse_name as to_warehouse');
            if(!empty($searchstr))
            {
                
                $this->db->or_like('tbl_consignee.consignee_name', $searchstr);
                $this->db->or_like('tbl_rent_item_master.item_name', $searchstr);
                $this->db->or_like('to_rent_item_master.item_name', $searchstr);
                $this->db->or_like('qty', $searchstr);
            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_asign_rent_item')
            ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_asign_rent_item.consignee_id', 'left')
            ->join('tbl_stock_rent_item as to_item', 'to_item.item_id = tbl_asign_rent_item.item_id', 'left')
            ->join('tbl_warehouse as from_warehouse', 'from_warehouse.warehouse_id = tbl_asign_rent_item.from_warehouse_id', 'left')
            ->join('tbl_warehouse as to_warehouse', 'to_warehouse.warehouse_id = tbl_asign_rent_item.to_warehouse_id', 'left')
            ->join('tbl_rent_item_master', 'tbl_rent_item_master.master_item_id = tbl_asign_rent_item.master_item_id', 'left')
            ->join('tbl_rent_item_master as to_rent_item_master', 'to_rent_item_master.master_item_id = to_item.master_item_id', 'left')
            ->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_asign_rent_item');
            $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_asign_rent_item.consignee_id', 'left');
            $this->db->join('tbl_stock_rent_item as to_item', 'to_item.item_id = tbl_asign_rent_item.item_id', 'left');
            $this->db->join('tbl_warehouse as from_warehouse', 'from_warehouse.warehouse_id = tbl_asign_rent_item.from_warehouse_id', 'left');
            $this->db->join('tbl_warehouse as to_warehouse', 'to_warehouse.warehouse_id = tbl_asign_rent_item.to_warehouse_id', 'left');
            $this->db->join('tbl_rent_item_master', 'tbl_rent_item_master.master_item_id = tbl_asign_rent_item.master_item_id', 'left');
            $this->db->join('tbl_rent_item_master as to_rent_item_master', 'to_rent_item_master.master_item_id = to_item.master_item_id', 'left');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function savestocktransfer($post)
    {
    	if(empty($_POST['from_warehouse_id']))
            $from_warehouse_id="";
        else
            $from_warehouse_id=$_POST['from_warehouse_id'];

        if(empty($_POST['master_item_id']))
            $master_item_id="";
        else
            $master_item_id=$_POST['master_item_id'];

        if(empty($_POST['to_warehouse_id']))
            $to_warehouse_id="";
        else
            $to_warehouse_id=$_POST['to_warehouse_id'];

        if(empty($_POST['to_consignee_id']))
            $to_consignee_id="";
        else
            $to_consignee_id=$_POST['to_consignee_id'];

        if(empty($_POST['to_item_id']))
            $item_id="";
        else
            $item_id=$_POST['to_item_id'];

        if(empty($_POST['qty']))
            $qty="";
        else
            $qty=$_POST['qty'];

        $date=date('Y-m-d');
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        $data=array("asign_date"=>$date,"consignee_id"=>$to_consignee_id,"master_item_id"=>$master_item_id,"item_id"=>$item_id,"qty"=>$qty,"from_warehouse_id"=>$from_warehouse_id,"to_warehouse_id"=>$to_warehouse_id,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_asign_rent_item',$data);
        return $this->db->insert_id();
    }
    public function getstocktransferbyid($stock_transfer_id)
    {
    	$query=$this->db->select('`asign_rent_item_id`, `master_item_id`, `from_warehouse_id`, `to_warehouse_id`, `consignee_id`, `item_id`, `qty`, `asign_date`')
                ->from('tbl_asign_rent_item')
                ->where('stock_transfer_id',$stock_transfer_id)
                ->get();
            return $query->row();
    }
    public function updatestocktransfer($post)
    {
    	if(empty($_POST['from_id']))
            $from_id="";
        else
            $from_id=$_POST['from_id'];

        if(empty($_POST['from_item_id']))
            $from_item_id="";
        else
            $from_item_id=$_POST['from_item_id'];

        if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];

        if(empty($_POST['item_id']))
            $item_id="";
        else
            $item_id=$_POST['item_id'];

        if(empty($_POST['qty']))
            $qty="";
        else
            $qty=$_POST['qty'];

        $date=date('Y-m-d');
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $stock_transfer_id=encryptor("decrypt",$_POST['stock_transfer_id']);
        $data=array("stock_transfer_date"=>$date,"from_id"=>$from_id,"consignee_id"=>$consignee_id,"from_item_id"=>$from_item_id,"item_id"=>$item_id,"qty"=>$qty,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->where('stock_transfer_id',$stock_transfer_id);
        $this->db->update('tbl_asign_rent_item',$data);
        return $this->db->insert_id();
    }
    public function deletebyid($refid)
    {
        $this->db->where('asign_rent_item_id', $refid);
        $this->db->delete('tbl_asign_rent_item'); 
    }
}