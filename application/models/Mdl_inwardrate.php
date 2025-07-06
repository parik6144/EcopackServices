<?php
class Mdl_inwardrate extends CI_Model{

    public function saveinwardrate($post)
    {
    	if(empty($_POST['consignor_id']))
            $consignor_id="";
        else
            $consignor_id=$_POST['consignor_id'];
        if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];

        if(empty($_POST['vehicle_type_id']))
            $vehicle_type_id="";
        else
            $vehicle_type_id=$_POST['vehicle_type_id'];

        if(empty($_POST['owner_price']))
            $owner_price="";
        else
            $owner_price=$_POST['owner_price'];

        if(empty($_POST['driver_price']))
            $driver_price="";
        else
            $driver_price=$_POST['driver_price'];

        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("consignor_id"=>$consignor_id,"consignee_id"=>$consignee_id,"vehicle_type_id"=>$vehicle_type_id,"owner_price"=>$owner_price,"driver_price"=>$driver_price,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_inward_rate',$data);
        $inward_rate_id=$this->db->insert_id();
        $data=array();
        for($i=0;$i<sizeof($_POST['employee_id']);$i++)
        {
    		$temp = array('consignor_id' => $consignor_id,'consignee_id' => $consignee_id,'vehicle_type_id' => $vehicle_type_id,'employee_id' => $_POST['employee_id'][$i],'amount' => $_POST['employee_rate'][$i],'rate_type' => $_POST['rate_type'][$i]);
    		array_push($data,$temp);
        }
        $this->db->insert_batch('tbl_inward_employee_rate', $data);        
        return $inward_id;
    }
    public function updateinwardrate($post)
    {
        if(empty($_POST['consignor_id']))
            $consignor_id="";
        else
            $consignor_id=$_POST['consignor_id'];
        if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];

        if(empty($_POST['vehicle_type_id']))
            $vehicle_type_id="";
        else
            $vehicle_type_id=$_POST['vehicle_type_id'];

        if(empty($_POST['owner_price']))
            $owner_price="";
        else
            $owner_price=$_POST['owner_price'];

        if(empty($_POST['driver_price']))
            $driver_price="";
        else
            $driver_price=$_POST['driver_price'];

        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("consignor_id"=>$consignor_id,"consignee_id"=>$consignee_id,"vehicle_type_id"=>$vehicle_type_id,"owner_price"=>$owner_price,"driver_price"=>$driver_price,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $rate_id=encryptor('decrypt',$_POST['rate_id']);
        $this->db->where('rate_id',$rate_id);
        $this->db->update('tbl_inward_rate',$data);

        $this->db->where(array('consignee_id' => $consignee_id,'consignor_id' =>$consignor_id,'vehicle_type_id' => $vehicle_type_id ));
        $this->db->delete('tbl_inward_employee_rate');
        $data=array();
        for($i=0;$i<sizeof($_POST['employee_id']);$i++)
        {
            $temp = array('consignor_id' => $consignor_id,'consignee_id' => $consignee_id,'vehicle_type_id' => $vehicle_type_id,'employee_id' => $_POST['employee_id'][$i],'amount' => $_POST['employee_rate'][$i],'rate_type' => $_POST['rate_type'][$i]);
            array_push($data,$temp);
        }
        $this->db->insert_batch('tbl_inward_employee_rate', $data);        
        return $inward_id;
    }
    public function getinwardrate($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        $arr=array("rate_id", "consignor_name", "consignee_name", "vehicle_type", "owner_price", "driver_price");
        if($start=='' && $length=='' && $searchstr=='')
        {

            $query=$this->db->select('rate_id, consignor_name, consignee_name, vehicle_type, owner_price, driver_price')
                ->from('tbl_inward')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('rate_id, consignor_name, consignee_name, vehicle_type, owner_price, driver_price');
            if(!empty($searchstr))
            {
                $this->db->or_like('consignor_name', $searchstr);
                $this->db->or_like('consignee_name', $searchstr);
                $this->db->or_like('vehicle_type', $searchstr);
                $this->db->or_like('owner_price', $searchstr);
                $this->db->or_like('driver_price', $searchstr);

            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_inward_rate')
            ->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_inward_rate.consignor_id', 'left')
            ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_inward_rate.consignee_id', 'left')
            ->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id = tbl_inward_rate.vehicle_type_id', 'left')
            ->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_inward_rate');
            $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_inward_rate.consignor_id', 'left');
            $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_inward_rate.consignee_id', 'left');
            $this->db->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id = tbl_inward_rate.vehicle_type_id', 'left');
            //$this->db->order_by('vehicle_inward_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getinwardratebyid($inward_id)
    {
    	$id=encryptor("decrypt",$inward_id);
    	$query=$this->db->select('`rate_id`, `consignor_id`, `consignee_id`, `vehicle_type_id`')
                ->from('tbl_inward_rate')
                ->where('rate_id',$id)
                ->get();
            $response=$query->row();
            return $response;
    }
    public function getprice($consignor_id,$consignee_id,$vehicle_type_id="0")
    {
        $query=$this->db->select('driver_price,owner_price')
        ->from('tbl_inward_rate')
        ->where(array('consignor_id' =>$consignor_id ,'consignee_id' =>$consignee_id,'vehicle_type_id' =>$vehicle_type_id ))
        ->get();
        $response['vehicle_price']=$query->result_array();
        $query=$this->db->select('amount,rate_type')
        ->from('tbl_inward_employee_rate')
        ->where(array('consignor_id' =>$consignor_id ,'consignee_id' =>$consignee_id,'vehicle_type_id' =>$vehicle_type_id ))
        ->get();
        $response['employee_price']=$query->result_array();
        return $response;
    }
    public function deletebyid($rate_id)
    {
        $query=$this->db->select('consignor_id,consignee_id,vehicle_type_id')
        ->from('tbl_inward_rate')
        ->where(array('rate_id' => $rate_id ))
        ->get();
        $row=$query->row();
        $this->db->where(array('consignee_id' => $row->consignee_id,'consignor_id' =>$row->consignor_id,'vehicle_type_id' => $row->vehicle_type_id ));
        $this->db->delete('tbl_inward_employee_rate');
        $this->db->where(array('rate_id' => $rate_id ));
        $this->db->delete('tbl_inward_rate');

        return $this->db->affected_rows();
    }
    public function getreportByVehicleId()
    {
        $date_from=date("Y-m-d", strtotime($_POST['date_from']));
        $date_to=date("Y-m-d", strtotime($_POST['date_to']));
        $vehicle_id=$_POST['vehicle_inward_id'];
        $vehicle_type_id=$_POST['vehicle_type_id'];
       
        $query=$this->db->query("select distinct(inward_id) as consignment_id, inward_date,consignor_name,consignee_name,tbl_inward_rate.driver_price from tbl_inward left JOIN tbl_vehicle_inward on tbl_vehicle_inward.vehicle_inward_id=tbl_inward.vehicle_id left JOIN tbl_vehicle_type on tbl_vehicle_type.vehicle_type_id=tbl_vehicle_inward.vehicle_type_id  left JOIN tbl_inward_rate on tbl_inward_rate.consignor_id=tbl_inward.source_id and tbl_inward_rate.consignee_id=tbl_inward.destiantion_id and tbl_inward_rate.vehicle_type_id=tbl_vehicle_type.vehicle_type_id LEFT JOIN tbl_consignee on tbl_consignee.consignee_id=tbl_inward.destiantion_id LEFT JOIN tbl_consignor on tbl_consignor.consignor_id=tbl_inward.source_id
WHERE  tbl_inward.vehicle_id=".$vehicle_id." and inward_date>='".$date_from."' and inward_date<='".$date_to."' group by inward_id


union select distinct(consignment_id),consignment_date as inward_date,consignor_name,consignee_name,tbl_outward_rate.driver_price from tbl_consignment left JOIN tbl_vehicle_inward on tbl_vehicle_inward.vehicle_inward_id=tbl_consignment.vehicle_id left JOIN tbl_vehicle_type on tbl_vehicle_type.vehicle_type_id=tbl_vehicle_inward.vehicle_type_id left JOIN tbl_outward_rate on tbl_outward_rate.consignee_id=tbl_consignment.consignee_id and tbl_outward_rate.vehicle_type_id=tbl_vehicle_type.vehicle_type_id LEFT JOIN tbl_consignee on tbl_consignee.consignee_id=tbl_consignment.consignee_id LEFT JOIN tbl_consignor on tbl_consignor.consignor_id=tbl_consignment.consignor_id
WHERE tbl_consignment.vehicle_id=".$vehicle_id." and consignment_date>='".$date_from."' and consignment_date<='".$date_to."' and tbl_consignment.bill_type<>2 group by consignment_id order by inward_date");


        return $query->result_array();
    }

    public function getreportByOwnerId()
    {
        $date_from=date("Y-m-d", strtotime($_POST['date_from']));
        $date_to=date("Y-m-d", strtotime($_POST['date_to']));
        $owner_id=$_POST['owner_id'];
        //$vehicle_type_id=$_POST['vehicle_type_id'];
        $vehicle_id=$_POST['vehicle_id'];
        $condition="";
        if($vehicle_id!="all")
            $condition.=" and tbl_inward.vehicle_id=".$vehicle_id;

        $conditionnew="";
        if($vehicle_id!="all")
            $conditionnew.=" and tbl_consignment.vehicle_id=".$vehicle_id;

        $conditiontemp="";
        if($vehicle_id!="all")
            $conditiontemp.=" and tbl_vehicle_expense.vehicle_id=".$vehicle_id;

         $conditiondiesel="";
        if($vehicle_id!="all")
            $conditiondiesel.=" and diesel_expense.vehicle_id=".$vehicle_id;
       
        $query=$this->db->query("select distinct(inward_id) as consignment_id, inward_date,consignor_name,consignee_name,tbl_inward_rate.owner_price,vehicle_inward_no,'0' as type from tbl_inward left JOIN tbl_vehicle_inward on tbl_vehicle_inward.vehicle_inward_id=tbl_inward.vehicle_id left JOIN tbl_vehicle_type on tbl_vehicle_type.vehicle_type_id=tbl_vehicle_inward.vehicle_type_id LEFT JOIN tbl_inward_owner on tbl_inward_owner.owner_id=tbl_vehicle_inward.owner_id left JOIN tbl_inward_rate on tbl_inward_rate.consignor_id=tbl_inward.source_id and tbl_inward_rate.consignee_id=tbl_inward.destiantion_id and tbl_inward_rate.vehicle_type_id=tbl_vehicle_type.vehicle_type_id LEFT JOIN tbl_consignee on tbl_consignee.consignee_id=tbl_inward.destiantion_id LEFT JOIN tbl_consignor on tbl_consignor.consignor_id=tbl_inward.source_id
WHERE  tbl_inward_owner.owner_id=".$owner_id." and inward_date>='".$date_from."' and inward_date<='".$date_to."' ".$condition." group by inward_id


union select distinct(consignment_id),consignment_date as inward_date,consignor_name,consignee_name,tbl_outward_rate.advance as owner_price,vehicle_inward_no, '0' as type from tbl_consignment left JOIN tbl_vehicle_inward on tbl_vehicle_inward.vehicle_inward_id=tbl_consignment.vehicle_id left JOIN tbl_vehicle_type on tbl_vehicle_type.vehicle_type_id=tbl_vehicle_inward.vehicle_type_id left JOIN tbl_inward_owner on tbl_inward_owner.owner_id=tbl_vehicle_inward.owner_id left JOIN tbl_outward_rate on tbl_outward_rate.consignee_id=tbl_consignment.consignee_id and tbl_outward_rate.vehicle_type_id=tbl_vehicle_type.vehicle_type_id LEFT JOIN tbl_consignee on tbl_consignee.consignee_id=tbl_consignment.consignee_id LEFT JOIN tbl_consignor on tbl_consignor.consignor_id=tbl_consignment.consignor_id
WHERE tbl_inward_owner.owner_id=".$owner_id." and consignment_date>='".$date_from."' and consignment_date<='".$date_to."' and tbl_consignment.bill_type<>2 ".$conditionnew." and tbl_consignment.is_dc=0 group by consignment_id


union select '' as consignment_id, payment_date as inward_date, expense_head_name as consignor_name, tbl_payment_booking.remarks as consignee_name, amount as owner_price, tbl_vehicle_inward.vehicle_inward_no, '1' as type from tbl_vehicle_expense
    LEFT JOIN tbl_payment_booking on tbl_payment_booking.booking_id=tbl_vehicle_expense.booking_id
    LEFT JOIN tbl_vehicle_inward on tbl_vehicle_inward.vehicle_inward_id=tbl_vehicle_expense.vehicle_id
    LEFT JOIN tbl_inward_owner on tbl_inward_owner.owner_id=tbl_vehicle_inward.owner_id
    LEFT JOIN tbl_expense_head on tbl_expense_head.expense_head_id=tbl_payment_booking.expense_head_id
    WHERE tbl_inward_owner.owner_id=".$owner_id." and payment_date>='".$date_from."' and payment_date<='".$date_to."' ".$conditiontemp."

    union select '' as consignment_id,expense_date as inward_date, 'Diesel purchased' as consignor_name, tbl_vehicle_inward.vehicle_inward_no as consignee_name, amount as owner_price,
    tbl_vehicle_inward.vehicle_inward_no, '1' as type from diesel_expense
    LEFT JOIN tbl_vehicle_inward on tbl_vehicle_inward.vehicle_inward_id=diesel_expense.vehicle_id
    LEFT JOIN tbl_inward_owner on tbl_inward_owner.owner_id=tbl_vehicle_inward.owner_id
    WHERE tbl_inward_owner.owner_id=".$owner_id." and expense_date>='".$date_from."' and expense_date<='".$date_to."' ".$conditiondiesel."
 order by inward_date asc ");
        return $query->result_array();
    }

    public function getreportByEmployeeId()
    {
        $date_from=date("Y-m-d", strtotime($_POST['date_from']));
        $date_to=date("Y-m-d", strtotime($_POST['date_to']));
        $employee_id=$_POST['employee_id'];
        if($_POST['employee_type']=="inward_employee")
        {
           $query=$this->db->query("select distinct(tbl_inward.inward_id) as consignment_id, inward_date,consignor_name,consignee_name,tbl_inward_employee_rate.amount,rate_type,tbl_inward_details.qty from tbl_inward left JOIN tbl_vehicle_inward on tbl_vehicle_inward.vehicle_inward_id=tbl_inward.vehicle_id left JOIN tbl_vehicle_type on tbl_vehicle_type.vehicle_type_id=tbl_vehicle_inward.vehicle_type_id
left join tbl_inward_loaded_by on tbl_inward_loaded_by.inward_id=tbl_inward.inward_id
left join tbl_inward_details on tbl_inward_details.inward_id=tbl_inward.inward_id
  left JOIN tbl_inward_employee_rate on tbl_inward_employee_rate.consignor_id=tbl_inward.source_id and tbl_inward_employee_rate.consignee_id=tbl_inward.destiantion_id and tbl_inward_employee_rate.employee_id=tbl_inward_loaded_by.employee_id and tbl_inward_employee_rate.vehicle_type_id=tbl_vehicle_type.vehicle_type_id LEFT JOIN tbl_consignee on tbl_consignee.consignee_id=tbl_inward.destiantion_id LEFT JOIN tbl_consignor on tbl_consignor.consignor_id=tbl_inward.source_id
WHERE  tbl_inward_loaded_by.employee_id=".$employee_id." and inward_date>='".$date_from."' and inward_date<='".$date_to."' group by tbl_inward.inward_id"); 
        }

        
return $query->result_array();

    }
}
?>
