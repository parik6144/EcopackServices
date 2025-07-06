<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_purchase_item extends CI_Model{

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
        if(empty($_POST['uom_id']))
            $uom_id="";
        else
            $uom_id=$_POST['uom_id'];
        if(empty($_POST['opening_stock']))
            $opening_stock="";
        else
            $opening_stock=$_POST['opening_stock'];

        
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("item_name"=>$item_name,"uom_id"=>$uom_id,"item_code"=>$item_code,"opening_stock"=>$opening_stock,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('purchase_stock_item',$data);
         $lastid=$this->db->insert_id();
        return $lastid;
        

    }
    public function getitem($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`item_id`, `item_code`, `item_name`, `uom_id`, `hsn_code`, `opening_stock`')
                ->from('purchase_stock_item')
                ->get();
            return $query->result_array();
        }
        else
        {

             $arr=array("item_id","item_code", "item_name","short_name","opening_stock");
            $this->db->select('`item_id`,item_code, `item_name`,short_name,opening_stock');
            if(!empty($searchstr))
            {
                $this->db->or_like('item_code', $searchstr);
                $this->db->or_like('item_name', $searchstr);
                $this->db->or_like('short_name', $searchstr);
                $this->db->or_like('opening_stock', $searchstr);
                
            }
             $this->db->where('purchase_stock_item.is_deleted','0');
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('purchase_stock_item')->join('tbl_uom', 'tbl_uom.uom_id = purchase_stock_item.uom_id', 'left')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('purchase_stock_item');
            $this->db->join('tbl_uom', 'tbl_uom.uom_id = purchase_stock_item.uom_id', 'left');
            $this->db->order_by('item_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getitembyid($itemid)
    {
        $query=$this->db->select('`item_id`, item_code,`item_name`, `uom_id`, `opening_stock`')
            ->from('purchase_stock_item')
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
        if(empty($_POST['uom_id']))
            $uom_id="";
        else
            $uom_id=$_POST['uom_id'];
        if(empty($_POST['opening_stock']))
            $opening_stock="";
        else
            $opening_stock=$_POST['opening_stock'];
       if(empty($_POST['item_code']))
            $item_code="";
        else
            $item_code=$_POST['item_code'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("item_name"=>$item_name,"item_code"=>$item_code,"uom_id"=>$uom_id,"opening_stock"=>$opening_stock,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
         $lastid=encryptor("decrypt",$post['item_id']);
        $this->db->where('item_id', encryptor("decrypt",$post['item_id']));
        $this->db->update('purchase_stock_item',$data);
        return $lastid;
    }
    public function deletebyid($itemid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('item_id', $itemid);
        $this->db->update('purchase_stock_item',$data);
        return $this->db->affected_rows();
    }
    public function getItemByConsignee($consigneeid)
    {
        $query=$this->db->select('`item_id`, `item_name`')
            ->from('purchase_stock_item')
            ->where(array("uom_id"=>$consigneeid))
            ->get();
            return $query->result_array();
    }

}
?>