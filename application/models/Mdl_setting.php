<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_setting extends CI_Model{


    public function getstaffrecords()
    {
        $query=$this->db->select('`user_id`, `full_name`, `user_name`')->from('tbl_user')->where('is_blocked', 0)->get();
        $record=$query->result();
        //var_dump($record);
        return $record;
    }

    public function getcatrecords()
    {
        $query=$this->db->select('`mcat_id`, `mcat_name`')->from('tbl_module_cat')->get();
        $record=$query->result();
        //var_dump($record);
        return $record;
    }
    public function getmodulerecord()
    {
        $this->db->select('*');
        $this->db->from('tbl_access_module');
        $result=$this->db->get();
        return $result->result();
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

    public function check_access_availability($emp_id,$mcat_id,$msubcat_id)
    {
        $query = $this->db->select('*')
            ->where('mcat_id',$mcat_id)
            ->where('msubcat_id',$msubcat_id)
            ->where('emp_id',$emp_id)
            ->get('tbl_access_module');
        // $result = $query->row();
        // echo count($query);
        // echo "<pre>";
        // exit();
        return count($query->result());
         //echo "<pre>";
    }

    public function insert_access ($emp_id,$mcat_id,$msubcat_id,$is_view,$is_add,$is_delete)
    {
        $data=array(
            "emp_id"=>$emp_id,
            "mcat_id"=>$mcat_id,
            "msubcat_id"=>$msubcat_id,
            "is_view"=>$is_view,
            "is_edit"=>$is_add,
            "is_delete"=>$is_delete
        );
        $this->db->insert('tbl_access_module',$data);
        // echo $this->db->last_query();
        // echo "<pre>";
        // exit();
        return $this->db->affected_rows();
    }

    public function update_access ($emp_id,$mcat_id,$msubcat_id,$is_view,$is_add,$is_delete)
    {
        $data=array(
            "is_view"=>$is_view,
            "is_edit"=>$is_add,
            "is_delete"=>$is_delete
        );
        $this->db->where('emp_id',$emp_id);
        $this->db->where('mcat_id',$mcat_id);
        $this->db->where('msubcat_id',$msubcat_id);
        $this->db->update('tbl_access_module',$data);
       // echo $this->db->last_query();
        // echo "<pre>";
        //exit();
        return $this->db->affected_rows();
    }

    public function is_access($user_id=null,$mcat_id=null,$msubcat_id=null,$access_type=null)
    {
        $this->db->select($access_type);
        $this->db->from('tbl_access_module');
        $this->db->where('emp_id', $user_id);
        $this->db->where('mcat_id', $mcat_id);
        $this->db->where('msubcat_id', $msubcat_id);
        $this->db->where($access_type, 1);
        $result=$this->db->get();
        //echo $this->db->last_query(); 
        $result=$result->row();
        if(empty($result))
            return FALSE;
        else
        return TRUE;
        // 

    }
}
?>