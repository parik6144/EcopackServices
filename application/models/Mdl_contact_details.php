<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_contact_details extends CI_Model{

    public function savecontact ($post)
    {
        
        if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];

        if(empty($_POST['person_name']))
            $person_name="";
        else
            $person_name=$_POST['person_name'];

        if(empty($_POST['mobile_no']))
            $mobile_no="";
        else
            $mobile_no=$_POST['mobile_no'];
      
        
        if(empty($_POST['email_id']))
            $email_id="";
        else
            $email_id=$_POST['email_id'];

         if(empty($_POST['reason']))
            $reason="";
        else
            $reason=$_POST['reason'];

        $contact_type=$_POST['contact_type'];

        
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

         //`party_name`, `mobile_no`, `mobile_no1`, `address`, `city`, `pincode`, `bank_name`, `branch`, `contact_no`, `ifsc_code`
        $data=array("consignee_id"=>$consignee_id,
            "mobile_no"=>$mobile_no,
            "email_id"=>$email_id,
            "reason"=>$reason,
            "contact_type"=>$contact_type,
            "person_name"=>$person_name,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_contact_details',$data);
        $lastid=$this->db->insert_id();        
        return $lastid;


    }
    public function getcontact($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`contact_id`, `party_name`')
                ->from('tbl_contact_details')
                ->where('is_deleted','0')
                ->order_by('party_name','ASC')
                ->get();
            return $query->result_array();
        }
        else
        {

            $arr=array("contact_id", "email_id", "person_name", "mobile_no", "reason","consignee_name","consignor_name");

            $this->db->select('`contact_id`, `email_id`, `person_name`, tbl_contact_details.mobile_no, `reason`,`consignee_name`,consignor_name,contact_type');
            if(!empty($searchstr))
            {
                $this->db->or_like('email_id', $searchstr);
                $this->db->or_like('person_name', $searchstr);
                $this->db->or_like('mobile_no', $searchstr);
                $this->db->or_like('reason', $searchstr);
                $this->db->or_like('consignee_name', $searchstr);
                $this->db->or_like('consignor_name', $searchstr);
            }
             $this->db->where('is_deleted','0');
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_contact_details')->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_contact_details.consignee_id', 'left')->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_contact_details.consignee_id', 'left')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_contact_details');
            $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_contact_details.consignee_id', 'left');
            $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_contact_details.consignee_id', 'left');
            $this->db->order_by('contact_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getcontactbyid($ownerid)
    {
        $query=$this->db->select('`contact_id`, `consignee_id`, `email_id`, `person_name`, `mobile_no`, `reason`,contact_type')
            ->from('tbl_contact_details')
            ->where(array("contact_id"=>$ownerid))
            ->get();
        $record['contact']=$query->result_array();
        return $record;
    }
    public function updatecontact($post)
    {
        if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];

        if(empty($_POST['person_name']))
            $person_name="";
        else
            $person_name=$_POST['person_name'];

        if(empty($_POST['mobile_no']))
            $mobile_no="";
        else
            $mobile_no=$_POST['mobile_no'];
      
        
        if(empty($_POST['email_id']))
            $email_id="";
        else
            $email_id=$_POST['email_id'];

         if(empty($_POST['reason']))
            $reason="";
        else
            $reason=$_POST['reason'];
        
        $contact_type=$_POST['contact_type'];

        
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

         //`party_name`, `mobile_no`, `mobile_no1`, `address`, `city`, `pincode`, `bank_name`, `branch`, `contact_no`, `ifsc_code`
        $data=array("consignee_id"=>$consignee_id,
            "mobile_no"=>$mobile_no,
            "email_id"=>$email_id,
            "reason"=>$reason,
            "person_name"=>$person_name,"updated_by"=>$user_id,"updated_datetime"=>$datetime);
        $lastid=encryptor("decrypt",$post['contact_id']);
        $this->db->where('contact_id', encryptor("decrypt",$post['contact_id']));
        $this->db->update('tbl_contact_details',$data);
        return $lastid;
    }
    public function deletebyid($ownerid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('contact_id', $ownerid);
        $this->db->update('tbl_contact_details',$data);
        return $this->db->affected_rows();
    }

}
?>