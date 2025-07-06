<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Attendance extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        $data['title']="Attendance";
        $this->load->model('mdl_attendance');
        $this->load->model('Mdl_setting');
    }

    public function index()
    {
        $data['title']="Attendance";
        $this->load->view('Attendance/attendance_details',$data);
    }

    public function viewpayslip()
    {
         $payslipID = encryptor("decrypt", $this->uri->segment(3)); // exit();

        // GETTING PAYSLIP DETAILS STARTS HERE.
        $paySlipDetails = $this->mdl_attendance->getPaySlipbyAttnIDDetails($payslipID);
        //print_r($paySlipDetails); exit();
        $EmpID = $data['empID'] = $paySlipDetails['payslip'][0]['staffID'];
        $data['payslip_id'] = $paySlipDetails['payslip'][0]['payslip_id'];
        $data['attnID'] = $paySlipDetails['payslip'][0]['attnID'];
        // GETTING PAYSLIP DETAILS ENDS HERE.

        //print_r($paySlipDetails);
        //exit();

        // GETTING EMPLOYEE DETAILS STARTS HERE.
        $empDetails = $this->mdl_attendance->getemployeebyid($EmpID);
        $data['emp_id'] = $EmpID;
        $data['emp_no'] = $empDetails['employee'][0]['emp_no'];
        $data['staff_name'] = $empDetails['employee'][0]['staff_name'];
        $data['mobile_no'] = $empDetails['employee'][0]['mobile_no'];
        $data['email_id'] = $empDetails['employee'][0]['email_id'];
        $data['photo'] = $empDetails['employee'][0]['photo'];
        $data['blood_group'] = $empDetails['employee'][0]['blood_group'];
        $data['gstin'] = $empDetails['employee'][0]['gstin'];
        $data['bank_name'] = $empDetails['employee'][0]['bank_name'];
        $data['branch'] = $empDetails['employee'][0]['branch'];
        $data['location'] = $empDetails['employee'][0]['location'];
        $data['account_no'] = $empDetails['employee'][0]['account_no'];
        $data['ifsc_code'] = $empDetails['employee'][0]['ifsc_code'];
        $data['type_name'] = $empDetails['employee'][0]['type_name'];
        $data['salary_id'] = $empDetails['employee'][0]['salary_id'];
        $data['basic'] = $empDetails['employee'][0]['basic'];
        $data['da'] = $empDetails['employee'][0]['da'];
        $data['hra'] = $empDetails['employee'][0]['hra'];
        $data['cea'] = $empDetails['employee'][0]['cea'];
        $data['tpa'] = $empDetails['employee'][0]['tpa'];
        $data['ot_per_hour'] = $empDetails['employee'][0]['ot_per_hour'];
        // GETTING EMPLOYEE DETAILS ENDS HERE.

//        print_r($empDetails);
//        exit();

        $data['title']="Payslip";
        $this->load->view('payslip/employee_payslip',$data);
    }

    public function add()
    {
        //var_dump($_POST); exit();
        if(isset($_POST['attend_employee']))
        {
            $this->form_validation->set_rules('attend_employee','Employee','required');
            $this->form_validation->set_rules('attend_month','Attendance Month','required');
            $this->form_validation->set_rules('attend_year','Attendance Year','required');
            $this->form_validation->set_rules('attendance_days','Attended Days','required');
            $this->form_validation->set_rules('attendance_ot','Attended OT(in Hrs)','required');
            $this->form_validation->set_rules('holidays_days','Attended Holidays','required');
            if($this->form_validation->run()==FALSE)
            {
                $this->session->set_flashdata('error',validation_errors());
                redirect($this->agent->referrer());
            }
            else
            {
                $checkavailability = $this->mdl_attendance->checkattendanceavailability();
                if($checkavailability==0){
                if($this->mdl_attendance->saveattendance())
                {
                    // echo 3333; exit();
                    $this->session->set_flashdata('update','Attendance Details Added Successfully.');
                }
                else
                {
                    //echo 222; exit();
                    $this->session->set_flashdata('error','Attendance Details Failed.');
                }}
                else
                {
                    $this->session->set_flashdata('error','Attendance Already Available');
                }
            }
            redirect('Attendance');
        }

    }

    public function Createpayslip()
    {
        $attnID = encryptor("decrypt", $this->uri->segment(3));
        $EncryptedattnID = $this->uri->segment(3);
        $checkStatus = $this->mdl_attendance->countpayslipstatusbyid($attnID);
        if($checkStatus==1)
        {
            $record = $this->mdl_attendance->savepayslipbyattn($attnID);
            redirect('Attendance/viewpayslip/'.$EncryptedattnID);
        }

        if($checkStatus==0){ redirect('Attendance/viewpayslip/'.$EncryptedattnID); }
    }


    public function getrecord()
    {
        $data['draw']=$this->input->get('draw');
        $start=$this->input->get('start');
        $length=$this->input->get('length');
        $searchstr=$this->input->get('search');
        $orderfield=$this->input->get('order');
        $temp = $this->mdl_attendance->getattendance($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
//      $temp=$this->mdl_employee->getemployee($start,$length,$searchstr['value'],$orderfield['0']['column'],$orderfield['0']['dir']);
        // print_r($temp); exit();
        // echo $temp['data']['count']; exit();
        $data['recordsTotal']=$temp['count'];
        $data['recordsFiltered']=$temp['count'];
        // print_r($data); exit();
        //$data["data"]=array();
        // print_r($temp); exit();
//      print_r($temp['data']); exit();

        $Months = array(
            '1'=>'January',
            '2'=>'February',
            '3'=>'March',
            '4'=>'April',
            '5'=>'May',
            '6'=>'June',
            '7'=>'July',
            '8'=>'August',
            '9'=>'September',
            '10'=>'October',
            '11'=>'November',
            '12'=>'December');

        $ctr=$this->input->get('start')+1;
        $data['data'] = array();
        foreach ($temp['data'] as $row)  {
            $arr=[];
            $arr[]=$ctr;
            $arr[]=$row['staff_name'];
            $arr[]=$row['mobile_no'];
            $arr[]=$Months[$row['attnForMonth']];
            $arr[]=$row['attnForYear'];
            $arr[]=$row['attnDays'].'&nbsp;Days';
            $arr[]=$row['ot_hrs'].'&nbsp;Hrs';
            $arr[]=$row['Holidaydays'].'&nbsp;Days';
            $arr[]=$row['casual_leave'].'&nbsp;Days';
            $arr[]='₹'.$row['loan_amt'];
            $arr[]=$row['attnRemarks'];
            if($row['payslip_created']==0)
            {
                $url="Attendance/Createpayslip/".encryptor('encrypt',$row['attnID']);
                $arr[]="<a href='$url' target='_blank' class='btn_book label label-warning'>Create Payslip</a>";
            }
            if($row['payslip_created']==1)
            {
                $url="Attendance/viewpayslip/".encryptor('encrypt',$row['attnID']);
                $arr[]="<a href='$url' target='_blank' class='btn_book label label-primary'>View Payslip</a>";
            }
            $arr[]="<div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['attnID'])."' class='btn_editrecord' style='display:none;'><i class='fa fa-pencil-square-o'></i></a></div><div class='col-sm-6'><a href='#' refid='".encryptor("encrypt",$row['attnID'])."' class='btn_deleterecord'><i class='fa fa-trash-o'></i></a></div>";
            // $arr[]=$row['attnRemarks'];
            array_push($data['data'],$arr);
            $ctr++;
        }

//        $data['data'] = array('1','jhsdgjgsd','3453453453','5','6','4','5','6','fghfghhg');
//        print_r($data); exit();
        echo json_encode($data);
    }

    public function addpopup()
    {
        //var_dump($_POST); exit;
        $data['title']="Add Attendance";
        //$this->load->model('mdl_employee_type');
        //$data['employee_type']=$this->mdl_employee_type->getemployee_type("","","","","");
        $data['condition']='popup';
        //$data['last_id']=$this->mdl_staff->getLastId();
        $this->load->view('attendance/add_attendance',$data);
    }

    function deleterecord(){
        $attn_id = encryptor("decrypt", $this->input->post('delete'));
        $record = $this->mdl_attendance->deletebyid($attn_id);
        if($record==1) echo "true"; else echo "false";
    }

//    public function edit()
//    {
//        if(isset($_POST['attend_employee']))
//        {
//          //  $this->Mdl_attendance->updateempattendance($_POST);
//        }
//        else
//        {
//            $data['title'] = "Edit Attendance";
//            $attendance_id = encryptor("decrypt", $this->input->get('id'));
//            //$data['form_data'] = $this->Mdl_attendance->getattendancebyid($attendance_id);
//            $this->load->view('Attendance/edit_attendance', $data);
//        }
//    }

}
?>