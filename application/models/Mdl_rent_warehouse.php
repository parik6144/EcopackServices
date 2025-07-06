<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_rent_warehouse extends CI_Model{

    public function saverentwarehouse ($post)
    {
        //`id`, `uom_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['rent_warehouse_area']))
            $rent_warehouse_area="";
        else
            $rent_warehouse_area=$_POST['rent_warehouse_area'];
        if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];
        if(empty($_POST['price']))
            $price="";
        else
            $price=$_POST['price'];

        
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("rent_warehouse_area"=>$rent_warehouse_area,"consignee_id"=>$consignee_id,"price"=>$price,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_rent_warehouse',$data);
         $lastid=$this->db->insert_id();
        return $lastid;
        

    }
    public function getrentwarehouse($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`rent_warehouse_id`, `rent_warehouse_area`, `consignee_id`, `price`')
                ->from('tbl_rent_warehouse')
                ->get();
            return $query->result_array();
        }
        else
        {

             $arr=array("rent_warehouse_id", "rent_warehouse_area","consignee_name","price");
            $this->db->select('`rent_warehouse_id`, `rent_warehouse_area`,consignee_name,price');
            if(!empty($searchstr))
            {
                $this->db->or_like('rent_warehouse_area', $searchstr);
                $this->db->or_like('consignee_name', $searchstr);
                $this->db->or_like('price', $searchstr);
                
            }
             $this->db->where('tbl_rent_warehouse.is_deleted','0');
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_rent_warehouse')->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_rent_warehouse.consignee_id', 'left')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_rent_warehouse');
            $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_rent_warehouse.consignee_id', 'left');
            $this->db->order_by('rent_warehouse_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getrentwarehousebyid($rent_warehouseid)
    {
        $query=$this->db->select('`rent_warehouse_id`, `rent_warehouse_area`, `consignee_id`, `price`')
            ->from('tbl_rent_warehouse')
            ->where(array("rent_warehouse_id"=>$rent_warehouseid))
            ->get();
        $record['rent_warehouse']=$query->result_array();
        return $record;
    }
    public function getrentwarehousebyconsigneeid($consignee_id)
    {
        $query=$this->db->select('`rent_warehouse_id`, `rent_warehouse_area`, `consignee_name`, `price`')
            ->from('tbl_rent_warehouse')
            ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_rent_warehouse.consignee_id', 'left')
            ->where(array("tbl_rent_warehouse.consignee_id"=>$consignee_id))
            ->get();
        $record=$query->row();
        return $record;
    }
    public function updaterentwarehouse($post)
    {
        if(empty($_POST['rent_warehouse_area']))
            $rent_warehouse_area="";
        else
            $rent_warehouse_area=$_POST['rent_warehouse_area'];
        if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];
        if(empty($_POST['price']))
            $price="";
        else
            $price=$_POST['price'];
       
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("rent_warehouse_area"=>$rent_warehouse_area,"consignee_id"=>$consignee_id,"price"=>$price,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
         $lastid=encryptor("decrypt",$post['rent_warehouse_id']);
        $this->db->where('rent_warehouse_id', encryptor("decrypt",$post['rent_warehouse_id']));
        $this->db->update('tbl_rent_warehouse',$data);
        return $lastid;
    }
    public function deletebyid($rent_warehouseid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('rent_warehouse_id', $rent_warehouseid);
        $this->db->update('rent_warehouse',$data);
        return $this->db->affected_rows();
    }
    public function getrentwarehouseByConsignee($consigneeid)
    {
        $query=$this->db->select('`rent_warehouse_id`, `rent_warehouse_area`')
            ->from('tbl_rent_warehouse')
            ->where(array("consignee_id"=>$consigneeid))
            ->get();
            return $query->result_array();
    }

}
?>