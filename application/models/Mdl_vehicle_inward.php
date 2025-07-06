<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_vehicle_inward extends CI_Model{

    public function savevehicle_inward($post)
    {
        //`id`, `vehicle_inward_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['vehicle_inward_no']))
            $vehicle_inward_no="";
        else
            $vehicle_inward_no=$_POST['vehicle_inward_no'];
        if(empty($_POST['driver_name']))
            $driver_name="";
        else
            $driver_name=$_POST['driver_name'];
        if(empty($_POST['mobile_no']))
            $mobile_no="";
        else
            $mobile_no=$_POST['mobile_no'];
        if(empty($_POST['license_no']))
            $license_no="";
        else
            $license_no=$_POST['license_no'];
        if(empty($_POST['owner_id']))
            $owner_id="";
        else
            $owner_id=$_POST['owner_id'];


        if(empty($_POST['vehicle_type']))
            $vehicle_type="";
        else
            $vehicle_type=$_POST['vehicle_type'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        $data=array("vehicle_inward_no"=>$vehicle_inward_no,"driver_name"=>$driver_name,"mobile_no"=>$mobile_no,"license_no"=>$mobile_no,"owner_id"=>$owner_id,"vehicle_type_id"=>$vehicle_type,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_vehicle_inward',$data);
        return $this->db->insert_id();

    }
    public function getvehicle_inward($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        $arr=array("vehicle_inward_id", "vehicle_inward_no", "driver_name", "mobile_no", "owner_name","vehicle_type");
        if($start=='' && $length=='' && $searchstr=='')
        {

            $query=$this->db->select('`vehicle_inward_id`, `vehicle_inward_no`, `driver_name`, `mobile_no`, `license_no`, `owner_id`, `vehicle_type_id`')
                ->from('tbl_vehicle_inward')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('vehicle_inward_id,vehicle_inward_no,driver_name, tbl_vehicle_inward.mobile_no,license_no,owner_name,vehicle_type');
            if(!empty($searchstr))
            {
                $this->db->or_like('vehicle_inward_no', $searchstr);
                $this->db->or_like('driver_name', $searchstr);
                $this->db->or_like('tbl_vehicle_inward.mobile_no', $searchstr);
                $this->db->or_like('license_no', $searchstr);
                $this->db->or_like('owner_name', $searchstr);
                $this->db->or_like('vehicle_type', $searchstr);

            }
             $this->db->where(array("tbl_vehicle_inward.is_deleted"=>'0'));
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_vehicle_inward')->join('tbl_inward_owner', 'tbl_inward_owner.owner_id = tbl_vehicle_inward.owner_id', 'left')
            ->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id = tbl_vehicle_inward.vehicle_type_id', 'left')
            ->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_vehicle_inward');
            $this->db->join('tbl_inward_owner', 'tbl_inward_owner.owner_id = tbl_vehicle_inward.owner_id', 'left');
            $this->db->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id = tbl_vehicle_inward.vehicle_type_id', 'left');
            $this->db->order_by('vehicle_inward_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getvehicle_inwardbyid($vehicle_inwardid)
    {
        $query=$this->db->select('vehicle_inward_id,vehicle_inward_no,driver_name, tbl_vehicle_inward.mobile_no,license_no,tbl_inward_owner.owner_id,vehicle_type_id,owner_name')
            ->from('tbl_vehicle_inward')
            ->join('tbl_inward_owner', 'tbl_inward_owner.owner_id = tbl_vehicle_inward.owner_id', 'left')
            ->where(array("vehicle_inward_id"=>$vehicle_inwardid))
            ->get();
        $record['vehicle_inward']=$query->result_array();

        return $record;
    }
    public function updatevehicle_inward($post)
    {
       if(empty($_POST['vehicle_inward_no']))
            $vehicle_inward_no="";
        else
            $vehicle_inward_no=$_POST['vehicle_inward_no'];
        if(empty($_POST['driver_name']))
            $driver_name="";
        else
            $driver_name=$_POST['driver_name'];
        if(empty($_POST['mobile_no']))
            $mobile_no="";
        else
            $mobile_no=$_POST['mobile_no'];
        if(empty($_POST['license_no']))
            $license_no="";
        else
            $license_no=$_POST['license_no'];
        if(empty($_POST['owner_id']))
            $owner_id="";
        else
            $owner_id=$_POST['owner_id'];
        if(empty($_POST['vehicle_type']))
            $vehicle_type="";
        else
            $vehicle_type=$_POST['vehicle_type'];
        $user_id=$this->session->userdata('user_id');

        $datetime=date('Y-m-d h:i:s');
        $data=array("vehicle_inward_no"=>$vehicle_inward_no,"driver_name"=>$driver_name,"mobile_no"=>$mobile_no,"license_no"=>$mobile_no,"owner_id"=>$owner_id,"vehicle_type_id"=>$vehicle_type,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['vehicle_inward_id']);
        $this->db->where('vehicle_inward_id', encryptor("decrypt",$post['vehicle_inward_id']));
        $this->db->update('tbl_vehicle_inward',$data);
    }
    public function deletebyid($vehicle_inwardid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('vehicle_inward_id', $vehicle_inwardid);
        //$this->db->update('tbl_vehicle_inward',$data);
        $this->db->delete('tbl_vehicle_inward');
        return $this->db->affected_rows();
    }
    public function validation($vehicle_inward_no)
    {
        $this->db->select('vehicle_inward_no')
        ->where(array('vehicle_inward_no' =>$vehicle_inward_no));
        $num = $this->db->count_all_results('tbl_vehicle_inward');
        return $num;
    }
    public function getvehicledetails($vehicleid)
    {
        $query=$this->db->select('vehicle_inward_id,tbl_vehicle_inward.owner_id,vehicle_inward_no,driver_name, tbl_vehicle_inward.mobile_no,license_no,owner_name,vehicle_type,tbl_vehicle_inward.vehicle_type_id')
            ->where(array("vehicle_inward_id"=>$vehicleid))
            ->from('tbl_vehicle_inward')
            ->join('tbl_inward_owner', 'tbl_inward_owner.owner_id = tbl_vehicle_inward.owner_id', 'left')
            ->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id = tbl_vehicle_inward.vehicle_type_id', 'left')
            ->order_by('vehicle_inward_id','desc')
            ->get();
        return $query->result_array();
    }
    public function getVehicleByOwner()
    {
        $owner_id=$_POST['owner_id'];

        $query=$this->db->select('vehicle_inward_id,vehicle_inward_no')
            ->from('tbl_vehicle_inward')
            ->where(array("owner_id"=>$owner_id))
            ->get();
        $record=$query->result_array();
        return $record;
    }

}
?>