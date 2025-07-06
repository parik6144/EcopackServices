<?php
class Mdl_inward extends CI_Model{

    public function saveinward($post)
    {
        //echo "<pre>";
        //print_r($post); exit();

        $date1="2020-03-31";
        $curdate=date('Y-m-d');
        $inward_date=$_POST['inward_date'];
        if(strtotime($date1)< strtotime($inward_date))
        {
            $sql="SELECT inward_id, inward_no as inward_no FROM `tbl_inward` WHERE `inward_date` > '2020-05-19' AND `inward_id`=(SELECT MAX(`inward_id`) FROM `tbl_inward`)";
            $query=$this->db->query($sql);
//             $qry=$this->db->select('max(inward_no) as inward_no')
//                 ->from('tbl_inward')
//                 ->where('inward_date >',"2020-05-19")
//                 ->where('inward_id >',"3600")
//                 ->get();
//          echo $this->db->last_query(); exit();
            $row=$query->row();
            //echo $row->inward_no; exit();
            if(is_null($row->inward_no) || $row->inward_no<=0){
                $inward_no = "1";
            }
            else
            {
                $inward_no = $row->inward_no+1;
            }
        }
        //echo $inward_no; exit();
       
    	if(empty($_POST['inward_date']))
            $inward_date="";
        else
            $inward_date=date("Y-m-d", strtotime($_POST['inward_date']));
        if(empty($_POST['consignor_name']))
            $source_id="";
        else
            $source_id=$_POST['consignor_name'];

        if(empty($_POST['consignee_name']))
            $destiantion_id=""; else $destiantion_id=$_POST['consignee_name'];

        if(empty($_POST['vehicle_id']))
            $vehicle_id="";
        else
            $vehicle_id=$_POST['vehicle_id'];
        if(empty($_POST['owner_id']))
            $owner_id="";
        else
            $owner_id=$_POST['owner_id'];

        if(empty($_POST['driver_rate']))
            $driver_charge="";
        else
            $driver_charge=$_POST['driver_rate'];

        if(empty($_POST['owner_rate']))
            $owner_charge="";
        else
            $owner_charge=$_POST['owner_rate'];

        if(empty($_POST['gatepass_no'])) $gatepass_no=""; else $gatepass_no=$_POST['gatepass_no'];

        $inward_type=$_POST['inward_type'];

        if(empty($_POST['rent_consignee_id']))
            $rent_consignee_id="";
        else
            $rent_consignee_id=$_POST['rent_consignee_id'];

        if(empty($_POST['warehouse_id']))
            $warehouse_id="";
        else
            $warehouse_id=$_POST['warehouse_id'];

        if(empty($_POST['warehouse_id']))
            $warehouse_id="";
        else
            $warehouse_id=$_POST['warehouse_id'];

        if(empty($_POST['consignment_id']))
            $consignment_id="";
        else
            $consignment_id=$_POST['consignment_id'];

        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        //$data=array("inward_date"=>$inward_date,"source_id"=>$source_id,"destiantion_id"=>$destiantion_id,"rent_consignee_id"=>$rent_consignee_id,"vehicle_id"=>$vehicle_id,"owner_id"=>$owner_id,"driver_charge"=>$driver_charge,"owner_charge"=>$owner_charge,"created_by"=>$user_id,"created_datetime"=>$datetime,"gatepass_no"=>$gatepass_no,"inward_type"=>$inward_type,"inward_warehouse_id"=>$warehouse_id,"consignment_id"=>$consignment_id);
        
        $data=array("inward_no"=>$inward_no,"inward_date"=>$inward_date,"source_id"=>$source_id,"destiantion_id"=>$destiantion_id,"rent_consignee_id"=>$rent_consignee_id,"vehicle_id"=>$vehicle_id,"owner_id"=>$owner_id,"driver_charge"=>$driver_charge,"owner_charge"=>$owner_charge,"created_by"=>$user_id,"created_datetime"=>$datetime,"gatepass_no"=>$gatepass_no,"inward_type"=>$inward_type,"inward_warehouse_id"=>$warehouse_id,"consignment_id"=>$consignment_id);
        //print_r($data); exit();
        $this->db->insert('tbl_inward',$data);
        $inward_id=$this->db->insert_id();
        $data=array();
        $qty=0;
        for($i=0;$i<sizeof($_POST['qty']);$i++)
        {
        	if($_POST['qty'][$i]>0)
        	{
                $qty+=$_POST['qty'][$i];
                if($inward_type=="0")
        		  $temp = array('inward_id' => $inward_id,'item_id' => $_POST['itemName'][$i],'qty' => $_POST['qty'][$i]);
                else
                    $temp = array('inward_id' => $inward_id,'item_id' => $_POST['itemName'][$i],'qty' => $_POST['qty'][$i],'warehouse_id'=>$warehouse_id,"consignment_id"=>$consignment_id);
        		array_push($data,$temp);
        	}
        }

        if(sizeof($data)>0){
            if($inward_type=="0") {
              $this->db->insert_batch('tbl_inward_details', $data); }
            else {
            $this->db->insert_batch('tbl_inward_rent_item', $data); }

        }
        // Inserting Barcodes starts here.
        $barcodes=(json_decode($_POST['itemsbarcode'],true));
        for($i=0;$i<sizeof($_POST['itemName']);$i++)
        {
            if(!empty($_POST['itemName'][$i]))
            {
                // echo sizeof($_POST['item_barcode']); exit();
                for($j=0; $j<sizeof($barcodes[$_POST['itemName'][$i]]); $j++)
                {
                    // CHECKING AVAILABILITY STARTS HERE.
                    $dataBarcode = array("item_id" => $_POST['itemName'][$i], "barcode_no" => $barcodes[$_POST['itemName'][$i]][$j], "inward_no" => $inward_id,"CreateDatetime"=>date('Y-m-d H:i:s'));
                    $this->db->insert('tbl_item_inward_barcodes', $dataBarcode);
                    //echo $this->db->last_query(); exit();
                    // CHECKING AVAILABILITY ENDS HERE.
                }
            }
        }
        // Inserting Barcodes ends here.
        if(isset($_POST['loaded_by']))
        {
            $data=array();
            for($i=0;$i<sizeof($_POST['loaded_by']);$i++)
            {
                if($_POST['loaded_by_rate_type'][$i]=="0")
                    $loaded_amount=$_POST['loaded_by_rate'][$i];
                else
                    $loaded_amount=$_POST['loaded_by_rate'][$i]*$qty;
                $temp = array('inward_id' => $inward_id,'employee_id' => $_POST['loaded_by'][$i],'loaded_amount' => $loaded_amount);
                array_push($data,$temp);
            }
            $this->db->insert_batch('tbl_inward_loaded_by', $data);

        }
        if(isset($_POST['loaded_staff_id']))
        {
            $data=array();
            for($i=0;$i<sizeof($_POST['loaded_staff_id']);$i++)
            {
                if(!empty($_POST['loaded_staff_id'][$i]))
                {
                    $temp = array('inward_id' => $inward_id,'staff_id' => $_POST['loaded_staff_id'][$i]);
                    array_push($data,$temp);
                }
                
            }
            if(sizeof($data)>0)
                $this->db->insert_batch('tbl_inward_loaded_by_employee', $data);

        }
        return $inward_id;
    }
    
    
    // public function getinward($start="",$length="",$searchstr="",$column,$type)
    // {
    //     $col = (int)$column;
    //     $arr=array("inward_id", "inward_date", "consignor_name", "consignee_name", "vehicle_inward_no", "driver_name", "mobile_no");
    //     if($start=='' && $length=='' && $searchstr=='')
    //     {

    //         $query=$this->db->select('`inward_id`, `inward_date`, `source_id`, `destiantion_id`, `vehicle_id`, `owner_id`, `driver_charge`')
    //             ->from('tbl_inward')
    //             ->get();
    //         return $query->result_array();
    //     }
    //     else
    //     {
    //         $this->db->select('inward_id, inward_date, consignor_name, consignee_name, vehicle_inward_no, driver_name, tbl_vehicle_inward.mobile_no');
    //         if(!empty($searchstr))
    //         {
    //             $this->db->or_like('inward_id', $searchstr);
    //             $this->db->or_like('inward_date', $searchstr);
    //             $this->db->or_like('consignor_name', $searchstr);
    //             $this->db->or_like('consignee_name', $searchstr);
    //             $this->db->or_like('vehicle_inward_no', $searchstr);
    //             $this->db->or_like('driver_name', $searchstr);
    //             $this->db->or_like('tbl_vehicle_inward.mobile_no', $searchstr);

    //         }
    //         $tempdb = clone $this->db;
    //         $this->db->order_by($arr[$col],$type);
    //         $num_rows = $tempdb->from('tbl_inward')
    //         ->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_inward.source_id', 'left')
    //         ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_inward.destiantion_id', 'left')
    //         ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_inward.vehicle_id', 'left')
    //         ->count_all_results();
    //         if($length>0)
    //             $this->db->limit($length, $start);
    //         $this->db->from('tbl_inward');
    //         $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_inward.source_id', 'left');
    //         $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_inward.destiantion_id', 'left');
    //         $this->db->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_inward.vehicle_id', 'left');
    //         //$this->db->order_by('vehicle_inward_id','desc');
    //         $query=$this->db->get();
    //         $response['count']=$num_rows;
    //         $response['data']=$query->result_array();
    //         return $response;
    //     }
    // }
    
     public function getinward($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        $arr=array("inward_id", "inward_no", "inward_date", "consignor_name", "consignee_name", "vehicle_inward_no", "driver_name", "mobile_no");
        if($start=='' && $length=='' && $searchstr=='')
        {

            $query=$this->db->select('`inward_id`,`inward_no`, `inward_date`, `source_id`, `destiantion_id`, `vehicle_id`, `owner_id`, `driver_charge`')
                ->from('tbl_inward')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('inward_id,`inward_no`, inward_date, consignor_name, consignee_name, vehicle_inward_no, driver_name, tbl_vehicle_inward.mobile_no');
            if(!empty($searchstr))
            {
                $this->db->or_like('inward_id', $searchstr);
                $this->db->or_like('inward_date', $searchstr);
                $this->db->or_like('consignor_name', $searchstr);
                $this->db->or_like('consignee_name', $searchstr);
                $this->db->or_like('vehicle_inward_no', $searchstr);
                $this->db->or_like('driver_name', $searchstr);
                $this->db->or_like('tbl_vehicle_inward.mobile_no', $searchstr);
            }
          
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_inward')
            ->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_inward.source_id', 'left')
            ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_inward.destiantion_id', 'left')
            ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_inward.vehicle_id', 'left')
            ->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_inward');
            $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_inward.source_id', 'left');
            $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_inward.destiantion_id', 'left');
            $this->db->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_inward.vehicle_id', 'left');
            //$this->db->order_by('vehicle_inward_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }


    
    
    
    public function getinwardbyid($inward_id)
    {
    	$id=encryptor("decrypt",$inward_id);
    	$query=$this->db->select('`inward_id`, `inward_date`, `source_id`, `destiantion_id`, `vehicle_id`, `owner_id`, `driver_charge`,gatepass_no,inward_type,rent_consignee_id,inward_warehouse_id')
                ->from('tbl_inward')
                ->where('inward_id',$id)
                ->get();
            $response['row']=$query->row();
            if($response['row']->inward_type=="0")
            {
                $query=$this->db->select('`item_id`, `qty`')
                ->from('tbl_inward_details')
                ->where('inward_id',$id)
                ->get();
            }
            else
            {
                $query=$this->db->select('`item_id`, `qty`')
                ->from('tbl_inward_rent_item')
                ->where('inward_id',$id)
                ->get();
            }
                $response['record']=$query->result_array();
                $query=$this->db->select('`employee_id`,loaded_amount')
                ->from('tbl_inward_loaded_by')
                ->where('inward_id',$id)
                ->get();
                $rec=$query->result_array();
                $response['loaded_by']=array();
                foreach ($rec as $row) {
                    array_push($response['loaded_by'], $row['employee_id']);
                }

                $query=$this->db->select('staff_id')
                ->from('tbl_inward_loaded_by_employee')
                ->where('inward_id',$id)
                ->get();
                $rec=$query->result_array();
                $response['loaded_by_employee']=array();
                foreach ($rec as $row) {
                	array_push($response['loaded_by_employee'], $row['staff_id']);
                }
                return $response;
    }
    public function updateinward($post)
    {
        //var_dump($_POST);
        //exit;
    	if(empty($_POST['inward_date']))
            $inward_date="";
        else
            $inward_date=date("Y-m-d", strtotime($_POST['inward_date']));
        if(empty($_POST['consignor_name']))
            $source_id="";
        else
            $source_id=$_POST['consignor_name'];

        if(empty($_POST['consignee_name']))
            $destiantion_id="";
        else
            $destiantion_id=$_POST['consignee_name'];

        if(empty($_POST['vehicle_id']))
            $vehicle_id="";
        else
            $vehicle_id=$_POST['vehicle_id'];

        if(empty($_POST['gatepass_no']))
            $gatepass_no="";
        else
            $gatepass_no=$_POST['gatepass_no'];

            $inward_type=$_POST['inward_type'];

        
        if(empty($_POST['rent_consignee_id']))
            $rent_consignee_id="";
        else
            $rent_consignee_id=$_POST['rent_consignee_id'];

        if(empty($_POST['warehouse_id']))
            $warehouse_id="";
        else
            $warehouse_id=$_POST['warehouse_id'];

        $inward_id=encryptor("decrypt",$_POST['inward_id']);

        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("inward_date"=>$inward_date,"source_id"=>$source_id,"destiantion_id"=>$destiantion_id,"vehicle_id"=>$vehicle_id,"gatepass_no"=>$gatepass_no,"updated_by"=>$user_id,"updated_datetime"=>$datetime,"rent_consignee_id"=>$rent_consignee_id,"inward_warehouse_id"=>$warehouse_id,"inward_type"=>$inward_type);
        $this->db->where('inward_id',$inward_id);
        $this->db->update('tbl_inward',$data);
        $data=array();
        $this->db->where('inward_id',$inward_id);
  		$this->db->delete('tbl_inward_details');
  		 $this->db->where('inward_id',$inward_id);
  		$this->db->delete('tbl_inward_loaded_by');
        $this->db->where('inward_id',$inward_id);
        $this->db->delete('tbl_inward_rent_item');
        
        $data=array();
        $qty=0;
        for($i=0;$i<sizeof($_POST['qty']);$i++)
        {
            if($_POST['qty'][$i]>0)
            {
                $qty+=$_POST['qty'][$i];
                if($inward_type=="0")
                    $temp = array('inward_id' => $inward_id,'item_id' => $_POST['itemName'][$i],'qty' => $_POST['qty'][$i]);
                else
                    $temp = array('inward_id' => $inward_id,'item_id' => $_POST['itemName'][$i],'qty' => $_POST['qty'][$i],"warehouse_id"=>$warehouse_id);
                array_push($data,$temp);
            }
        }
        if(sizeof($data)>0)
        {
            if($inward_type=="0")
                $this->db->insert_batch('tbl_inward_details', $data);
            else
                $this->db->insert_batch('tbl_inward_rent_item', $data);
        }
        
        
        if(isset($_POST['loaded_by']))
        {
            $data=array();
            for($i=0;$i<sizeof($_POST['loaded_by']);$i++)
            {
                if($_POST['loaded_by_rate_type'][$i]=="0")
                    $loaded_amount=$_POST['loaded_by_rate'][$i];
                else
                    $loaded_amount=$_POST['loaded_by_rate'][$i]*$qty;
                $temp = array('inward_id' => $inward_id,'employee_id' => $_POST['loaded_by'][$i],'loaded_amount' => $loaded_amount);
                array_push($data,$temp);
            }
            $this->db->insert_batch('tbl_inward_loaded_by', $data);
        }
        return $inward_id;
    }

    public function getinwardForPrint($id)
    {
        // echo 564564; exit();
        $this->db->select('inward_no,inward_id, inward_date, tbl_consignor.consignor_name,tbl_consignor.address,tbl_consignor.city,tbl_consignor.state,tbl_consignor.pincode,tbl_consignor.mobile_no,tbl_consignee.consignee_name as c_consignee_name,tbl_consignee.address as c_address,tbl_consignee.city as c_city,tbl_consignee.state as c_state,tbl_consignee.pincode as c_pincode,tbl_consignee.mobile_no as c_mobile_no, vehicle_inward_no, driver_name, tbl_vehicle_inward.mobile_no,gatepass_no');
        $this->db->from('tbl_inward');
        $this->db->where('inward_id',$id);
        $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_inward.source_id', 'left');
        $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_inward.destiantion_id', 'left');
        $this->db->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_inward.vehicle_id', 'left');
        //$this->db->order_by('vehicle_inward_id','desc');
        $query=$this->db->get();
        $response['data']=$query->row();
        $query=$this->db->select('item_name,qty')
        ->from('tbl_inward_details')
        ->where('tbl_inward_details.inward_id',$id)
        ->join('tbl_item','tbl_item.item_id=tbl_inward_details.item_id')
        ->get();
        // echo $this->db->last_query(); exit();
        $response['item']=$query->result_array();
        return $response;
    }


    public function getInwardbyConsignee($consignee_id,$date_from)
    {
        $date_to=date("Y-m-d", strtotime($_POST['date_to']));
        $qry=$this->db->select('inward_date')
        ->from('tbl_inward')
        ->where('destiantion_id',$consignee_id)
        ->where('inward_date <=',$date_from)
        ->order_by('inward_id','desc')
        ->get();
        $result=$qry->row();
        $qry=$this->db->select('inward_date,qty')
        ->from('tbl_inward')
        ->join('tbl_inward_details','tbl_inward_details.inward_id=tbl_inward.inward_id')
        ->where('destiantion_id',$consignee_id)
        ->where('inward_date >=',$result->inward_date)
        ->where('inward_date <',$date_to)
        ->group_by('inward_date')
        ->get();
        return $qry->result_array();
    }

}
?>