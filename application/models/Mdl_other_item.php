<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_other_item extends CI_Model{

    public function saveitem ($post)
    {
        //`id`, `uom_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['other_item_name']))
            $other_item_name="";
        else
            $other_item_name=$_POST['other_item_name'];
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
            $data=array("other_item_name"=>$other_item_name,"consignee_id"=>$consignee_id,"opening_stock"=>$opening_stock,"created_by"=>$user_id,"created_datetime"=>$datetime);
            $this->db->insert('tbl_other_item',$data);
        }  
         $lastid=$this->db->insert_id();
        return $lastid;
        

    }
    public function getitem($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`other_item_id`, `other_item_name`, `consignee_id`, `opening_stock`')
                ->from('tbl_other_item')
                ->get();
            return $query->result_array();
        }
        else
        {

             $arr=array("other_item_id", "other_item_name","consignee_name","opening_stock");
            $this->db->select('`other_item_id`, `other_item_name`,consignee_name,opening_stock');
            if(!empty($searchstr))
            {
                $this->db->or_like('other_item_name', $searchstr);
                $this->db->or_like('consignee_name', $searchstr);
                $this->db->or_like('opening_stock', $searchstr);
                
            }
             $this->db->where('tbl_other_item.is_deleted','0');
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_other_item')->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_other_item.consignee_id', 'left')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_other_item');
            $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_other_item.consignee_id', 'left');
            $this->db->order_by('other_item_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    
    public function getitembyid($itemid)
    {
        $query=$this->db->select('`other_item_id`, `other_item_name`, `consignee_id`, `opening_stock`,"transport" as item_type')
            ->from('tbl_other_item')
            ->where(array("other_item_id"=>$itemid))
            ->get();
        $record['other_item']=$query->result_array();
        
        return $record;
    }
    
    public function updateitem($post)
    {
        if(empty($_POST['other_item_name']))
            $other_item_name="";
        else
            $other_item_name=$_POST['other_item_name'];
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
        $data=array("other_item_name"=>$other_item_name,"consignee_id"=>$consignee_id,"opening_stock"=>$opening_stock,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
         $lastid=encryptor("decrypt",$post['other_item_id']);
        $this->db->where('other_item_id', encryptor("decrypt",$post['other_item_id']));

            $data=array("other_item_name"=>$other_item_name,"consignee_id"=>$consignee_id,"opening_stock"=>$opening_stock,"created_by"=>$user_id,"created_datetime"=>$datetime);
            $this->db->update('tbl_other_item',$data);
        return $lastid;
    }
    public function deletebyid($itemid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('other_item_id', $itemid);
        $this->db->update('item',$data);
        return $this->db->affected_rows();
    }
    public function getItemByConsignee($consigneeid,$stock_date)
    {
        $newDate = date("Y-m-d", strtotime($stock_date));
        $query=$this->db->select('`other_item_id`, `other_item_name`,qty')
            ->from('tbl_other_item')
            ->join('tbl_other_item_stock','tbl_other_item_stock.item_id=tbl_other_item.other_item_id','left')
            ->where(array("consignee_id"=>$consigneeid,'stock_date'=>$newDate))
            ->get();
            if($query->num_rows()>0)
            {
                return $query->result_array();
            }
            else
            {
                $query=$this->db->select('`other_item_id`, `other_item_name`,"0" as qty')
                ->from('tbl_other_item')
                ->where(array("consignee_id"=>$consigneeid))
                ->get();
                return $query->result_array();
            }
    }
    public function savestock()
    {
        if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];
        if(empty($_POST['stock_date']))
            $stock_date="";
        else
            $stock_date=date("Y-m-d", strtotime($_POST['stock_date']));
        $this->db->where(array('stock_date'=>$stock_date));
        $this->db->where_in('item_id',$_POST['item_id']);
        $this->db->delete('tbl_other_item_stock');

        for($i=0;$i<sizeof($_POST['item_id']);$i++)
        {
            $data= array('item_id' => $_POST['item_id'][$i],'qty' => $_POST['qty'][$i], 'stock_date' => $stock_date);
            $this->db->insert('tbl_other_item_stock',$data);
        }
        return 1;
    }

}
?>