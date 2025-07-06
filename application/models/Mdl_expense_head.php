<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_expense_head extends CI_Model{

    public function saveexpense_head($post)
    {
        //`id`, `expense_head_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['expense_head_name']))
            $expense_head_name="";
        else
            $expense_head_name=$_POST['expense_head_name'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        $data=array("expense_head_name"=>$expense_head_name,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_expense_head',$data);
        return $this->db->insert_id();

    }
    public function getexpense_head($start="",$length="",$searchstr="",$column,$type)
    {
         $col = (int)$column;
         $arr=array("expense_head_id","expense_head_name");
        if($start=='' && $length=='' && $searchstr=='')
        {
            
            $query=$this->db->select('expense_head_id,`expense_head_name`')
                ->from('tbl_expense_head')
                ->where('is_deleted', '0')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('expense_head_id,`expense_head_name`');
            $this->db->where('is_deleted', '0');
            if(!empty($searchstr))
            {
                $this->db->or_like('expense_head_name', $searchstr);

            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_expense_head')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_expense_head');
            $this->db->order_by('expense_head_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getexpense_headbyid($expense_headid)
    {
        $query=$this->db->select('`expense_head_name`,expense_head_id')
            ->from('tbl_expense_head')
            ->where(array("expense_head_id"=>$expense_headid))
            ->get();
        $record['expense_head']=$query->result_array();

        return $record;
    }
    public function updateexpense_head($post)
    {
        if(!empty($post['expense_head_name']))
            $expense_head_name=$post['expense_head_name'];
        else
            $expense_head_name='';
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("expense_head_name"=>$expense_head_name,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['expense_head_id']);
        $this->db->where('expense_head_id', encryptor("decrypt",$post['expense_head_id']));
        $this->db->update('tbl_expense_head',$data);
       
    }
    public function deletebyid($expense_headid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('expense_head_id', $expense_headid);
        $this->db->update('tbl_expense_head',$data);
        return $this->db->affected_rows();
    }
    public function getmonthlyexpense(){
        $month=$_GET['m'];
        $year=$_GET['y'];
        $sql="SELECT tbl_expense_head.expense_head_id,expense_head_name,sum(amount) as amount FROM `tbl_expense_head` LEFT JOIN tbl_payment_booking on tbl_payment_booking.expense_head_id=tbl_expense_head.expense_head_id  where tbl_payment_booking.is_deleted=0 and tbl_payment_booking.is_confirm=2 and year(payment_date)=".$year." and month(payment_date)=".$month." and tbl_expense_head.expense_head_id!='18' GROUP by tbl_expense_head.expense_head_id";
        $query=$this->db->query($sql);
        return $query->result_array();
    }


   
}
?>