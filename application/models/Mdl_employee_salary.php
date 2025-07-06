<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_employee_salary extends CI_Model{

    public function save_employee_salary ($post)
    {
        
        if(empty($_POST['staff_id']))
            $staff_id="";
        else
            $staff_id=$_POST['staff_id'];

        if(empty($_POST['basic']))
            $basic="";
        else
            $basic=$_POST['basic'];

        if(empty($_POST['da']))
            $da="";
        else
            $da=$_POST['da'];

        if(empty($_POST['hra']))
            $hra="";
        else
            $hra=$_POST['hra'];

        if(empty($_POST['cea']))
            $cea="";
        else
            $cea=$_POST['cea'];

        if(empty($_POST['tpa']))
            $tpa="";
        else
            $tpa=$_POST['tpa'];

        if(empty($_POST['ot']))
            $ot="";
        else
            $ot=$_POST['ot'];
        
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
         //`staff_id`, `basic`, `da`, `hra`, `cea`, `tpa`, `ot_per_hour`
        $data=array("staff_id"=>$staff_id,"basic"=>$basic,"da"=>$da,"hra"=>$hra,"cea"=>$cea,"tpa"=>$tpa,"ot_per_hour"=>$ot,
            "created_by"=>$user_id,
            "created_datetime"=>$datetime);
        $this->db->insert('employee_salary',$data);
        $lastid=$this->db->insert_id();        
        return $lastid;
    }
    public function getemployee_salary($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`staff_id`, `basic`, `da`, `hra`, `cea`, `tpa`, `ot_per_hour`')
                ->from('employee_salary')
                ->where('is_deleted','0')
                ->get();
            return $query->result_array();
        }
        else
        {

            $arr=array("salary_id","emp_no", "staff_name","basic","da","hra","cea","tpa","ot_per_hour");

            $this->db->select('emp_no,staff_name,`salary_id`, `basic`, `da`, `hra`, `cea`, `tpa`, `ot_per_hour`');
            if(!empty($searchstr))
            {
                $this->db->or_like('staff_name', $searchstr);
                $this->db->or_like('emp_no', $searchstr);
                $this->db->or_like('basic', $searchstr);
                
            }
             $this->db->where('employee_salary.is_deleted','0');
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('employee_salary')->join('staff', 'staff.staff_id = employee_salary.staff_id', 'left')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('employee_salary');
            $this->db->join('staff', 'staff.staff_id = employee_salary.staff_id', 'left');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getemployeesalarybyid($employeeid)
    {
        $query=$this->db->select('`staff_id`, `basic`, `da`, `hra`, `cea`, `tpa`, `ot_per_hour`')
            ->from('employee_salary')
            ->where(array("salary_id"=>$employeeid))
            ->get();
        $record['employee_salary']=$query->result_array();
        return $record;
    }
    public function update_employee_salary($post)
    {
        if(empty($_POST['staff_id']))
            $staff_id="";
        else
            $staff_id=$_POST['staff_id'];

        if(empty($_POST['basic']))
            $basic="";
        else
            $basic=$_POST['basic'];

        if(empty($_POST['da']))
            $da="";
        else
            $da=$_POST['da'];

        if(empty($_POST['hra']))
            $hra="";
        else
            $hra=$_POST['hra'];

        if(empty($_POST['cea']))
            $cea="";
        else
            $cea=$_POST['cea'];

        if(empty($_POST['tpa']))
            $tpa="";
        else
            $tpa=$_POST['tpa'];

        if(empty($_POST['ot']))
            $ot="";
        else
            $ot=$_POST['ot'];
        
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

         //`staff_id`, `basic`, `da`, `hra`, `cea`, `tpa`, `ot_per_hour`
        $data=array("staff_id"=>$staff_id,"basic"=>$basic,"da"=>$da,"hra"=>$hra,"cea"=>$cea,"tpa"=>$tpa,"ot_per_hour"=>$ot,
            "updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['salary_id']);
        $this->db->where('salary_id', encryptor("decrypt",$post['salary_id']));
        $this->db->update('employee_salary',$data);
        return $lastid;
    }
    public function deletebyid($employeeid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('employee_id', $employeeid);
        $this->db->update('tbl_employee',$data);
        return $this->db->affected_rows();
    }
    public function getEmployeeByConsignor($consignor_id)
    {
        $query=$this->db->select('`employee_id`, `employee_name`')
            ->from('tbl_employee')
            ->where(array("consignor_id"=>$consignor_id))
            ->get();
        return $query->result_array();
    }
    public function getmonthlysalary($month)
    {
        $firstday=date('Y-'.$month.'-01');
        $year=date('Y');
        $lastday=date('Y-'.$month.'-t');
        $begin  = new DateTime($firstday);
        $end    = new DateTime($lastday);
        $numberofworkingday = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
        $numberofdayinmonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
        
        $salaryexp=0;
        $qry=$this->db->select('holiday_date')
        ->from('tbl_holidays')
        ->where('MONTH(holiday_date)',$month)
        ->where('YEAR(holiday_date)',$year)
        ->where('is_deleted','0')
        ->get();
        $holiday=$qry->result_array();

        $holidayary=array();
        $holidayarydate=array();
        foreach ($holiday as $row) {
            array_push($holidayary, $row['holiday_date']);

            array_push($holidayarydate,date("d",strtotime($row['holiday_date'])));
            $numberofworkingday--;
        }
        $qry=$this->db->select('working_day_date')
        ->from('tbl_working_day')
        ->where('MONTH(working_day_date)',$month)
        ->where('YEAR(working_day_date)',$year)
        ->where('is_deleted','0')
        ->get();
        $workingday=$qry->result_array();
        $workingdayary=array();
        foreach ($workingday as $row) {
            array_push($workingdayary, $row['working_day_date']);
        }

        // 31

        //SELECT * FROM Project WHERE MONTH(DueDate) = 1 AND YEAR(DueDate) = 2010
        //SELECT * FROM Project WHERE MONTH(DueDate) = 1 AND YEAR(DueDate) = 2010

        //SELECT * FROM `devicelogs_10_2018` WHERE DATE(LogDate) NOT in('2018-10-07','2018-10-14','2018-10-21','2018-10-28') AND UserId=25


        while ($begin <= $end) // Loop will work begin to the end date 
        {
            if($begin->format("D") == "Sun") //Check that the day is Sunday here
            {
                if (!in_array($begin->format("Y-m-d"), $workingdayary))
                {
                    array_push($holidayarydate,$begin->format("d"));
                    array_push($holidayary,$begin->format("Y-m-d"));
                    $numberofworkingday--;

                }
                
            }
            $begin->modify('+1 day');
        }

        $this->db->select('staff.staff_id,emp_no,staff_name,`salary_id`, `basic`, `da`, `hra`, `cea`, `tpa`, `ot_per_hour`');
            $this->db->from('employee_salary');
            $this->db->join('staff', 'staff.staff_id = employee_salary.staff_id', 'left');
            $query=$this->db->get();
        $result=$query->result_array();

        $otamt=50;

        foreach ($result as $row) {
            $staff_id=$row['staff_id'];
            $otearn=0;
            $othour=0;
            $lt=0;
            $negitiveearn=0;
            $salary=$row['basic']+$row['da']+$row['hra']+$row['cea']+$row['tpa'];
            $perday=$salary/30;
            $perhour=$perday/9;
            $str=implode("','", $holidayary);
            $stra="'".$str."'";
            $presentday=0;
            $absent=0;
            $prevday="01";
            $crday="01";
            if(!empty($staff_id))
            {
                $qury=$this->db->query("SELECT min(LogDate)as intime, max(LogDate) as outtime FROM `devicelogs_".$month."_2019` WHERE DATE(LogDate) and UserId=".$staff_id." group by DATE(LogDate)");
                echo "<table border=1>";
                echo "<tr>";
                for($i=1;$i<=$numberofdayinmonth;$i++)
                {
                    
                    echo "<th colspan='2'>".$i."/".$month."</th>";
                    
                }
                echo "</tr>";
                echo "<tr>";
                $absentctr=0;
                $attendance=$qury->result_array();
                foreach ($attendance as $attrow) {
                    $to_time = strtotime($attrow['outtime']);
                    $day = date('d', $to_time);
                    $dt = date('Y-m-d', $to_time);
                    $from_time = strtotime($attrow['intime']);
                    $dateDiff = intval((strtotime($attrow['outtime'])-strtotime($attrow['intime']))/60);
                    $hours = intval($dateDiff/60);
                    $minutes = $dateDiff%60;
                    $arr[]=$hours.":".$minutes;
                    $status=false;
                    
                    if((int)$day>(int)$prevday)
                    {
                        while ($prevday < $day) {
                            if(in_array($prevday,$holidayarydate ))
                            {
                                echo "<td colspan='2'>H</td>";
                            }
                            else
                            {
                                $status=true;
                                echo "<td colspan='2'>ab</td>";
                                $absentctr++;
                            }
                            $prevday++;
                        }
                    }

                        
                    echo "<td>";
                    if(in_array($day,$holidayarydate ))
                    {
                        echo "H";
                    }
                    $inary=explode(" ",$attrow['intime']);
                    echo $inary[1]."</td>";
                    echo "<td>";
                    if(in_array($day,$holidayarydate ))
                    {
                        echo "H";
                    }
                    $outary=explode(" ",$attrow['outtime']);
                    echo $outary[1]."</td>";
                    $prevday=$day+1;
                    if(in_array($dt,$holidayary ))
                    {
                        $othour+=$hours*60+$minutes;
                    }
                    else if($hours<9)
                    {
                        if($hours<1)
                        {
                            $presentday--;
                        }
                        if($minutes<30)
                        {
                            if($hours>1)
                            {
                                $totalworkinhour=9-$hours;
                                $negitiveearn+=$perhour*$totalworkinhour;
                            }
                            
                        }
                        else
                        {
                            $totalworkinhour=9-($hours+1);
                            $negitiveearn+=$perhour*$totalworkinhour;
                        }
                    }
                    else if($hours>=9)
                    {
                        if($hours==9)
                        {
                            if($minutes>=30)
                            {
                               $othour+=(($hours-9)*60)+$minutes; 
                            }
                        }
                        else
                            $othour+=(($hours-9)*60)+$minutes;
                        
                    }
                    $presentday++;
                }
                for ($i=$prevday; $i <=$numberofdayinmonth ; $i++) { 
                    echo "<td colspan='2'>ab</td>";
                    $absentctr++;
                }
                echo "<tr/>";
                $absent=$numberofworkingday-$presentday;


                
                $totalothours = intdiv($othour, 60);
                if($othour % 60>=30)
                    $totalothours++;
                $empsalary=$salary-($perday*$absentctr);
                $empsalary=$empsalary-$negitiveearn;
                $otsalary=$totalothours*50;
                
                
            }
            $presentday=$numberofworkingday-$absentctr;
            echo "</table>";
            echo $row['staff_id']."Name:=".$row['staff_name']." present=".$presentday." absent=".$absentctr." OT=".$totalothours." salary=".$empsalary." otsalary=".$otsalary."<br/><br/><br/>";
            //echo $row['staff_id']."Name:=".$row['staff_name']." OT=".$totalothours." <br/><br/><br/>";
            $salaryexp+=$empsalary+$otsalary;  
        }
        echo $salaryexp;  
    }
}
?>