<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_account extends CI_Model{

    public function saveaccount ($post)
    {
        
        if(empty($_POST['party_name']))
            $party_name="";
        else
            $party_name=$_POST['party_name'];
        if(empty($_POST['mobile_no']))
            $mobile_no="";
        else
            $mobile_no=$_POST['mobile_no'];
        // if(empty($_POST['mobile_no1']))
        //     $mobile_no1="";
        // else
        //     $mobile_no1=$_POST['mobile_no1'];
        // if(empty($_POST['address']))
        //     $address="";
        // else
        //     $address=$_POST['address'];
        
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
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

         //`party_name`, `mobile_no`, `mobile_no1`, `address`, `city`, `pincode`, `bank_name`, `branch`, `account_no`, `ifsc_code`
        $data=array("party_name"=>$party_name,
            "mobile_no"=>$mobile_no,
            "gstin"=>$gstin,
            "bank_name"=>$bank_name,
            "branch"=>$branch,
            "account_no"=>$account_no,
            "ifsc_code"=>$ifsc_code,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_account',$data);
        $lastid=$this->db->insert_id();        
        return $lastid;


    }
    public function getaccount($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`account_id`, `party_name`')
                ->from('tbl_account')
                ->where('is_deleted','0')
                ->order_by('party_name','ASC')
                ->get();
            return $query->result_array();
        }
        else
        {

            $arr=array("account_id", "party_name", "mobile_no", "gstin", "bank_name", "branch", "account_no", "ifsc_code");

            $this->db->select('`account_id`, `party_name`, `mobile_no`,  `gstin`, `bank_name`, `branch`, `account_no`, `ifsc_code`');
            if(!empty($searchstr))
            {
                $this->db->or_like('party_name', $searchstr);
                $this->db->or_like('mobile_no', $searchstr);
                $this->db->or_like('gstin', $searchstr);
                $this->db->or_like('bank_name', $searchstr);
                $this->db->or_like('branch', $searchstr);
                $this->db->or_like('account_no', $searchstr);
                $this->db->or_like('ifsc_code', $searchstr);
            }
             $this->db->where('is_deleted','0');
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_account')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_account');
            $this->db->order_by('account_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getaccountbyid($ownerid)
    {
        $query=$this->db->select('`account_id`, `party_name`, `mobile_no`, `gstin`, `bank_name`, `branch`, `account_no`, `ifsc_code`')
            ->from('tbl_account')
            ->where(array("account_id"=>$ownerid))
            ->get();
        $record['account']=$query->result_array();
        return $record;
    }
    public function updateaccount($post)
    {
        if(empty($_POST['party_name']))
            $party_name="";
        else
            $party_name=$_POST['party_name'];
        if(empty($_POST['mobile_no']))
            $mobile_no="";
        else
            $mobile_no=$_POST['mobile_no'];
        // if(empty($_POST['mobile_no1']))
        //     $mobile_no1="";
        // else
        //     $mobile_no1=$_POST['mobile_no1'];
        // if(empty($_POST['address']))
        //     $address="";
        // else
        //     $address=$_POST['address'];
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
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

         //`party_name`, `mobile_no`, `mobile_no1`, `address`, `city`, `pincode`, `bank_name`, `branch`, `account_no`, `ifsc_code`
        $data=array("party_name"=>$party_name,
            "mobile_no"=>$mobile_no,
            "gstin"=>$gstin,
            "bank_name"=>$bank_name,
            "branch"=>$branch,
            "account_no"=>$account_no,
            "ifsc_code"=>$ifsc_code,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['account_id']);
        $this->db->where('account_id', encryptor("decrypt",$post['account_id']));
        $this->db->update('tbl_account',$data);
        return $lastid;
    }
    public function deletebyid($ownerid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('account_id', $ownerid);
        $this->db->update('tbl_account',$data);
        return $this->db->affected_rows();
    }

}
?>