<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_Consignee extends CI_Model{

    public function saveconsignee($post)
    {
        //`id`, `consignee_name`, `mobile`, `mobile2`, `phone`, `phone2`
        
        if(empty($_POST['consignee_name']))
            $consignee_name="";
        else
            $consignee_name=$_POST['consignee_name'];
        if(empty($_POST['party_name']))
            $party_name="";
        else
            $party_name=$_POST['party_name'];
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
        if(empty($_POST['place_id']))
            $place_id="";
        else
            $place_id=$_POST['place_id'];
        if(empty($_POST['gstin']))
            $gstin="";
        else
            $gstin=$_POST['gstin'];
         if(empty($_POST['billing_id']))
            $billing_id="";
        else
            $billing_id=$_POST['billing_id'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        $data=array("consignee_name"=>$consignee_name,"billing_id"=>$billing_id,"party_name"=>$party_name,"address"=>$address,"city"=>$city,"state"=>$state,"pincode"=>$pincode,"phone_no"=>$phone_no,"mobile_no"=>$mobile_no,"mobile_no1"=>$mobile_no1,"party_mobile_no"=>$party_mobile_no,"place_id"=>$place_id,"gstin"=>$gstin,"state_code"=>$state_code,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_consignee',$data);
        return $this->db->insert_id();

    }
    
    public function getconsignee($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        $arr=array("consignee_id","consignee_billing_name","consignee_name", "party_name", "address", "city", "state", "pincode", "phone_no", "mobile_no", "mobile_no1", "party_mobile_no","place_name", "gstin");
        if($start=='' && $length=='' && $searchstr=='')
        {

            $query=$this->db->select('`consignee_id`,billing_id, `consignee_name`, `party_name`, `address`, `city`, `state`, `pincode`, `phone_no`, `mobile_no`, `mobile_no1`, `party_mobile_no`, `place_id`, `gstin`')
                ->from('tbl_consignee')
                ->order_by('consignee_name','ASC')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('`consignee_id`,consignee_billing_name, `consignee_name`, `party_name`, `tbl_consignee.address`, `tbl_consignee.city`, `tbl_consignee.state`, `tbl_consignee.pincode`, `tbl_consignee.phone_no`, `tbl_consignee.mobile_no`, `tbl_consignee.mobile_no1`, `tbl_consignee.party_mobile_no`, tbl_consignee.place_id,place_name, `tbl_consignee.gstin`');
            if(!empty($searchstr))
            {
                $this->db->or_like('consignee_billing_name', $searchstr);
                $this->db->or_like('tbl_consignee.consignee_name', $searchstr);
                $this->db->or_like('tbl_consignee.party_name', $searchstr);
                $this->db->or_like('tbl_consignee.address', $searchstr);
                $this->db->or_like('tbl_consignee.city', $searchstr);
                $this->db->or_like('tbl_consignee.state', $searchstr);
                $this->db->or_like('tbl_consignee.pincode', $searchstr);
                $this->db->or_like('tbl_consignee.phone_no', $searchstr);
                $this->db->or_like('tbl_consignee.mobile_no', $searchstr);
                $this->db->or_like('tbl_consignee.mobile_no1', $searchstr);
                $this->db->or_like('tbl_consignee.party_mobile_no', $searchstr);
                $this->db->or_like('place.place_name', $searchstr);
                $this->db->or_like('tbl_consignee.gstin', $searchstr);
            }
            
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_consignee')->join('place', 'place.place_id = tbl_consignee.place_id', 'left')->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_consignee.billing_id', 'left')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_consignee');
            $this->db->join('place', 'place.place_id = tbl_consignee.place_id', 'left');
            $this->db->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_consignee.billing_id', 'left');
            $this->db->order_by('consignee_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            //echo $this->db->last_query();
            //exit;
            return $response;
        }
    }
    
    public function getconsigneebyid($consigneeid)
    {
        $query=$this->db->select('`consignee_id`,billing_id, `consignee_name`, `party_name`, `address`, `city`, `state`, `pincode`, `phone_no`, `mobile_no`, `mobile_no1`, `party_mobile_no`, `place_id`, `gstin`,state_code')
            ->from('tbl_consignee')
            ->where(array("consignee_id"=>$consigneeid))
            ->get();
        $record['consignee']=$query->result_array();
        return $record;
    }
    
    public function updateconsignee($post)
    {
        if(empty($_POST['consignee_name']))
            $consignee_name="";
        else
            $consignee_name=$_POST['consignee_name'];
        if(empty($_POST['party_name']))
            $party_name="";
        else
            $party_name=$_POST['party_name'];
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
        if(empty($_POST['place_id']))
            $place_id="";
        else
            $place_id=$_POST['place_id'];
        if(empty($_POST['gstin']))
            $gstin="";
        else
            $gstin=$_POST['gstin'];
        if(empty($_POST['billing_id']))
            $billing_id="";
        else
            $billing_id=$_POST['billing_id'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("consignee_name"=>$consignee_name,"billing_id"=>$billing_id,"party_name"=>$party_name,"address"=>$address,"city"=>$city,"state"=>$state,"pincode"=>$pincode,"phone_no"=>$phone_no,"mobile_no"=>$mobile_no,"mobile_no1"=>$mobile_no1,"party_mobile_no"=>$party_mobile_no,"place_id"=>$place_id,"gstin"=>$gstin,"state_code"=>$state_code,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['consignee_id']);
        $this->db->where('consignee_id', encryptor("decrypt",$post['consignee_id']));
        $this->db->update('tbl_consignee',$data);
    }
    
    public function deletebyid($consigneeid)
    {
        if($this->session->userdata('user_id')==1){
        $this->db->where('consignee_id', $consigneeid);
        $this->db->delete('tbl_consignee');
        //echo $this->db->last_query(); exit();
        return $this->db->affected_rows();
        }
    }
    
    public function getConsigneeByPlace($place_id)
    {

        $query=$this->db->select('`consignee_id`, `consignee_name`, `party_name`, `address`, `city`, `state`, `pincode`, `phone_no`, `mobile_no`, `mobile_no1`, `party_mobile_no`, `place_id`, `gstin`')
            ->from('tbl_consignee')
            ->where(array("place_id"=>$place_id))
            ->get();
            //echo $this->db->last_query(); exit();
            return $query->result_array();
    }

}
?>