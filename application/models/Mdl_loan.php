<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_loan extends CI_Model{

    public function saveloan ($post)
    {
        
        if(empty($_POST['account_id']))
            $account_id="";
        else
            $account_id=$_POST['account_id'];

        if(empty($_POST['loan_date']))
            $loan_date="";
        else
            $loan_date=$_POST['loan_date'];
        
        if(empty($_POST['loan_amount']))
            $loan_amount="";
        else
            $loan_amount=$_POST['loan_amount'];

        if(empty($_POST['due_amount']))
            $due_amount="";
        else
            $due_amount=$_POST['due_amount'];

        if(empty($_POST['interest_rate']))
            $interest_rate="";
        else
            $interest_rate=$_POST['interest_rate'];

        if(empty($_POST['loan_time']))
            $loan_time="";
        else
            $loan_time=$_POST['loan_time'];

        if(empty($_POST['loan_type']))
            $loan_type="";
        else
            $loan_type=$_POST['loan_type'];

        if(empty($_POST['monthly_emi']))
            $monthly_emi="";
        else
            $monthly_emi=$_POST['monthly_emi'];

        if(empty($_POST['loan_type']))
            $loan_type="";
        else
            $loan_type=$_POST['loan_type'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

         //`party_name`, `mobile_no`, `mobile_no1`, `address`, `city`, `pincode`, `bank_name`, `branch`, `loan_no`, `ifsc_code`
        $data=array("account_id"=>$account_id,
            "loan_date"=>$loan_date,
            "loan_amount"=>$loan_amount,
            "due_amount"=>$due_amount,
            "interest_rate"=>$interest_rate,
            "loan_time"=>$loan_time,
            "loan_type"=>$loan_type,
            "monthly_emi"=>$monthly_emi,
            "created_by"=>$user_id,
            "created_datetime"=>$datetime);
        $this->db->insert('tbl_loan',$data);
        $lastid=$this->db->insert_id();        
        return $lastid;
    }
    
    
    public function getloan($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`loan_id`, `party_name`')
                ->from('tbl_loan')
                ->where('is_deleted','0')
                ->order_by('party_name','ASC')
                ->get();
            return $query->result_array();
        }
        else
        {

            $arr=array("loan_id", "party_name", "loan_date", "loan_amount", "due_amount", "interest_rate", "monthly_emi", "loan_time");

            $this->db->select('`loan_id`, party_name,`loan_date`, `loan_amount`, `due_amount`, `interest_rate`, `loan_time`, `monthly_emi`, `loan_type`');
            if(!empty($searchstr))
            {
                $this->db->or_like('party_name', $searchstr);
                $this->db->or_like('loan_amount', $searchstr);
                $this->db->or_like('due_amount', $searchstr);
                $this->db->or_like('interest_rate', $searchstr);
            }
             $this->db->where('tbl_loan.is_deleted','0');
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_loan')->join('tbl_account','tbl_account.account_id=tbl_loan.account_id','left')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_loan');
             $this->db->where('tbl_loan.is_deleted','0');
            $this->db->join('tbl_account','tbl_account.account_id=tbl_loan.account_id','left');
            $this->db->order_by('loan_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    
    
    public function getloanbyid($loan_id)
    {
        // $query=$this->db->select(' `loan_id`, `account_id`, `loan_date`, `loan_amount`, `due_amount`, `interest_rate`, `loan_time`, `monthly_emi`, `loan_type`')
        //     ->from('tbl_loan')
        //     ->where(array("loan_id"=>$loan_id))
        //     ->get();
        // $record['loan']=$query->result_array();
        // return $record;
        
         $que ="SELECT
        tbl_loan.loan_id, tbl_loan.account_id,
        tbl_loan.loan_date, tbl_loan.loan_amount,
        tbl_loan.due_amount, tbl_loan.due_amount,
        tbl_loan.interest_rate, tbl_loan.loan_time,
        tbl_loan.monthly_emi, tbl_loan.loan_type,
        max(loan_booking.booking_date) as `booking_date`
        FROM `tbl_loan`
        LEFT JOIN `loan_booking` ON `loan_booking`.`loan_id`=`tbl_loan`.`loan_id`
        WHERE `tbl_loan`.loan_id=$loan_id";

        $query= $this->db->query($que);
        $record['loan']=$query->result_array();
        return $record;
    }
    
    
    public function updateloan($post)
    {
        if(empty($_POST['account_id']))
            $account_id="";
        else
            $account_id=$_POST['account_id'];

        if(empty($_POST['loan_date']))
            $loan_date="";
        else
            $loan_date=$_POST['loan_date'];
        
        if(empty($_POST['loan_amount']))
            $loan_amount="";
        else
            $loan_amount=$_POST['loan_amount'];

        if(empty($_POST['due_amount']))
            $due_amount="";
        else
            $due_amount=$_POST['due_amount'];

        if(empty($_POST['interest_rate']))
            $interest_rate="";
        else
            $interest_rate=$_POST['interest_rate'];

        if(empty($_POST['loan_time']))
            $loan_time="";
        else
            $loan_time=$_POST['loan_time'];

        if(empty($_POST['monthly_emi']))
            $monthly_emi="";
        else
            $monthly_emi=$_POST['monthly_emi'];

        if(empty($_POST['loan_type']))
            $loan_type="";
        else
            $loan_type=$_POST['loan_type'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

         //`party_name`, `mobile_no`, `mobile_no1`, `address`, `city`, `pincode`, `bank_name`, `branch`, `loan_no`, `ifsc_code`
        $data=array("account_id"=>$account_id,
            "loan_date"=>$loan_date,
            "loan_amount"=>$loan_amount,
            "due_amount"=>$due_amount,
            "interest_rate"=>$interest_rate,
            "loan_time"=>$loan_time,
            "monthly_emi"=>$monthly_emi,
            "updated_by"=>$user_id,
            "updated_datetime"=>$datetime);
        $lastid=encryptor("decrypt",$post['loan_id']);
        $this->db->where('loan_id', $lastid);
        $this->db->update('tbl_loan',$data);
        return $lastid;
    }
    
    
    public function deletebyid($ownerid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('loan_id', $ownerid);
        $this->db->update('tbl_loan',$data);

        return $this->db->affected_rows();
    }
    
    
    public function getPendingloan()
    {
        $current_date=date('Y-m-d');
        $query=$this->db->select('tbl_loan.loan_id,tbl_loan.account_id, party_name,`loan_date`,  `monthly_emi`, `loan_type`,max(booking_date) as booking_date')
        ->from('tbl_loan')
        ->join('tbl_account','tbl_account.account_id=tbl_loan.account_id','left')
        ->join('loan_booking','loan_booking.loan_id=tbl_loan.loan_id','left')
        ->group_by(array('account_id','tbl_loan.loan_id'))
        ->where('tbl_loan.is_deleted','0')
        ->get();
        $response=$query->result_array();
        return $response;
        
    }
    
 

}
?>