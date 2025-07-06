<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_inward_employee extends CI_Model{

    public function saveinward_employee ($post)
    {
        
        if(empty($_POST['employee_name']))
            $employee_name="";
        else
            $employee_name=$_POST['employee_name'];
        if(empty($_POST['consignor_id']))
            $consignor_id="";
        else
            $consignor_id=$_POST['consignor_id'];

        if(empty($_POST['per_consignment']))
            $per_consignment="";
        else
            $per_consignment=$_POST['per_consignment'];
        if(empty($_POST['per_month']))
            $per_month="";
        else
            $per_month=$_POST['per_month'];
        
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

         //`employee_name`, `mobile_no`, `mobile_no1`, `address`, `city`, `pincode`, `bank_name`, `branch`, `account_no`, `ifsc_code`
        $data=array("employee_name"=>$employee_name,
            "consignor_id"=>$consignor_id,
            "per_consignment"=>$per_consignment,
            "per_month"=>$per_month,
            "created_by"=>$user_id,
            "created_datetime"=>$datetime);
        $this->db->insert('tbl_inward_employee',$data);
        $lastid=$this->db->insert_id();        
        return $lastid;


    }
    public function getinward_employee($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`employee_id`, `employee_name`, `consignor_name`, `per_consignment`, `per_month`')
                ->from('tbl_inward_employee')
                ->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_inward_employee.consignor_id', 'left')
                ->where('is_deleted','0')
                ->get();
            return $query->result_array();
        }
        else
        {

            $arr=array("employee_id", "employee_name", "consignor_name", "per_consignment", "per_month");

            $this->db->select('`employee_id`, `employee_name`, `consignor_name`, `per_consignment`, `per_month`');
            if(!empty($searchstr))
            {
                $this->db->or_like('employee_name', $searchstr);
                $this->db->or_like('consignor_name', $searchstr);
                $this->db->or_like('per_consignment', $searchstr);
                $this->db->or_like('per_month', $searchstr);
                
            }
             $this->db->where('is_deleted','0');
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_inward_employee')->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_inward_employee.consignor_id', 'left')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_inward_employee');
            $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_inward_employee.consignor_id', 'left');
            $this->db->order_by('employee_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getinward_employeebyid($employeeid)
    {
        $query=$this->db->select('`employee_id`, `employee_name`, `consignor_id`, `per_consignment`, `per_month`')
            ->from('tbl_inward_employee')
            ->where(array("employee_id"=>$employeeid))
            ->get();
        $record['employee']=$query->result_array();
        return $record;
    }
    public function updateinward_employee($post)
    {
        if(empty($_POST['employee_name']))
            $employee_name="";
        else
            $employee_name=$_POST['employee_name'];
        if(empty($_POST['consignor_id']))
            $consignor_id="";
        else
            $consignor_id=$_POST['consignor_id'];

        if(empty($_POST['per_consignment']))
            $per_consignment="";
        else
            $per_consignment=$_POST['per_consignment'];
        if(empty($_POST['per_month']))
            $per_month="";
        else
            $per_month=$_POST['per_month'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

         //`employee_name`, `mobile_no`, `mobile_no1`, `address`, `city`, `pincode`, `bank_name`, `branch`, `account_no`, `ifsc_code`
       $data=array("employee_name"=>$employee_name,
            "consignor_id"=>$consignor_id,
            "per_consignment"=>$per_consignment,
            "per_month"=>$per_month,
            "updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['employee_id']);
        $this->db->where('employee_id', encryptor("decrypt",$post['employee_id']));
        $this->db->update('tbl_inward_employee',$data);
        return $lastid;
    }
    public function deletebyid($employeeid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('employee_id', $employeeid);
        $this->db->update('tbl_inward_employee',$data);
        return $this->db->affected_rows();
    }
    public function getEmployeeByConsignor($consignor_id)
    {
        $query=$this->db->select('`employee_id`, `employee_name`, `consignor_id`, `per_consignment`, `per_month`')
            ->from('tbl_inward_employee')
            ->where(array("consignor_id"=>$consignor_id))
            ->get();
        return $query->result_array();
    }
}
?>