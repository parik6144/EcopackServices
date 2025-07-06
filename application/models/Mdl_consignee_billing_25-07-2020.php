<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_consignee_billing extends CI_Model{

    public function saveconsignee_billing($post)
    {
        //`id`, `consignee_billing_name`, `mobile`, `mobile2`, `phone`, `phone2`
        
        if(empty($_POST['consignee_billing_name']))
            $consignee_billing_name="";
        else
            $consignee_billing_name=$_POST['consignee_billing_name'];
        if(empty($_POST['address']))
            $address="";
        else
            $address=$_POST['address'];
        if(empty($_POST['city']))
            $city="";
        else
            $city=$_POST['city'];
        if(empty($_POST['state']))
            $state="";
        else
            $state=$_POST['state'];

        if(empty($_POST['state_code']))
            $state_code="";
        else
            $state_code=$_POST['state_code'];

        if(empty($_POST['pincode']))
            $pincode="";
        else
            $pincode=$_POST['pincode'];
        if(empty($_POST['phone_no']))
            $phone_no="";
        else
            $phone_no=$_POST['phone_no'];
        if(empty($_POST['mobile_no']))
            $mobile_no="";
        else
            $mobile_no=$_POST['mobile_no'];
        if(empty($_POST['mobile_no1']))
            $mobile_no1="";
        else
            $mobile_no1=$_POST['mobile_no1'];
        if(empty($_POST['party_mobile_no']))
            $party_mobile_no="";
        else
            $party_mobile_no=$_POST['party_mobile_no'];
        
        if(empty($_POST['gstin']))
            $gstin="";
        else
            $gstin=$_POST['gstin'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        $data=array("consignee_billing_name"=>$consignee_billing_name,"address"=>$address,"city"=>$city,"state"=>$state,"state_code"=>$state_code,"pincode"=>$pincode,"phone_no"=>$phone_no,"mobile_no"=>$mobile_no,"mobile_no1"=>$mobile_no1,"party_mobile_no"=>$party_mobile_no,"gstin"=>$gstin,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_consignee_billing',$data);
        return $this->db->insert_id();

    }
    public function getconsignee_billing($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        $arr=array("consignee_billing_id","consignee_billing_name", "address", "city", "state", "pincode", "phone_no", "mobile_no", "mobile_no1", "party_mobile_no", "gstin");
        if($start=='' && $length=='' && $searchstr=='')
        {

            $query=$this->db->select('`consignee_billing_id`, `consignee_billing_name`, `address`, `city`, `state`, `pincode`, `phone_no`, `mobile_no`, `mobile_no1`, `party_mobile_no`, `gstin`')
                ->from('tbl_consignee_billing')
                ->order_by('consignee_billing_name','ASC')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('`consignee_billing_id`, `consignee_billing_name`, `address`, `city`, `state`, `pincode`, `phone_no`, `mobile_no`, `mobile_no1`, `party_mobile_no`, `gstin`');
            if(!empty($searchstr))
            {
                $this->db->or_like('consignee_billing_name', $searchstr);
                $this->db->or_like('address', $searchstr);
                $this->db->or_like('city', $searchstr);
                $this->db->or_like('state', $searchstr);
                $this->db->or_like('pincode', $searchstr);
                $this->db->or_like('phone_no', $searchstr);
                $this->db->or_like('mobile_no', $searchstr);
                $this->db->or_like('mobile_no1', $searchstr);
                $this->db->or_like('party_mobile_no', $searchstr);
                $this->db->or_like('gstin', $searchstr);
            }
            
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_consignee_billing')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_consignee_billing');
            $this->db->order_by('consignee_billing_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            //echo $this->db->last_query();
            //exit;
            return $response;
        }
    }
    public function getconsignee_billingbyid($consignee_billingid)
    {
        $query=$this->db->select('`consignee_billing_id`, `consignee_billing_name`, `address`, `city`, `state`,state_code, `pincode`, `phone_no`, `mobile_no`, `mobile_no1`, `party_mobile_no`, `gstin`')
            ->from('tbl_consignee_billing')
            ->where(array("consignee_billing_id"=>$consignee_billingid))
            ->get();
        $record['consignee_billing']=$query->result_array();

        return $record;
    }
    public function updateconsignee_billing($post)
    {
        if(empty($_POST['consignee_billing_name']))
            $consignee_billing_name="";
        else
            $consignee_billing_name=$_POST['consignee_billing_name'];
        
        if(empty($_POST['address']))
            $address="";
        else
            $address=$_POST['address'];
        if(empty($_POST['city']))
            $city="";
        else
            $city=$_POST['city'];
        if(empty($_POST['state']))
            $state="";
        else
            $state=$_POST['state'];
        if(empty($_POST['state_code']))
            $state_code="";
        else
            $state_code=$_POST['state_code'];
        if(empty($_POST['pincode']))
            $pincode="";
        else
            $pincode=$_POST['pincode'];
        if(empty($_POST['phone_no']))
            $phone_no="";
        else
            $phone_no=$_POST['phone_no'];
        if(empty($_POST['mobile_no']))
            $mobile_no="";
        else
            $mobile_no=$_POST['mobile_no'];
        if(empty($_POST['mobile_no1']))
            $mobile_no1="";
        else
            $mobile_no1=$_POST['mobile_no1'];
        if(empty($_POST['party_mobile_no']))
            $party_mobile_no="";
        else
            $party_mobile_no=$_POST['party_mobile_no'];
        if(empty($_POST['gstin']))
            $gstin="";
        else
            $gstin=$_POST['gstin'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("consignee_billing_name"=>$consignee_billing_name,"address"=>$address,"city"=>$city,"state"=>$state,"state_code"=>$state_code,"pincode"=>$pincode,"phone_no"=>$phone_no,"mobile_no"=>$mobile_no,"mobile_no1"=>$mobile_no1,"party_mobile_no"=>$party_mobile_no,"gstin"=>$gstin,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['consignee_billing_id']);
        $this->db->where('consignee_billing_id', encryptor("decrypt",$post['consignee_billing_id']));
        $this->db->update('tbl_consignee_billing',$data);
    }
    public function deletebyid($consignee_billingid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('consignee_billing_id', $consignee_billingid);
        $this->db->update('consignee_billing',$data);
        return $this->db->affected_rows();
    }
    public function getconsignee_billingByPlace($place_id)
    {

        $query=$this->db->select('`consignee_billing_id`, `consignee_billing_name`, `address`, `city`, `state`, `pincode`, `phone_no`, `mobile_no`, `mobile_no1`, `party_mobile_no`, `place_id`, `gstin`')
            ->from('tbl_consignee_billing')
            ->where(array("place_id"=>$place_id))
            ->get();
           
            return $query->result_array();
    }

}
?>