<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_transportvehicle_item extends CI_Model {

    public function saverentitem ($post)
    {
        //`id`, `uom_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['rent_item_name']))
            $rent_item_name="";
        else
            $rent_item_name=$_POST['rent_item_name'];
        if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];
        if(empty($_POST['price']))
            $price="";
        else
            $price=$_POST['price'];

        if(empty($_POST['due_price'])) $due_price=""; else $due_price=$_POST['due_price'];
        if(empty($_POST['rent_type'])) $rent_type=""; else $rent_type=$_POST['rent_type'];
        if(empty($_POST['opening_stock'])) $opening_stock=""; else $opening_stock=$_POST['opening_stock'];

        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("rent_item_name"=>$rent_item_name,"consignee_id"=>$consignee_id,"adv_price"=>$price,"due_price"=>$due_price,"rent_type"=>$rent_type,"opening_stock"=>$opening_stock,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_vehicle_transport_item',$data);
         $lastid=$this->db->insert_id();
        return $lastid;
    }

    public function getrentitem($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`rent_item_id`, `rent_item_name`, `consignee_id`, `adv_price`, `due_price`,rent_type,opening_stock')
                ->from('tbl_vehicle_transport_item')
                ->get();
            return $query->result_array();
        }
        else
        {
            $arr=array("rent_item_id", "rent_item_name","consignee_name","adv_price","due_price","rent_type","opening_stock");
            $this->db->select('`rent_item_id`, `rent_item_name`,`consignee_name`,`adv_price`,`due_price`,`rent_type`,`opening_stock`');
            if(!empty($searchstr))
            {
                $this->db->or_like('rent_item_name', $searchstr);
                $this->db->or_like('consignee_name', $searchstr);
                $this->db->or_like('adv_price', $searchstr);
                $this->db->or_like('due_price', $searchstr);
                $this->db->or_like('rent_type', $searchstr);
                $this->db->or_like('opening_stock', $searchstr);
            }

            $this->db->where('tbl_vehicle_transport_item.is_deleted','0');
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_vehicle_transport_item')->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_vehicle_transport_item.consignee_id', 'left')->count_all_results();
            if($length>0) $this->db->limit($length, $start);
            $this->db->from('tbl_vehicle_transport_item');
            $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_vehicle_transport_item.consignee_id', 'left');
            $this->db->order_by('rent_item_id','desc');
            $query=$this->db->get();
            //echo $this->db->last_query();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }

    public function getrentitembyid($rent_itemid)
    {
        $query=$this->db->select('`rent_item_id`, `rent_item_name`, `consignee_id`, `adv_price`, `due_price`,rent_type,opening_stock')
            ->from('tbl_vehicle_transport_item')
            ->where(array("rent_item_id"=>$rent_itemid))
            ->get();
        $record['rent_item']=$query->result_array();
        return $record;
    }

    public function get_transport_vehicle_item()
    {
        $query=$this->db->select('`rent_item_id`, `rent_item_name`, `consignee_id`, `adv_price`, `due_price`,rent_type,opening_stock')
            ->from('tbl_vehicle_transport_item')
            ->get();
        $record['transport_vehicle_item'] = $query->result_array();
        return $record['transport_vehicle_item'];
    }

    public function get_trans_vehicle_price_by_item($itemid)
    {
        $query=$this->db->select('`rent_item_id`, `rent_item_name`, `adv_price`, `due_price`')
            ->from('tbl_vehicle_transport_item')
            ->where("rent_item_id",$itemid)
            ->get();
        // echo $this->db->last_query();
        return $query->row();
    }

    public function updaterentitem($post)
    {
        //echo "<pre>";
        //print_r($post); exit;
        if(empty($_POST['rent_item_name'])) $rent_item_name=""; else $rent_item_name=$_POST['rent_item_name'];
        if(empty($_POST['consignee_id'])) $consignee_id=""; else $consignee_id=$_POST['consignee_id'];
        if(empty($_POST['price'])) $price=""; else $price=$_POST['price'];
        if(empty($_POST['due_price'])) $due_price=""; else $due_price=$_POST['due_price'];
        if(empty($_POST['rent_type'])) $rent_type=""; else $rent_type=$_POST['rent_type'];
        if(empty($_POST['opening_stock'])) $opening_stock=""; else $opening_stock=$_POST['opening_stock'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("rent_item_name"=>$rent_item_name,"consignee_id"=>$consignee_id,"adv_price"=>$price,"due_price"=>$due_price,"rent_type"=>$rent_type,"opening_stock"=>$opening_stock,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
         $lastid=encryptor("decrypt",$post['rent_item_id']);
        $this->db->where('rent_item_id', encryptor("decrypt",$post['rent_item_id']));
        $this->db->update('tbl_vehicle_transport_item',$data);
        return $lastid;
    }

    public function deletebyid($rent_itemid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('rent_item_id', $rent_itemid);
        $this->db->update('tbl_vehicle_transport_item',$data);
        return $this->db->affected_rows();
    }
    public function getrentitemByConsignee($consigneeid)
    {
        $query=$this->db->select('rent_item_id as item_id, rent_item_name as item_name,rent_type')
            ->from('tbl_vehicle_transport_item')
            ->where(array("consignee_id"=>$consigneeid))
            ->get();
            return $query->result_array();
    }

}
?>