<?php
class Mdl_rentstocktransfer extends CI_Model{
	public function getstocktransfer($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        $arr=array("stock_transfer_id","stock_transfer_date", "from_warehouse.warehouse_name","from_consignee.consignee_name","from_rent_item_master.item_name", "to_warehouse.warehouse_name","to_rent_item_master.item_name", "qty");
        if($start=='' && $length=='' && $searchstr=='')
        {

            $query=$this->db->select(' `stock_transfer_id`, `stock_transfer_date`, `from_id`, `to_id`,`from_item_id`, `to_item_id`, `qty`')
                ->from('tbl_rent_item_stock_transfer')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('`stock_transfer_id`, `stock_transfer_date`, `from_id`, `to_id`,from_consignee.consignee_name as from_consignee_name,to_consignee.consignee_name as to_consignee_name,`from_item_id`, `to_item_id`,from_item.master_item_id,to_item.master_item_id, `qty`,from_rent_item_master.item_name as from_item_name,to_rent_item_master.item_name as to_item_name,from_warehouse.warehouse_name as from_warehouse,to_warehouse.warehouse_name as to_warehouse');
            if(!empty($searchstr))
            {
                $this->db->or_like('stock_transfer_date', $searchstr);
                $this->db->or_like('from_consignee.consignee_name', $searchstr);
                $this->db->or_like('to_consignee.consignee_name', $searchstr);
                $this->db->or_like('from_rent_item_master.item_name', $searchstr);
                $this->db->or_like('to_rent_item_master.item_name', $searchstr);
                $this->db->or_like('qty', $searchstr);
            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_rent_item_stock_transfer')
            ->join('tbl_consignee as from_consignee', 'from_consignee.consignee_id = tbl_rent_item_stock_transfer.from_id', 'left')
            ->join('tbl_consignee as to_consignee', 'to_consignee.consignee_id = tbl_rent_item_stock_transfer.to_id', 'left')
            ->join('tbl_stock_rent_item as from_item', 'from_item.item_id = tbl_rent_item_stock_transfer.from_item_id', 'left')
            ->join('tbl_stock_rent_item as to_item', 'to_item.item_id = tbl_rent_item_stock_transfer.to_item_id', 'left')
            ->join('tbl_warehouse as from_warehouse', 'from_warehouse.warehouse_id = tbl_rent_item_stock_transfer.from_warehouse_id', 'left')
            ->join('tbl_warehouse as to_warehouse', 'to_warehouse.warehouse_id = tbl_rent_item_stock_transfer.to_warehouse_id', 'left')
            ->join('tbl_rent_item_master as from_rent_item_master', 'from_rent_item_master.master_item_id = from_item.master_item_id', 'left')
            ->join('tbl_rent_item_master as to_rent_item_master', 'to_rent_item_master.master_item_id = to_item.master_item_id', 'left')
            ->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_rent_item_stock_transfer');
            $this->db->join('tbl_consignee as from_consignee', 'from_consignee.consignee_id = tbl_rent_item_stock_transfer.from_id', 'left');
            $this->db->join('tbl_consignee as to_consignee', 'to_consignee.consignee_id = tbl_rent_item_stock_transfer.to_id', 'left');
            $this->db->join('tbl_stock_rent_item as from_item', 'from_item.item_id = tbl_rent_item_stock_transfer.from_item_id', 'left');
            $this->db->join('tbl_stock_rent_item as to_item', 'to_item.item_id = tbl_rent_item_stock_transfer.to_item_id', 'left');
            $this->db->join('tbl_warehouse as from_warehouse', 'from_warehouse.warehouse_id = tbl_rent_item_stock_transfer.from_warehouse_id', 'left');
            $this->db->join('tbl_warehouse as to_warehouse', 'to_warehouse.warehouse_id = tbl_rent_item_stock_transfer.to_warehouse_id', 'left');
            $this->db->join('tbl_rent_item_master as from_rent_item_master', 'from_rent_item_master.master_item_id = from_item.master_item_id', 'left');
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

        if(empty($_POST['from_consignee_id']))
            $from_consignee_id="";
        else
            $from_consignee_id=$_POST['from_consignee_id'];

        if(empty($_POST['from_item_id']))
            $from_item_id="";
        else
            $from_item_id=$_POST['from_item_id'];

        if(empty($_POST['to_warehouse_id']))
            $to_warehouse_id="";
        else
            $to_warehouse_id=$_POST['to_warehouse_id'];

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

        if(empty($_POST['consignment_id']))
            $consignment_id="";
        else
            $consignment_id=$_POST['consignment_id'];

        $date=date('Y-m-d');
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        $data=array("stock_transfer_date"=>$date,"from_id"=>$from_consignee_id,"to_id"=>$to_consignee_id,"from_item_id"=>$from_item_id,"to_item_id"=>$to_item_id,"qty"=>$qty,"from_warehouse_id"=>$from_warehouse_id,"to_warehouse_id"=>$to_warehouse_id,"consignment_id"=>$consignment_id,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_rent_item_stock_transfer',$data);
        return $this->db->insert_id();
    }
    public function getstocktransferbyid($stock_transfer_id)
    {
    	$query=$this->db->select(' `stock_transfer_id`, `stock_transfer_date`, `from_id`, `to_id`,`from_item_id`, `to_item_id`, `qty`')
                ->from('tbl_rent_item_stock_transfer')
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

        if(empty($_POST['to_id']))
            $to_id="";
        else
            $to_id=$_POST['to_id'];

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
        $data=array("stock_transfer_date"=>$date,"from_id"=>$from_id,"to_id"=>$to_id,"from_item_id"=>$from_item_id,"to_item_id"=>$to_item_id,"qty"=>$qty,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->where('stock_transfer_id',$stock_transfer_id);
        $this->db->update('tbl_rent_item_stock_transfer',$data);
        return $this->db->insert_id();
    }
    public function deletebyid($refid)
    {
        $this->db->where('stock_transfer_id', $refid);
        $this->db->delete('tbl_rent_item_stock_transfer'); 
    }
    public function transitconsignment()
    {
        $query=$this->db->select('distinct(tbl_rent_item_stock_transfer.consignment_id),consignment_no')
        ->from('tbl_rent_item_stock_transfer')
        ->join('tbl_consignment','tbl_consignment.consignment_id=tbl_rent_item_stock_transfer.consignment_id')
        ->where('tbl_rent_item_stock_transfer.consignment_id NOT IN (select tbl_inward.consignment_id from tbl_inward)', NULL, FALSE)
        ->get();
        return $query->result_array();


    }
    public function getStockByConsignment($consignment_id)
    {
        $sql=$this->db->select('`from_warehouse_id`, `from_id`, `from_item_id`, `to_warehouse_id`, `to_id`, `to_item_id`, `qty`, `consignment_id`')
        ->from('tbl_rent_item_stock_transfer')
        ->where('consignment_id',$consignment_id)
        ->get();
        return $sql->result_array();
    }
}