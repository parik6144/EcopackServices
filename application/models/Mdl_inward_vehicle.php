<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_Vehicle extends CI_Model{

    public function savevehicle($post)
    {
        //`id`, `vehicle_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['vehicle_no']))
            $vehicle_no="";
        else
            $vehicle_no=$_POST['vehicle_no'];
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
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        $data=array("vehicle_no"=>$vehicle_no,"driver_name"=>$driver_name,"mobile_no"=>$mobile_no,"license_no"=>$mobile_no,"owner_id"=>$owner_id,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_vehicle',$data);
        return $this->db->insert_id();

    }
    public function getvehicle($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        $arr=array("vehicle_id","vehicle_name");
        if($start=='' && $length=='' && $searchstr=='')
        {

            $query=$this->db->select('vehicle_id,`vehicle_name`')
                ->from('tbl_vehicle')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('vehicle_id,vehicle_no,driver_name, tbl_vehicle.mobile_no,license_no,owner_name');
            if(!empty($searchstr))
            {
                $this->db->or_like('vehicle_no', $searchstr);
                $this->db->or_like('driver_name', $searchstr);
                $this->db->or_like('tbl_vehicle.mobile_no', $searchstr);
                $this->db->or_like('license_no', $searchstr);
                $this->db->or_like('owner_name', $searchstr);

            }
             $this->db->where(array("tbl_vehicle.is_deleted"=>'0'));
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_vehicle')->join('tbl_owner', 'tbl_owner.owner_id = tbl_vehicle.owner_id', 'left')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_vehicle');
            $this->db->join('tbl_owner', 'tbl_owner.owner_id = tbl_vehicle.owner_id', 'left');
            $this->db->order_by('vehicle_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getvehiclebyid($vehicleid)
    {
        $query=$this->db->select('vehicle_id,vehicle_no,driver_name, tbl_vehicle.mobile_no,license_no,owner_id')
            ->from('tbl_vehicle')
            ->where(array("vehicle_id"=>$vehicleid))
            ->get();
        $record['vehicle']=$query->result_array();

        return $record;
    }
    public function updatevehicle($post)
    {
       if(empty($_POST['vehicle_no']))
            $vehicle_no="";
        else
            $vehicle_no=$_POST['vehicle_no'];
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
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("vehicle_no"=>$vehicle_no,"driver_name"=>$driver_name,"mobile_no"=>$mobile_no,"license_no"=>$mobile_no,"owner_id"=>$owner_id,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['vehicle_id']);
        $this->db->where('vehicle_id', encryptor("decrypt",$post['vehicle_id']));
        $this->db->update('tbl_vehicle',$data);
    }
    public function deletebyid($vehicleid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('vehicle_id', $vehicleid);
        $this->db->update('vehicle',$data);
        return $this->db->affected_rows();
    }
    public function validation($vehicle_no)
    {
        $this->db->select('vehicle_no')
        ->where(array('vehicle_no' =>$vehicle_no));
        $num = $this->db->count_all_results('tbl_vehicle');
        return $num;
    }

}
?>