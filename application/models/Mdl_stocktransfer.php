<?php
class Mdl_stocktransfer extends CI_Model{
	public function getstocktransfer($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        $arr=array("stock_transfer_date", "from_consignee_id", "to_consignee_id","from_item_id", "to_item_id", "qty");
        if($start=='' && $length=='' && $searchstr=='')
        {

            $query=$this->db->select(' `stock_transfer_id`, `stock_transfer_date`, `from_consignee_id`, `to_consignee_id`,`from_item_id`, `to_item_id`, `qty`')
                ->from('tbl_stock_transfer')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('`stock_transfer_id`, `stock_transfer_date`, `from_consignee_id`, `to_consignee_id`,from_consignee.consignee_name as from_consignee_name,to_consignee.consignee_name as to_consignee_name,`from_item_id`, `to_item_id`, `qty`,from_item.item_name as from_item_name,to_item.item_name as to_item_name');
            if(!empty($searchstr))
            {
                $this->db->or_like('stock_transfer_date', $searchstr);
                $this->db->or_like('from_consignee.consignee_name', $searchstr);
                $this->db->or_like('to_consignee.consignee_name', $searchstr);
                $this->db->or_like('from_item.item_name', $searchstr);
                $this->db->or_like('to_item.item_name', $searchstr);
                $this->db->or_like('qty', $searchstr);
            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_stock_transfer')
            ->join('tbl_consignee as from_consignee', 'from_consignee.consignee_id = tbl_stock_transfer.from_consignee_id', 'left')
            ->join('tbl_consignee as to_consignee', 'to_consignee.consignee_id = tbl_stock_transfer.to_consignee_id', 'left')
            ->join('tbl_item as from_item', 'from_item.item_id = tbl_stock_transfer.from_item_id', 'left')
            ->join('tbl_item as to_item', 'to_item.item_id = tbl_stock_transfer.to_item_id', 'left')
            ->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_stock_transfer');
            $this->db->join('tbl_consignee as from_consignee', 'from_consignee.consignee_id = tbl_stock_transfer.from_consignee_id', 'left');
            $this->db->join('tbl_consignee as to_consignee', 'to_consignee.consignee_id = tbl_stock_transfer.to_consignee_id', 'left');
            $this->db->join('tbl_item as from_item', 'from_item.item_id = tbl_stock_transfer.from_item_id', 'left');
            $this->db->join('tbl_item as to_item', 'to_item.item_id = tbl_stock_transfer.to_item_id', 'left');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function savestocktransfer($post)
    {
    	if(empty($_POST['from_consignee_id']))
            $from_consignee_id="";
        else
            $from_consignee_id=$_POST['from_consignee_id'];

        if(empty($_POST['from_item_id']))
            $from_item_id="";
        else
            $from_item_id=$_POST['from_item_id'];

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

        $data=array("stock_transfer_date"=>$date,"from_consignee_id"=>$from_consignee_id,"to_consignee_id"=>$to_consignee_id,"from_item_id"=>$from_item_id,"to_item_id"=>$to_item_id,"qty"=>$qty,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_stock_transfer',$data);
        return $this->db->insert_id();
    }
    public function getstocktransferbyid($stock_transfer_id)
    {
    	$query=$this->db->select(' `stock_transfer_id`, `stock_transfer_date`, `from_consignee_id`, `to_consignee_id`,`from_item_id`, `to_item_id`, `qty`')
                ->from('tbl_stock_transfer')
                ->where('stock_transfer_id',$stock_transfer_id)
                ->get();
            return $query->row();
    }
    public function updatestocktransfer($post)
    {
    	if(empty($_POST['from_consignee_id']))
            $from_consignee_id="";
        else
            $from_consignee_id=$_POST['from_consignee_id'];

        if(empty($_POST['from_item_id']))
            $from_item_id="";
        else
            $from_item_id=$_POST['from_item_id'];

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
        $data=array("stock_transfer_date"=>$date,"from_consignee_id"=>$from_consignee_id,"to_consignee_id"=>$to_consignee_id,"from_item_id"=>$from_item_id,"to_item_id"=>$to_item_id,"qty"=>$qty,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->where('stock_transfer_id',$stock_transfer_id);
        $this->db->update('tbl_stock_transfer',$data);
        return $this->db->insert_id();
    }
}