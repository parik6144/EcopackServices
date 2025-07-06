<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_diesel_expense extends CI_Model{

    public function savediesel_expense($post)
    {
        //`id`, `expense_head_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['booking_date']))
            $booking_date="";
        else
            $booking_date=$_POST['booking_date'];

        if(empty($_POST['vehicle_id']))
            $vehicle_id="";
        else
            $vehicle_id=$_POST['vehicle_id'];

        if(empty($_POST['amount']))
            $amount="";
        else
            $amount=$_POST['amount'];

        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        $data=array("vehicle_id"=>$vehicle_id,"amount"=>$amount,"expense_date"=>$booking_date,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('diesel_expense',$data);
        return $this->db->insert_id();
    }
    public function getdiesel_expense($start="",$length="",$searchstr="",$column,$type)
    {
         $col = (int)$column;
         $arr=array("diesel_expense.expense_id","expense_date","tbl_vehicle_inward.vehicle_inward_no","amount");
        if($start=='' && $length=='' && $searchstr=='')
        {
            
            $query=$this->db->select('`expense_id`, `vehicle_id`, `amount`, `expense_date`')
                ->from('diesel_expense')
                ->where('is_deleted', '0')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('diesel_expense.expense_id,expense_date,tbl_vehicle_inward.vehicle_inward_no,amount');
            $this->db->where('diesel_expense.is_deleted', '0');
            if(!empty($searchstr))
            {
                $this->db->or_like('tbl_vehicle_inward.vehicle_inward_no', $searchstr);
            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('diesel_expense')
            ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = diesel_expense.vehicle_id', 'left')
            ->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = diesel_expense.vehicle_id', 'left');
            $this->db->from('diesel_expense');
            $this->db->order_by('diesel_expense.expense_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getdiesel_expensebyid($expense_headid)
    {
        $query=$this->db->select('`expense_id`, `vehicle_id`, `amount`, `expense_date`')
            ->from('diesel_expense')
            ->where(array("expense_id"=>$expense_headid))
            ->get();
        $record['diesel_expense']=$query->result_array();

        return $record;
    }
    public function updatediesel_expense($post)
    {
       if(empty($_POST['booking_date']))
            $booking_date="";
        else
            $booking_date=$_POST['booking_date'];

        if(empty($_POST['vehicle_id']))
            $vehicle_id="";
        else
            $vehicle_id=$_POST['vehicle_id'];

        if(empty($_POST['amount']))
            $amount="";
        else
            $amount=$_POST['amount'];

        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        $data=array("vehicle_id"=>$vehicle_id,"amount"=>$amount,"expense_date"=>$booking_date,"updated_by"=>$user_id,"updated_datetime"=>$datetime);
        $lastid=encryptor("decrypt",$post['expense_head_id']);
        $this->db->where('expense_id', encryptor("decrypt",$post['expense_id']));
        $this->db->update('diesel_expense',$data);
       
    }
    public function deletebyid($expense_headid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('expense_head_id', $expense_headid);
        $this->db->update('tbl_expense_head',$data);
        return $this->db->affected_rows();
    }
    public function getmonthlyexpense(){
        $fromdate=date('Y-m-01');
        $a_date = date('Y-m-d');
        $todate= date("Y-m-t", strtotime($a_date));
        $sql="SELECT tbl_expense_head.expense_head_id,expense_head_name,sum(amount) as amount FROM `tbl_expense_head` LEFT JOIN tbl_payment_booking on tbl_payment_booking.expense_head_id=tbl_expense_head.expense_head_id  where tbl_payment_booking.is_deleted=0 and tbl_payment_booking.is_confirm=2 and payment_date>='".$fromdate."' and payment_date<='".$todate."' GROUP by tbl_expense_head.expense_head_id";
        $query=$this->db->query($sql);
        return $query->result_array();
    }

    public function getmonthlytransportation(){
        $fromdate=date('Y-m-01');
        $a_date = date('Y-m-d');
        $todate= date("Y-m-t", strtotime($a_date));
        $sql="SELECT sum(amount) as amount FROM `tbl_payment_due`  where  created_datetime>='".$fromdate."' and created_datetime<='".$todate."'";
    
        $query=$this->db->query($sql);
        $totaldue=$query->row();
        $sql="SELECT sum(amount) as amount FROM `tbl_payment_advance`  where  created_datetime>='".$fromdate."' and created_datetime<='".$todate."'";
        $query=$this->db->query($sql);
        $totaladvance=$query->row();
        return $totaldue->amount+$totaladvance->amount;

    }

}
?>