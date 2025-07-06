<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_attendance extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url','form'));
        $this->load->library(array('session','form_validation','user_agent'));
    }

    public function getattendance($start="",$length="",$searchstr="",$column,$type)
    {
        //  echo 467567; exit();
        //  $start=2;
        //  $length=2;
        //  $searchstr=2;
        $col = (int)$column;
        $arr = array("attnID","staff","staff_name","mobile_no","attnForMonth","attnForYear","attnDays","ot_hrs","Holidaydays","attnRemarks");
        if($start=='' && $length=='' && $searchstr=='')
        {
            $sql="SELECT attnID,staff,staff_name,mobile_no,attnForMonth,attnForYear,attnDays,ot_hrs,Holidaydays,attnRemarks FROM `tbl_staff_attendance` LEFT JOIN staff on staff.staff_id=tbl_staff_attendance.staff
ORDER BY `tbl_staff_attendance`.`attnID` DESC WHERE tbl_staff_attendance.is_deleted=0";

            $query=$this->db->query($sql);
            // echo $this->db->last_query(); exit();
            return $query->result_array();
        }
        else
        {
            // echo 467567; exit();
            $this->db->select(`attnID`,`staff`,`staff_name`,`mobile_no`,`attnForMonth`,`attnForYear`,`attnDays`,`ot_hrs`,`Holidaydays`,`attnRemarks`);
            if(!empty($searchstr))
            {
                $this->db->or_like('attnID', $searchstr);
                $this->db->or_like('staff', $searchstr);
                $this->db->or_like('staff_name', $searchstr);
                $this->db->or_like('mobile_no', $searchstr);
                $this->db->or_like('attnForMonth', $searchstr);
                $this->db->or_like('attnForYear', $searchstr);
                $this->db->or_like('attnDays', $searchstr);
                $this->db->or_like('ot_hrs', $searchstr);
                $this->db->or_like('Holidaydays', $searchstr);
                $this->db->or_like('attnRemarks', $searchstr);
            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_staff_attendance')->join('staff','staff.staff_id=tbl_staff_attendance.staff','left')->where('staff.is_deleted','0')->count_all_results();
            // echo $this->db->last_query(); exit();
            if($length>0)
                //$this->db->limit($length, $start);

                $sql=$this->db->select(`attnID`,`staff`,`staff_name`,`mobile_no`,`attnForMonth`,`attnForYear`,`attnDays`,`ot_hrs`,`Holidaydays`,`attnRemarks`);
            $this->db->from('tbl_staff_attendance');
            $this->db->join('staff','staff.staff_id = tbl_staff_attendance.staff','left');
            $this->db->where('staff.is_deleted','0');
            $this->db->order_by('staff_id','desc');
            $query=$this->db->get();
            // echo $this->db->last_query(); exit();

            $response['data']=$query->result_array();
            $response['count']= $num_rows;

            // print_r($query->result_array()); exit();
            return $response;
        }
    }

    function countpayslipstatusbyid($attnID)
    {
        $query=$this->db->select('*')
            ->from('tbl_staff_attendance')
            ->where('attnID',$attnID)
            ->where('payslip_created',0)
            ->get();
        // echo $this->db->last_query(); exit();
        return $CountPaySlip = count($query->row());
    }

    function getpayslipstatusbyid($attnID)
    {
//        $sql="SELECT *  FROM `tbl_staff_attendance`
//                JOIN `staff` ON `tbl_staff_attendance`.`staff`=`staff`.`staff_id`
//                JOIN `employee_salary` ON `employee_salary`.`staff_id`=`staff`.`staff_id`
//                WHERE `attnID` = $attnID AND `payslip_created` = 0 ORDER BY `attnID` ASC";
//        $query = $this->db->query($sql);
        $query=$this->db->select('*')
            ->from('tbl_staff_attendance')
            ->join('staff','tbl_staff_attendance.staff=staff.staff_id')
           // ->join('employee_salary','employee_salary.staff_id=staff.staff_id')
            ->where('attnID',$attnID)
            ->where('payslip_created',0)
            ->get();
         //echo $this->db->last_query(); exit();
        return $query->row();
    }

    function getEmpSal($staffID)
    {
        $sql="SELECT *  FROM `employee_salary` WHERE `staff_id` = $staffID";
        $query = $this->db->query($sql);
        return $query->row();
    }

    function saveattendance()
    {
        $attend_employee = $this->input->post('attend_employee');
        $attend_employee = !empty($attend_employee) ? "$attend_employee" : " ";

        $attend_month = $this->input->post('attend_month');
        $attend_month = !empty($attend_month) ? "$attend_month" : " ";

        $attend_year = $this->input->post('attend_year');
        $attend_year = !empty($attend_year) ? "$attend_year" : " ";

        $attendance_days =$this->input->post('attendance_days');
        $attendance_days = !empty($attendance_days) ? "$attendance_days" : " ";

        $attendance_ot =$this->input->post('attendance_ot');
        $attendance_ot = !empty($attendance_ot) ? "$attendance_ot" : " ";

        $holidays_days = $this->input->post('holidays_days');
        $holidays_days = !empty($holidays_days) ? "$holidays_days" : " ";

        $leave_days = $this->input->post('leave_days');
        $leave_days = !empty($leave_days) ? "$leave_days" : " ";

        $loan_amt = $this->input->post('loan_amt');
        $loan_amt = !empty($loan_amt) ? "$loan_amt" : " ";

        $attnRemarks = $this->input->post('attnRemarks');
        $attnRemarks = !empty($attnRemarks) ? "$attnRemarks" : " ";

        $data= array(
            'staff'=>$attend_employee,
            'attnForMonth'=>$attend_month,
            'attnForYear'=>$attend_year,
            'attnDays'=>$attendance_days,
            'ot_hrs'=>$attendance_ot,
            'casual_leave'=>$leave_days,
            'loan_amt'=>$loan_amt,
            'Holidaydays'=>$holidays_days,
            'attnRemarks'=>$attnRemarks,
            'CreatedDatetime'=>date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_staff_attendance',$data);
        //echo $this->db->last_query(); exit();
        return $this->db->affected_rows();
    }

    function checkattendanceavailability()
    {
        $attend_employee = $this->input->post('attend_employee');
        $attend_employee = !empty($attend_employee) ? "$attend_employee" : " ";

        $attend_month = $this->input->post('attend_month');
        $attend_month = !empty($attend_month) ? "$attend_month" : " ";

        $attend_year = $this->input->post('attend_year');
        $attend_year = !empty($attend_year) ? "$attend_year" : " ";

        $query = $this->db->select('*')
            ->from('tbl_staff_attendance')
            ->where('staff',$attend_employee)
            ->where('attnForMonth',$attend_month)
            ->where('attnForYear',$attend_year)
            ->get();
       // echo $this->db->last_query(); exit();
        return count($query->result());
    }

    public function getemployeebyid($employeeid)
    {
        $query = $this->db->select('*')
            ->from('staff')
            ->join('employee_type','employee_type.employee_type_id=staff.employee_type_id')
            ->join('employee_salary','employee_salary.staff_id = staff.staff_id')
            ->where('staff.staff_id',$employeeid)
            ->get();
        //echo $this->db->last_query(); exit();
        //print_r($query->result_array()); exit();
        $record['employee'] = $query->result_array();
        return $record;
    }

    public function getPaySlipbyAttnIDDetails($payslipid)
    {
        $sql= "SELECT * FROM `tbl_payslip` where `attnID`=$payslipid";
        $query = $this->db->query($sql);
        // echo $this->db->last_query(); exit();
        $record['payslip'] = $query->result_array();
        return $record;
    }

    public function getPaySlipDetails($payslipid)
    {
        $sql= "SELECT * FROM `tbl_payslip`";
        $query = $this->db->query($sql);
        // echo $this->db->last_query(); exit();
        $record['payslip'] = $query->result_array();
        return $record;
    }

    function savepayslipbyattn($attnID)
    {
        //echo $attnID; exit();
        $record = $this->getpayslipstatusbyid($attnID);
        if($record->payslip_created==0){
            $staffID = $record->staff;

            $EmpSal = $this->getEmpSal($staffID);
            //echo $countEmpSal = Count($EmpSal); exit();

            // GET ADVANCE SALARY STARTS HERE.
            $querySal = $this->db->select('*')
                ->from('tbl_advance_salary')
                ->where('employee_id',$record->staff)
                ->where('month_id',$record->attnForMonth)
                ->where('year_id',$record->attnForYear)
                ->get();
            // echo $this->db->last_query(); exit();
            $AdvSal = $querySal->row();
            if($AdvSal==''){ $AdvSal=0; }
            // GET ADVANCE SALARY ENDS HERE.

            $data = array(
                'attnID'=> $record->attnID,
                'staffID'=> $record->staff,
                'CreatedDatetime'=>date('Y-m-d H:i:s')
            );
            //print_r($data); exit();

            if($this->db->insert('tbl_payslip',$data))
            {
                $GrossPay = $EmpSal->basic+$EmpSal->hra+$EmpSal->da+$EmpSal->cea+$EmpSal->tpa;
                $singleDayPayAmt = $GrossPay/30;
                if($record->casual_leave>0){ $leaveDeduAmt=($record->casual_leave*$singleDayPayAmt); } else { $leaveDeduAmt=0; }
                if($GrossPay>=15000){ $profund=(15000*12)/100; $esic=0; }
                if($GrossPay<15000){ $profund=(14000*12)/100; $esic=($GrossPay*0.75)/100;}
                $dataPayslip = array(
                    'payslip_id'=> $this->db->insert_id(),
                    'attnID'=> $record->attnID,
                    'staffID'=> $record->staff,
                    'payslip_month'=> $record->attnForMonth,
                    'payslip_year'=> $record->attnForYear,
                    'paying_days'=> $record->attnDays,
                    'casual_leave'=> $record->casual_leave,
                    'paying_ot_hrs'=> $record->ot_hrs,
                    'paying_holidays'=> $record->Holidaydays,
                    'paying_basic_rate'=> $EmpSal->basic,
                    'paying_hra_rate'=> $EmpSal->hra,
                    'paying_da_rate'=> $EmpSal->da,
                    'paying_cea_rate'=> $EmpSal->cea,
                    'paying_tpa_rate'=> $EmpSal->tpa,
                    'paying_ot_rate'=> $EmpSal->ot_per_hour,
                    'pf_amt'=> $profund,
                    'esi_amt'=> $esic,
                    'advance_sal'=> $AdvSal,
                    'leave_dedu_amt'=> $leaveDeduAmt,
                    'loan_emi_amt'=> $record->loan_amt,
                    'payslip_remarks'=> $record->attnRemarks,
                    'CreatedDatetime'=>date('Y-m-d H:i:s')
                );
                //print_r($dataPayslip); exit();
                $this->db->insert('payslip_details',$dataPayslip);
                // echo $this->db->last_query(); exit();
                //echo $this->db->affected_rows(); exit();

                if($this->db->affected_rows())
                    //  if($this->db->insert('payslip_details',$dataPayslip))
                {
                    $datapc = array(
                        'payslip_created'=> 1
                    );
                    $this->db->where('attnID',$record->attnID);
                    $this->db->update('tbl_staff_attendance',$datapc);
                }
                else
                {
                    $this->db->where('attnID',$record->attnID);
                    $this->db->delete('tbl_payslip');
                }
            }}
        return true;
    }

    public function deletebyid($attn_id)
    {
        $this->db->where('attnID', $attn_id);
        $this->db->delete('tbl_staff_attendance');
        return $this->db->affected_rows();
    }


}
?>