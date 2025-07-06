<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_Owner extends CI_Model{

    public function saveowner ($post)
    {
        
        if(empty($_POST['owner_name']))
            $owner_name="";
        else
            $owner_name=$_POST['owner_name'];
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
        if(empty($_POST['city']))
            $city="";
        else
            $city=$_POST['city'];
        if(empty($_POST['pincode']))
            $pincode="";
        else
            $pincode=$_POST['pincode'];
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

         //`owner_name`, `mobile_no`, `mobile_no1`, `address`, `city`, `pincode`, `bank_name`, `branch`, `account_no`, `ifsc_code`
        $data=array("owner_name"=>$owner_name,
            "mobile_no"=>$mobile_no,
            "pincode"=>$pincode,
            "gstin"=>$gstin,
            "city"=>$city,
            "bank_name"=>$bank_name,
            "branch"=>$branch,
            "account_no"=>$account_no,
            "ifsc_code"=>$ifsc_code,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_owner',$data);
        $lastid=$this->db->insert_id();        
        return $lastid;


    }
    public function getowner($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`owner_id`, `owner_name`, `mobile_no`,city, `pincode`, `gstin`, `bank_name`, `branch`, `account_no`, `ifsc_code`')
                ->from('tbl_owner')
                ->where('is_deleted','0')
                ->get();
            return $query->result_array();
        }
        else
        {

            $arr=array("owner_id", "owner_name", "mobile_no", "pincode", "gstin", "bank_name", "branch", "account_no", "ifsc_code");

            $this->db->select('`owner_id`, `owner_name`, `mobile_no`, `city`, `pincode`, `gstin`, `bank_name`, `branch`, `account_no`, `ifsc_code`');
            if(!empty($searchstr))
            {
                $this->db->or_like('owner_name', $searchstr);
                $this->db->or_like('mobile_no', $searchstr);
                $this->db->or_like('city', $searchstr);
                $this->db->or_like('pincode', $searchstr);
                $this->db->or_like('gstin', $searchstr);
                $this->db->or_like('bank_name', $searchstr);
                $this->db->or_like('branch', $searchstr);
                $this->db->or_like('account_no', $searchstr);
                $this->db->or_like('ifsc_code', $searchstr);
            }
             $this->db->where('is_deleted','0');
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_owner')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_owner');
            $this->db->order_by('owner_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getownerbyid($ownerid)
    {
        $query=$this->db->select('`owner_id`, `owner_name`, `mobile_no`, `city`, `pincode`, `gstin`, `bank_name`, `branch`, `account_no`, `ifsc_code`')
            ->from('tbl_owner')
            ->where(array("owner_id"=>$ownerid))
            ->get();
        $record['owner']=$query->result_array();
        return $record;
    }
    public function updateowner($post)
    {
        if(empty($_POST['owner_name']))
            $owner_name="";
        else
            $owner_name=$_POST['owner_name'];
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
        if(empty($_POST['city']))
            $city="";
        else
            $city=$_POST['city'];
        if(empty($_POST['pincode']))
            $pincode="";
        else
            $pincode=$_POST['pincode'];
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

         //`owner_name`, `mobile_no`, `mobile_no1`, `address`, `city`, `pincode`, `bank_name`, `branch`, `account_no`, `ifsc_code`
        $data=array("owner_name"=>$owner_name,
            "mobile_no"=>$mobile_no,
            "city"=>$city,
            "pincode"=>$pincode,
            "gstin"=>$gstin,
            "bank_name"=>$bank_name,
            "branch"=>$branch,
            "account_no"=>$account_no,
            "ifsc_code"=>$ifsc_code,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['owner_id']);
        $this->db->where('owner_id', encryptor("decrypt",$post['owner_id']));
        $this->db->update('tbl_owner',$data);
        return $lastid;
    }
    public function deletebyid($ownerid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('owner_id', $ownerid);
        $this->db->update('tbl_owner',$data);
        return $this->db->affected_rows();
    }

}
?>