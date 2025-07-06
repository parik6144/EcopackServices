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
            $sql="SELECT attnID,staff,staff_name,mobile_no,attnForMonth,attnForYear,attnDays,ot_hrs,Holidaydays,attnRemarks
                 FROM `tbl_staff_attendance`
                 LEFT JOIN staff on staff.staff_id=tbl_staff_attendance.staff
                 WHERE tbl_staff_attendance.is_deleted=0";
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

        $attnRemarks = $this->input->post('attnRemarks');
        $attnRemarks = !empty($attnRemarks) ? "$attnRemarks" : " ";

        $data= array(
            'staff'=>$attend_employee,
            'attnForMonth'=>$attend_month,
            'attnForYear'=>$attend_year,
            'attnDays'=>$attendance_days,
            'ot_hrs'=>$attendance_ot,
            'Holidaydays'=>$holidays_days,
            'attnRemarks'=>$attnRemarks,
            'CreatedDatetime'=>date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_staff_attendance',$data);
        return true;
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

    public function getPaySlipDetails($payslipid)
    {
        $sql= "SELECT * FROM `tbl_payslip`";
        $query = $this->db->query($sql);
        //echo $this->db->last_query(); exit();
        $record['payslip'] = $query->result_array();
        return $record;
    }

}
?>