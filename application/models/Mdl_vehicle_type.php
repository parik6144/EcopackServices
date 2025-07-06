<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_vehicle_type extends CI_Model{

    public function savevehicle_type($post)
    {
        //`id`, `vehicle_type_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['vehicle_type']))
            $vehicle_type="";
        else
            $vehicle_type=$_POST['vehicle_type'];
        
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("vehicle_type"=>$vehicle_type,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_vehicle_type',$data);
        return $this->db->insert_id();

    }
    public function getvehicle_type($start="",$length="",$searchstr="",$column,$type)
    {
         $col = (int)$column;
         $arr=array("vehicle_type_id","vehicle_type");
        if($start=='' && $length=='' && $searchstr=='')
        {
            
            $query=$this->db->select('vehicle_type_id,`vehicle_type`')
                ->from('tbl_vehicle_type')
                ->where(array("is_deleted"=>'0'))
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('vehicle_type_id,`vehicle_type`');
            if(!empty($searchstr))
            {
                $this->db->or_like('vehicle_type', $searchstr);

            }
             $this->db->where(array("is_deleted"=>'0'));
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_vehicle_type')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_vehicle_type');
            $this->db->order_by('vehicle_type_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getvehicle_typebyid($vehicle_typeid)
    {
        $query=$this->db->select('`vehicle_type`,vehicle_type_id')
            ->from('tbl_vehicle_type')
            ->where(array("vehicle_type_id"=>$vehicle_typeid))
            ->get();
        $record['vehicle_type']=$query->result_array();

        return $record;
    }
    public function updatevehicle_type($post)
    {
        if(!empty($post['vehicle_type']))
            $vehicle_type=$post['vehicle_type'];
        else
            $vehicle_type='';
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("vehicle_type"=>$vehicle_type,
            "updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['vehicle_type_id']);
        $this->db->where('vehicle_type_id', encryptor("decrypt",$post['vehicle_type_id']));
        $this->db->update('tbl_vehicle_type',$data);
    }
    public function deletebyid($vehicle_typeid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('vehicle_type_id', $vehicle_typeid);
        $this->db->update('tbl_vehicle_type',$data);
        return $this->db->affected_rows();
    }

}
?>