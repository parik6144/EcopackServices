<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_staff extends CI_Model{

    public function savestaff($post,$imagename)
    {
        //`id`, `uom_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['staff_name']))
            $staff_name="";
        else
            $staff_name=$_POST['staff_name'];
        if(empty($_POST['emp_no']))
            $emp_no="";
        else
            $emp_no=$_POST['emp_no'];
        if(empty($_POST['mobile_no']))
            $mobile_no="";
        else
            $mobile_no=$_POST['mobile_no'];
        if(empty($_POST['employee_type']))
            $employee_type="";
        else
            $employee_type=$_POST['employee_type'];
        if(empty($_POST['email_id']))
            $email_id="";
        else
            $email_id=$_POST['email_id'];
        if(empty($_POST['gstin']))
            $gstin="";
        else
            $gstin=$_POST['gstin'];
        if(empty($_POST['bank_name']))
            $bank_name="";
        else
            $bank_name=$_POST['bank_name'];
        if(empty($_POST['branch']))
            $branch="";
        else
            $branch=$_POST['branch'];
        if(empty($_POST['account_no']))
            $account_no="";
        else
            $account_no=$_POST['account_no'];
        if(empty($_POST['ifsc_code']))
            $ifsc_code="";
        else
            $ifsc_code=$_POST['ifsc_code'];

        if(empty($_POST['blood_group']))
            $blood_group="";
        else
            $blood_group=$_POST['blood_group'];

        
        //`emp_no`, `staff_name`, `mobile_no`, `employee_type_id`, `email_id`
        
        $data=array("emp_no"=>$emp_no,"staff_name"=>$staff_name,"mobile_no"=>$mobile_no,"employee_type_id"=>$employee_type,"email_id"=>$email_id,"gstin"=>$gstin,
            "bank_name"=>$bank_name,
            "branch"=>$branch,
            "account_no"=>$account_no,
            "photo"=>$imagename,
            "blood_group"=>$blood_group,
            "ifsc_code"=>$ifsc_code);
        
        $this->db->insert('staff',$data);
        return $this->db->insert_id();

    }
    public function getstaff($start="",$length="",$searchstr="",$column,$type)
    {
         $col = (int)$column;
         $arr=array("staff_id","photo","emp_no","staff_name","mobile_no","employee_type_id","email_id","blood_group", "gstin", "bank_name", "branch", "account_no", "ifsc_code");
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`staff_id`, `emp_no`,`staff_name`')
                ->from('staff')
                ->order_by('staff_name','ASC')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('`staff_id`, `emp_no`, type_name,`staff_name`, `mobile_no`, `email_id`, `gstin`, `bank_name`, `branch`, `account_no`, `ifsc_code`,photo,blood_group');
            if(!empty($searchstr))
            {
                $this->db->or_like('staff_id', $searchstr);
                $this->db->or_like('emp_no', $searchstr);
                $this->db->or_like('staff_name', $searchstr);
                $this->db->or_like('mobile_no', $searchstr);
                //$this->db->or_like('employee_type_id', $searchstr);
                $this->db->or_like('email_id', $searchstr);
                $this->db->or_like('gstin', $searchstr);
                $this->db->or_like('bank_name', $searchstr);
                $this->db->or_like('branch', $searchstr);
                $this->db->or_like('account_no', $searchstr);
                $this->db->or_like('ifsc_code', $searchstr);
                $this->db->or_like('blood_group', $searchstr);

            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('staff')->join('employee_type', 'employee_type.employee_type_id = staff.employee_type_id', 'left')->where('staff.is_deleted','0')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('staff');
            $this->db->join('employee_type', 'employee_type.employee_type_id = staff.employee_type_id', 'left');           
            $this->db->where('staff.is_deleted','0');
            $this->db->order_by('staff_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getstaffbyid($staff_id)
    {
        $query=$this->db->select('`staff_id`, `emp_no`, `staff_name`, `mobile_no`, `employee_type_id`, `email_id`, `gstin`, `bank_name`, `branch`, `account_no`, `ifsc_code`,photo,blood_group')
            ->from('staff')
            ->where(array("staff_id"=>$staff_id))
            ->get();
            //echo $this->db->last_query();
        $record['staff']=$query->result_array();
        //var_dump($record);
        return $record;
    }
    public function updatestaff($post,$photo="")
    {
         if(empty($_POST['staff_name']))
            $staff_name="";
        else
            $staff_name=$_POST['staff_name'];
        if(empty($_POST['emp_no']))
            $emp_no="";
        else
            $emp_no=$_POST['emp_no'];
        if(empty($_POST['mobile_no']))
            $mobile_no="";
        else
            $mobile_no=$_POST['mobile_no'];
        if(empty($_POST['employee_type']))
            $employee_type="";
        else
            $employee_type=$_POST['employee_type'];
        if(empty($_POST['email_id']))
            $email_id="";
        else
            $email_id=$_POST['email_id'];
        if(empty($_POST['password']))
            $password="";
        else
            $password=$_POST['password'];
        if(empty($_POST['gstin']))
            $gstin="";
        else
            $gstin=$_POST['gstin'];
        if(empty($_POST['bank_name']))
            $bank_name="";
        else
            $bank_name=$_POST['bank_name'];
        if(empty($_POST['branch']))
            $branch="";
        else
            $branch=$_POST['branch'];
        if(empty($_POST['account_no']))
            $account_no="";
        else
            $account_no=$_POST['account_no'];
        if(empty($_POST['ifsc_code']))
            $ifsc_code="";
        else
            $ifsc_code=$_POST['ifsc_code'];

        if(empty($_POST['blood_group']))
            $blood_group="";
        else
            $blood_group=$_POST['blood_group'];
        //`emp_no`, `staff_name`, `mobile_no`, `employee_type_id`, `email_id`
        if(empty($photo))
        {
            $data=array("emp_no"=>$emp_no,"staff_name"=>$staff_name,"mobile_no"=>$mobile_no,"employee_type_id"=>$employee_type,"email_id"=>$email_id,"gstin"=>$gstin,
            "bank_name"=>$bank_name,
            "branch"=>$branch,
            "account_no"=>$account_no,
            "ifsc_code"=>$ifsc_code,
            "blood_group"=>$blood_group);
        }
        else
        {
            $data=array("emp_no"=>$emp_no,"staff_name"=>$staff_name,"mobile_no"=>$mobile_no,"employee_type_id"=>$employee_type,"email_id"=>$email_id,"gstin"=>$gstin,
            "bank_name"=>$bank_name,
            "branch"=>$branch,
            "account_no"=>$account_no,
            "ifsc_code"=>$ifsc_code,
            "photo"=>$photo,
            "blood_group"=>$blood_group);
        }

        $lastid=encryptor("decrypt",$post['staff_id']);

        $this->db->where('staff_id', $lastid);
        $this->db->update('staff',$data);
       
    }
    public function deletebyid($uomid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('type_id', $uomid);
        $this->db->update('staff',$data);
        return $this->db->affected_rows();
    }
    
    public function getLastId()
    {
        $query=$this->db->select('`emp_no`')
            ->from('staff')
            ->order_by('staff_id',"desc")
            ->limit(1)
            ->get();
        $lastid=$query->row();
        $arr=explode("-",$lastid->emp_no);
        return $arr['1'];
    }

}
?>