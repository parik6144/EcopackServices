<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_followup extends CI_Model{

    public function savefollowup($post)
    {
        
        if(empty($_POST['followup_date']))
            $followup_date="";
        else
            $followup_date=date("Y-m-d", strtotime($_POST['followup_date']));

        if(empty($_POST['dlr_status']))
            $dlr_status="";
        else
            $dlr_status=$_POST['dlr_status'];

        if(empty($_POST['location']))
            $location="";
        else
            $location=$_POST['location'];
        if(isset($_POST['consignment_id'])){
            if(empty($_POST['consignment_id']))
                $consignment_id="";
            else
                $consignment_id=encryptor("decrypt",$_POST['consignment_id']);
        }
        
        if(empty($_POST['remarks']))
            $remarks="";
        else
            $remarks=$_POST['remarks'];

        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        
        $data=array("consignment_id"=>$consignment_id,"vehicle_location"=>$location,"followup_date"=>$followup_date,"created_by"=>$user_id,"created_datetime"=>$datetime,"delevery_status"=>$dlr_status,"remarks"=>$remarks);
        if(!isset($_POST['followup_id']))
            $this->db->insert('tbl_vehicle_followup',$data);
        else{
            $followup_id=$_POST['followup_id'];
            $this->db->where('followup_id',$followup_id);
            $this->db->update('tbl_vehicle_followup',$data);
        }
            
        if($dlr_status=="1")
        {
            $data=array("delevery_status"=>1,"delevery_date"=>$followup_date);
            $this->db->where('consignment_id',$consignment_id);
            $this->db->update('tbl_consignment',$data);
        }
        return $consignment_id;
        
    }
    public function getfollowupbyid($consignmentid)
    {
        $query=$this->db->select('followup_id,vehicle_location,followup_date,remarks,delevery_status')
                ->from('tbl_vehicle_followup')
                ->where(array('consignment_id'=>$consignmentid))
                ->get();
                return $query->result_array();
    }
    public function getconsignment($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        $arr=array("consignment_no", "consignment_date", "consignor_name", "consignee_name", "bill_type", "vehicle_inward_no","tbl_consignment.driver_name","consignment_status");
        $this->db->select('consignment_id,consignment_no, consignment_date, consignor_name, consignee_name, bill_type, vehicle_inward_no,tbl_consignment.driver_name,tbl_vehicle_inward.mobile_no');
        if(!empty($searchstr))
        {
            $this->db->or_like('consignment_no', $searchstr);
            $this->db->or_like('consignment_date', $searchstr);
            $this->db->or_like('consignor_name', $searchstr);
            $this->db->or_like('consignee_name', $searchstr);
            $this->db->or_like('tbl_consignment.driver_name', $searchstr);
            $this->db->or_like('tbl_vehicle_inward.mobile_no', $searchstr);
        }
        $this->db->where('delevery_status',0);
        $tempdb = clone $this->db;
        $this->db->order_by($arr[$col],$type);
        $num_rows = $tempdb->from('tbl_consignment')
        ->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_consignment.consignor_id', 'left')
            ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_consignment.consignee_id', 'left')
            ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_consignment.vehicle_id', 'left')
            ->count_all_results();
        if($length>0)
            $this->db->limit($length, $start);
        $this->db->from('tbl_consignment');
        $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_consignment.consignor_id', 'left');
        $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_consignment.consignee_id', 'left');
        $this->db->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_consignment.vehicle_id', 'left');
        $this->db->order_by('consignment_no','desc');
        $query=$this->db->get();
        $response['count']=$num_rows;
        $response['data']=$query->result_array();
        //echo $this->db->last_query();
        //exit;
        return $response;
    }
    public function getconsignmentbyid($consignmentid)
    {
        $query=$this->db->select('consignment_id,`consignment_no`, `consignment_date`, `source_id`, `destination_id`, `consignor_id`, `consignee_id`, `bill_type`, `consignment_value`, `d_c_no`, `vehicle_id`, `way_bill_no`, `driver_name`, `advance`, `due`')
            ->from('tbl_consignment')
            ->where(array("consignment_id"=>$consignmentid))
            ->get();
        $record['consignment']=$query->row();

        $query=$this->db->select('`employee_id`, `amount`')
            ->from('tbl_consignment_details')
            ->where(array("consignment_id"=>$consignmentid))
            ->get();
        $record['consignment_details']=$query->result_array();

         $query=$this->db->select('`item_name`, `qty`')
            ->from('tbl_consignment_item')
            ->where(array("consignment_id"=>$consignmentid))
            ->get();
        $record['consignment_item']=$query->result_array();

        $query=$this->db->select('`item_id`, `qty`')
            ->from('tbl_consignment_stock_item')
            ->where(array("consignment_id"=>$consignmentid))
            ->get();
        $record['consignment_stock_item']=$query->result_array();
        return $record;
    }
    public function getReport()
    {

        $date_from=date("Y-m-d", strtotime($_POST['date_from']));
        $date_to=date("Y-m-d", strtotime($_POST['date_to']));
        $dlrdate=date("Y-m-d",strtotime ( '-2 day' , strtotime ( $_POST['date_to'] ) )) ;
        $consignee_id=$_POST['consignee_name'];

        //var_dump($row);
        //exit;
        //$maxday="SELECT count(*) as total FROM `tbl_vehicle_followup` group by consignment_id  order by total DESC limit 1";


        //$lrno="select consignment_id,consignment_no,consignment_date, from tbl_consignment WHERE  (consignment_date BETWEEN '".$date_from."' AND '".$date_to."') and delevery_status=0 and delevery_date>='".$dlrdate."'";


        $this->db->select('tbl_consignment.consignment_id,consignment_no,invoice_status, consignment_date, vehicle_inward_no,tbl_consignment.driver_name,tbl_vehicle_inward.mobile_no,vehicle_type_id,sum(qty) as qty');
        $this->db->where("consignment_date BETWEEN '".$date_from."' AND '".$date_to."'");
        $this->db->where('tbl_consignment.consignee_id=', $consignee_id);
        $this->db->from('tbl_consignment');
        $this->db->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_consignment.vehicle_id', 'left');
        $this->db->join('tbl_consignment_stock_item', 'tbl_consignment_stock_item.consignment_id = tbl_consignment.consignment_id', 'left');
        $this->db->join('tbl_invoice', 'tbl_invoice.invoice_id = tbl_consignment.invoice_id', 'left');
        $this->db->group_by(array('consignment_date','vehicle_id' ));
        $query=$this->db->get();

        $arr=$query->result_array();
        $response=array();
        $response["data"]=array();
        $max=0;
        
        foreach ($arr as $row) {
            $temp=[];
            $temp['consignment_no']=$row['consignment_no'];
            $temp['consignment_date']=$row['consignment_date'];
            $temp['vehicle_inward_no']=$row['vehicle_inward_no'];
            $temp['mobile_no']=$row['mobile_no'];
            $temp['vehicle_type_id']=$row['vehicle_type_id'];
            $temp['qty']=$row['qty'];
            $temp['invoice_status']=$row['invoice_status'];
            $temp['follow_up']=$this->getfollowupbyid($row['consignment_id']);
            if(sizeof($temp['follow_up'])>$max)
                $max=sizeof($temp['follow_up']);
            array_push($response['data'], $temp);
        }
        $response["count"]=$max;
        return $response;
       
    }
	public function getreportByPlace()
	{
		
		$destination_id=$_POST['place_id'];
		$date=date("Y-m-d");
		$days_ago = date('Y-m-d', strtotime('-4 days', strtotime($date)));
		
		$query=$this->db->query("select `consignment_no`,consignment_id, consignment_date, `vehicle_inward_no`,`driver_name`, `mobile_no`, `vehicle_type_id`, `vehicle_location`, delevery_status from(SELECT `consignment_no`,tbl_consignment.consignment_id, max(followup_date) as consignment_date, `vehicle_inward_no`, `tbl_vehicle_inward`.`driver_name`, `tbl_vehicle_inward`.`mobile_no`, `vehicle_type_id`, `vehicle_location`, max(`tbl_vehicle_followup`.`delevery_status`) as delevery_status FROM `tbl_consignment` LEFT JOIN `tbl_vehicle_inward` ON `tbl_vehicle_inward`.`vehicle_inward_id` = `tbl_consignment`.`vehicle_id` LEFT JOIN `tbl_vehicle_followup` ON `tbl_vehicle_followup`.`consignment_id` = `tbl_consignment`.`consignment_id` WHERE `destination_id` = '".$destination_id."' and tbl_consignment.consignment_status='0' GROUP BY vehicle_id)as  abc where consignment_date>'".$days_ago."' order by consignment_no");
		return $query->result_array();
	}
   
}
?>