<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_item_master extends CI_Model{

    public function saveitem ($post)
    {
        //`id`, `uom_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['item_name']))
            $item_name="";
        else
            $item_name=$_POST['item_name'];
        if(empty($_POST['item_code']))
            $item_code="";
        else
            $item_code=$_POST['item_code'];
        if(empty($_POST['price']))
            $price="";
        else
            $price=$_POST['price'];

        if(empty($_POST['opening_stock']))
            $opening_stock="";
        else
            $opening_stock=$_POST['opening_stock'];

        if(empty($_POST['warehouse_id']))
            $warehouse_id="";
        else
            $warehouse_id=$_POST['warehouse_id'];

        $item_type=$_POST['item_type'];
        
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("item_name"=>$item_name,"item_code"=>$item_code,"price"=>$price,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_rent_item_master',$data);
        $lastid=$this->db->insert_id();
        for($i=0;$i<sizeof($_POST['warehouse_id']);$i++)
        {
            if(empty($_POST['opening_stock'][$i]))
                $data=array("warehouse_id"=>$warehouse_id,"qty"=>"0","item_id"=>$lastid);
            else
                $data=array("warehouse_id"=>$_POST['warehouse_id'][$i],"qty"=>$_POST['opening_stock'][$i],"item_id"=>$lastid);
            $this->db->insert('tbl_warehouse_opening_stock',$data);
        }
        return $lastid;
        

    }
    
    public function getitem($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`master_item_id`, `item_name`, `item_code`, `price`')
                ->from('tbl_rent_item_master')
                ->get();
            return $query->result_array();
        }
        else
        {

             $arr=array("master_item_id", "item_name","item_code","price");
            $this->db->select('`master_item_id`, `item_name`, `item_code`, `price`');
            if(!empty($searchstr))
            {
                $this->db->or_like('item_name', $searchstr);
                $this->db->or_like('item_code', $searchstr);
                $this->db->or_like('price', $searchstr);
                
            }
             $this->db->where('tbl_rent_item_master.is_deleted','0');
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_rent_item_master')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_rent_item_master');
            //$this->db->order_by('master_item_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getwarehouse($itemid)
    {
        $sql=$this->db->select('tbl_warehouse.warehouse_id,`warehouse_name`,warehouse_address,warehouse_gst_no,tbl_warehouse_opening_stock.qty')
                ->from('tbl_warehouse')
                ->where('tbl_warehouse.is_deleted', '0')
                ->where('tbl_warehouse_opening_stock.item_id', $itemid)
                ->join('tbl_warehouse_opening_stock','tbl_warehouse_opening_stock.warehouse_id=tbl_warehouse.warehouse_id','left')
                ->get();
        return $sql->result_array();
    }
    public function getitembyid($itemid)
    {
        $query=$this->db->select('`master_item_id`, `item_name`, `item_code`, `price`,tbl_warehouse_opening_stock.qty,tbl_warehouse_opening_stock.warehouse_id')
            ->from('tbl_rent_item_master')
            ->join('tbl_warehouse_opening_stock','tbl_warehouse_opening_stock.item_id=tbl_rent_item_master.master_item_id','left')
            ->join('tbl_warehouse','tbl_warehouse.warehouse_id=tbl_rent_item_master.warehouse_id','left')
            ->where(array("master_item_id"=>$itemid))
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
        if(empty($_POST['item_code']))
            $item_code="";
        else
            $item_code=$_POST['item_code'];
        if(empty($_POST['price']))
            $price="";
        else
            $price=$_POST['price'];
       
       if(empty($_POST['opening_stock']))
            $opening_stock="";
        else
            $opening_stock=$_POST['opening_stock'];

        if(empty($_POST['warehouse_id']))
            $warehouse_id="";
        else
            $warehouse_id=$_POST['warehouse_id'];
        $user_id=$this->session->userdata('user_id');

        $datetime=date('Y-m-d h:i:s');
        $data=array("item_name"=>$item_name,"item_code"=>$item_code,"price"=>$price,"updated_by"=>$user_id,"updated_datetime"=>$datetime);
        $lastid=encryptor("decrypt",$post['item_id']);
        $this->db->where('master_item_id', encryptor("decrypt",$post['item_id']));
        $this->db->update('tbl_rent_item_master',$data);
        $this->db->where("item_id",$lastid);
        $this->db->delete("tbl_warehouse_opening_stock");
        for($i=0;$i<sizeof($_POST['warehouse_id']);$i++)
        {
            if(empty($_POST['opening_stock'][$i]))
                $data=array("warehouse_id"=>$warehouse_id,"qty"=>"0","item_id"=>$lastid);
            else
                $data=array("warehouse_id"=>$_POST['warehouse_id'][$i],"qty"=>$_POST['opening_stock'][$i],"item_id"=>$lastid);
            $this->db->insert('tbl_warehouse_opening_stock',$data);
        }
        
        
        return $lastid;
    }
   
   public function deletebyid($itemid)
    {
        if($this->session->userdata('user_id')==1){
            $this->db->where('master_item_id', $itemid);
            $this->db->delete('tbl_rent_item_master');
            //echo $this->db->last_query(); exit();
        }
        else
        {
            $data = array("is_deleted" => '1');
            $this->db->where('master_item_id', $itemid);
            $this->db->update('tbl_rent_item_master', $data);
        }
        return $this->db->affected_rows();
    }
   
    public function getitem_master()
    {
        $query=$this->db->select('`master_item_id`, `item_name`, `item_code`, `price`')
        ->from('tbl_rent_item_master')
        ->get();
        return $query->result_array();
    }

}
?>