<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_salesitem extends CI_Model{

    public function saveitem ($post)
    {
        if(empty($_POST['item_name']))
            $item_name="";
        else
            $item_name=$_POST['item_name'];
        if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];
        if(empty($_POST['opening_stock']))
            $opening_stock="";
        else
            $opening_stock=$_POST['opening_stock'];

        $item_type=$_POST['item_type'];
        
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        
        if($item_type=="transport"){
            $data=array("item_name"=>$item_name,"consignee_id"=>$consignee_id,"opening_stock"=>$opening_stock,"created_by"=>$user_id,"created_datetime"=>$datetime);
            $this->db->insert('tbl_item',$data);
        }
            
        else
        {
            if(empty($_POST['warehouse_id']))
                $warehouse_id="";
            else
                $warehouse_id=$_POST['warehouse_id'];
            if(empty($_POST['warehouse_opening_stock']))
                $warehouse_opening_stock="";
            else
                $warehouse_opening_stock=$_POST['warehouse_opening_stock'];
            $data=array("master_item_id"=>$item_name,"consignee_id"=>$consignee_id,"opening_stock"=>$opening_stock,"warehouse_id"=>$warehouse_id,"warehouse_opening_stock"=>$warehouse_opening_stock,"created_by"=>$user_id,"created_datetime"=>$datetime);
            $this->db->insert('tbl_stock_rent_item',$data);

        }
            
        $lastid=$this->db->insert_id();
        return $lastid;
    }
    
    
      public function getpricebyconsignee($consigneeid,$itemid)
    {
         $query=$this->db->select('`tbl_item.item_id`, `tbl_item.item_name`,`tbl_item.price`, `tbl_outward_rate.advance`, `tbl_outward_rate.due`')
                        ->from('tbl_item')
                        ->join('tbl_outward_rate', 'tbl_outward_rate.item = tbl_item.item_id', 'left')
                        ->where("tbl_outward_rate.consignee_id",$consigneeid)
                        ->where("tbl_outward_rate.item",$itemid)
                        ->get();
           // echo $this->db->last_query();
            return $query->row();
    }
    
    public function getitem($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`item_id`, `item_name`, `consignee_id`, `opening_stock`')
                ->from('tbl_item')
                ->get();
            return $query->result_array();
        }
        else
        {

             $arr=array("item_id", "item_name","consignee_name","opening_stock");
            $this->db->select('`item_id`, `item_name`,consignee_name,opening_stock');
            if(!empty($searchstr))
            {
                $this->db->or_like('item_name', $searchstr);
                $this->db->or_like('consignee_name', $searchstr);
                $this->db->or_like('opening_stock', $searchstr);
                
            }
             $this->db->where('tbl_item.is_deleted','0');
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_item')->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_item.consignee_id', 'left')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_item');
            $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_item.consignee_id', 'left');
            $this->db->order_by('item_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getrentitem($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`item_id`,tbl_rent_item_master.price')
                ->from('tbl_stock_rent_item')
                ->join('tbl_rent_item_master', 'tbl_rent_item_master.master_item_id = tbl_stock_rent_item.master_item_id', 'left')
                ->get();
            return $query->result_array();
        }
        else
        {

             $arr=array("item_id", "item_name","consignee_name","tbl_stock_rent_item.opening_stock","price");
            $this->db->select('`item_id`, `item_name`,consignee_name,tbl_stock_rent_item.opening_stock,tbl_rent_item_master.master_item_id,tbl_rent_item_master.price,tbl_stock_rent_item.consignee_id');
            if(!empty($searchstr))
            {
                $this->db->or_like('item_name', $searchstr);
                $this->db->or_like('consignee_name', $searchstr);
                $this->db->or_like('tbl_stock_rent_item.opening_stock', $searchstr);
                
            }
             $this->db->where('tbl_stock_rent_item.is_deleted','0');
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_stock_rent_item')->join('tbl_rent_item_master', 'tbl_rent_item_master.master_item_id = tbl_stock_rent_item.master_item_id', 'left')->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_stock_rent_item.consignee_id', 'left')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_stock_rent_item');
            $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_stock_rent_item.consignee_id', 'left');
            $this->db->join('tbl_rent_item_master', 'tbl_rent_item_master.master_item_id = tbl_stock_rent_item.master_item_id', 'left');
            $this->db->order_by('item_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getitembyid($itemid)
    {
        $query=$this->db->select('`item_id`, `item_name`, `consignee_id`, `opening_stock`,"transport" as item_type')
            ->from('tbl_item')
            ->where(array("item_id"=>$itemid))
            ->get();
        $record['item']=$query->result_array();
        
        return $record;
    }
    public function getrentitembyid($itemid)
    {
        $query=$this->db->select('`item_id`, `master_item_id`, `consignee_id`, `opening_stock`,"rent" as item_type,warehouse_id,warehouse_opening_stock')
            ->from('tbl_stock_rent_item')
            ->where(array("item_id"=>$itemid))
            ->get();
        $record['item']=$query->result_array();
        
        return $record;
    }
    public function updateitem($post)
    {
        if(empty($_POST['item_name']))
            $item_name="";
        else
            $item_name=$_POST['item_name'];
        if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];
        if(empty($_POST['opening_stock']))
            $opening_stock="";
        else
            $opening_stock=$_POST['opening_stock'];
       
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("item_name"=>$item_name,"consignee_id"=>$consignee_id,"opening_stock"=>$opening_stock,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
         $lastid=encryptor("decrypt",$post['item_id']);
        $this->db->where('item_id', encryptor("decrypt",$post['item_id']));
        $item_type=$_POST['item_type'];
        if($item_type=="transport"){
            $data=array("item_name"=>$item_name,"consignee_id"=>$consignee_id,"opening_stock"=>$opening_stock,"updated_by"=>$user_id,"updated_datetime"=>$datetime);
            $this->db->update('tbl_item',$data);
        }
            
        else
        {
            if(empty($_POST['warehouse_id']))
                $warehouse_id="";
            else
                $warehouse_id=$_POST['warehouse_id'];
            if(empty($_POST['warehouse_opening_stock']))
                $warehouse_opening_stock="";
            else
                $warehouse_opening_stock=$_POST['warehouse_opening_stock'];
            $data=array("master_item_id"=>$item_name,"consignee_id"=>$consignee_id,"opening_stock"=>$opening_stock,"warehouse_id"=>$warehouse_id,"warehouse_opening_stock"=>$warehouse_opening_stock,"updated_by"=>$user_id,"updated_datetime"=>$datetime);
            $this->db->update('tbl_stock_rent_item',$data);

        }
        
        return $lastid;
    }
        public function deletebyid($itemid)
    {
        if($this->session->userdata('user_id')==1){
           $data = array("is_deleted" => '1');
            $this->db->where('item_id', $itemid);
            $this->db->update('tbl_item', $data);
        }
        else
        {
            $data = array("is_deleted" => '1');
            $this->db->where('item_id', $itemid);
            $this->db->update('tbl_item', $data);
        }
        return $this->db->affected_rows();
    }

    public function deleterentrecordbyid($itemid)
    {
        if($this->session->userdata('user_id')==1){
            $this->db->where('item_id', $itemid);
            $this->db->delete('tbl_stock_rent_item');
            //echo $this->db->last_query(); exit();
        }
        else
        {
            $data = array("is_deleted" => '1');
            $this->db->where('item_id', $itemid);
            $this->db->update('tbl_stock_rent_item', $data);
        }
        return $this->db->affected_rows();
    }
    public function getItemByConsignee($consigneeid)
    {
        $query=$this->db->select('`item_id`, `item_name`')
            ->from('tbl_item')
           // ->where(array("consignee_id"=>$consigneeid))
           ->where(array("consignee_id"=>$consigneeid,"is_deleted"=>0,))
            ->get();
            return $query->result_array();
    }
    public function getRentItemByConsignee($consigneeid)
    {
        $query=$this->db->select('`item_id`, `item_name`')
            ->from('tbl_stock_rent_item')
            ->join('tbl_rent_item_master', 'tbl_rent_item_master.master_item_id = tbl_stock_rent_item.master_item_id', 'left')
            ->where(array("consignee_id"=>$consigneeid))
            ->get();
            return $query->result_array();
    }

}
?>
