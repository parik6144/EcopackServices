<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_consignor extends CI_Model{

    public function saveconsignor($post)
    {
        //`id`, `consignor_name`, `mobile`, `mobile2`, `phone`, `phone2`
        
        if(empty($_POST['consignor_name']))
            $consignor_name="";
        else
            $consignor_name=$_POST['consignor_name'];
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
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("consignor_name"=>$consignor_name,"party_name"=>$party_name,"address"=>$address,"city"=>$city,"state"=>$state,"pincode"=>$pincode,"phone_no"=>$phone_no,"mobile_no"=>$mobile_no,"mobile_no1"=>$mobile_no1,"party_mobile_no"=>$party_mobile_no,"place_id"=>$place_id,"gstin"=>$gstin,"state_code"=>$state_code,"created_by"=>$user_id,"gstin"=>$gstin);
        $this->db->insert('tbl_consignor',$data);
        return $this->db->insert_id();

    }
    public function getconsignor($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        $arr=array("consignor_id","consignor_name", "party_name", "address", "city", "state", "pincode", "phone_no", "mobile_no", "mobile_no1", "party_mobile_no","place_name", "gstin");
        if($start=='' && $length=='' && $searchstr=='')
        {

            $query=$this->db->select('`consignor_id`, `consignor_name`, `party_name`, `address`, `city`, `state`, `pincode`, `phone_no`, `mobile_no`, `mobile_no1`, `party_mobile_no`, `place_id`, `gstin`')
                ->from('tbl_consignor')
                ->order_by('consignor_name','ASC')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('`consignor_id`, `consignor_name`, `party_name`, `address`, `city`, `state`, `pincode`, `phone_no`, `mobile_no`, `mobile_no1`, `party_mobile_no`, tbl_consignor.place_id,place_name, `gstin`');
            if(!empty($searchstr))
            {
                $this->db->or_like('consignor_name', $searchstr);
                $this->db->or_like('party_name', $searchstr);
                $this->db->or_like('address', $searchstr);
                $this->db->or_like('city', $searchstr);
                $this->db->or_like('state', $searchstr);
                $this->db->or_like('pincode', $searchstr);
                $this->db->or_like('phone_no', $searchstr);
                $this->db->or_like('mobile_no', $searchstr);
                $this->db->or_like('mobile_no1', $searchstr);
                $this->db->or_like('party_mobile_no', $searchstr);
                $this->db->or_like('place_name', $searchstr);
                $this->db->or_like('gstin', $searchstr);
            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_consignor')->join('place', 'place.place_id = tbl_consignor.place_id', 'left')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_consignor');
            $this->db->join('place', 'place.place_id = tbl_consignor.place_id', 'left');
            $this->db->order_by('consignor_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            //echo $this->db->last_query();
            //exit;
            return $response;
        }
    }
    public function getconsignorbyid($consignorid)
    {
        $query=$this->db->select('`consignor_id`, `consignor_name`, `party_name`, `address`, `city`, `state`, `pincode`, `phone_no`, `mobile_no`, `mobile_no1`, `party_mobile_no`, `place_id`, `gstin`,state_code')
            ->from('tbl_consignor')
            ->where(array("consignor_id"=>$consignorid))
            ->get();
        $record['consignor']=$query->result_array();

        return $record;
    }
    public function updateconsignor($post)
    {
        if(empty($_POST['consignor_name']))
            $consignor_name="";
        else
            $consignor_name=$_POST['consignor_name'];
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
        $data=array("consignor_name"=>$consignor_name,"party_name"=>$party_name,"address"=>$address,"city"=>$city,"state"=>$state,"pincode"=>$pincode,"phone_no"=>$phone_no,"mobile_no"=>$mobile_no,"mobile_no1"=>$mobile_no1,"party_mobile_no"=>$party_mobile_no,"place_id"=>$place_id,"gstin"=>$gstin,"state_code"=>$state_code);
        $lastid=encryptor("decrypt",$post['consignor_id']);
        $this->db->where('consignor_id', encryptor("decrypt",$post['consignor_id']));
        $this->db->update('tbl_consignor',$data);
    }
    public function deletebyid($consignorid)
    {
         if($this->session->userdata('user_id')==1) {
            $this->db->where('consignor_id', $consignorid);
            $this->db->delete('tbl_consignor');
        }
        return $this->db->affected_rows();
    }
    public function getConsignorByPlace($place_id)
    {

        $query=$this->db->select('`consignor_id`, `consignor_name`, `party_name`, `address`, `city`, `state`, `pincode`, `phone_no`, `mobile_no`, `mobile_no1`, `party_mobile_no`, `place_id`, `gstin`')
            ->from('tbl_consignor')
            ->where(array("place_id"=>$place_id))
            ->get();
           
            return $query->result_array();
    }

}
?>