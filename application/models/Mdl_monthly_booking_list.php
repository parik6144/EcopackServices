<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_monthly_booking_list extends CI_Model{

    public function savemonthly_booking_list($post)
    {
        //`id`, `party_name`, `mobile`, `mobile2`, `phone`, `phone2`
        $insertdata=array();
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        for($i=0;$i<sizeof($post['ref_id']);$i++)
        {
            $data=array("party_id"=>$post['ref_id'][$i],"ref_type"=>$post['receiver_type'],"created_by"=>$user_id,"created_datetime"=>$datetime);
            array_push($insertdata, $data);
        }
        $this->db->insert_batch('monthly_booking_list', $insertdata); 
        return $this->db->insert_id();

    }
    public function getUserName($receiver_type,$ref_id)
    {
        if($receiver_type=="1")
        {
            $query=$this->db->select('staff_name as ref_name,"employee" as receiver_type')
            ->from('staff')
            ->where('staff_id',$ref_id)->get();
        }
        elseif($receiver_type=="2")
        {
            $query=$this->db->select('party_name as ref_name,"Other Party" as receiver_type')
            ->from('tbl_account')
            ->where('account_id',$ref_id)->get();
        }
        elseif($receiver_type=="3")
        {
            $query=$this->db->select('owner_name as ref_name, "Transporter" as receiver_type')
            ->from('tbl_inward_owner')
            ->where('owner_id',$ref_id)->get();
        }
        elseif($receiver_type=="4")
        {
            $query=$this->db->select('employee_name as ref_name,"Other Employee" as receiver_type')
            ->from('tbl_employee')
            ->where('employee_id',$ref_id)->get();
        }
        return $query->row();

    }
    public function getmonthly_booking_list($ref_id)
    {
        $currentyear=date('Y');
        $this->db->select('monthly_booking_id,party_id,ref_type,max(booking_date) as booking_date,expense_head_id');
        $this->db->from('monthly_booking_list');
        $this->db->join('tbl_payment_booking t1','t1.receiver_type=monthly_booking_list.ref_type and t1.ref_id=monthly_booking_list.party_id','left');
        if($ref_id=="1")
        {
            $this->db->where('expense_head_id','13');
            
        }
        else if($ref_id=="3")
        {
            $this->db->where('expense_head_id','18');
        }
        $this->db->where('ref_type',$ref_id);
        $this->db->group_by('party_id');
        $this->db->group_by('ref_type');
        $this->db->order_by('t1.booking_date','DESC');
        $sql=$this->db->get();
        //echo $this->db->last_query();
        //exit;
        $data=$sql->result_array();

        $returndata=array();
        foreach ($data as $row) {
            $arr=[];
            $arr['party_id']=$row['party_id'];
            $arr['ref_type']=$row['ref_type'];
            $arr['booking_date']=$row['booking_date'];
            $arr['monthly_booking_id']=$row['monthly_booking_id'];
            $arr['expense_head_id']=$row['expense_head_id'];
            $arr['name']=$this->getUserName($row['ref_type'],$row['party_id']);
            array_push($returndata, $arr);
        }
        return $returndata;
    }
    
    public function deletebyid($id)
    {
        $this -> db -> where('monthly_booking_id', $id);
        $this -> db -> delete('monthly_booking_list');
        return "1";
    }
    

}
?>