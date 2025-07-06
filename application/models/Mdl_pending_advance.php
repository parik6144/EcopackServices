<?php
class Mdl_pending_advance extends CI_Model{

    public function changestatus($consignment_id)
    {
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $date=date('Y-m-d');
        $data=$this->getconsignmentbyid($consignment_id);
        $totalfare=$data->advance+$data->due;
        if($_POST['payment_mode']<3)
        {
            $tds=($totalfare*2)/100;
            $netpay=$data->advance-$tds;
            $payment_mode=$_POST['payment_mode'];
        }
        else
        {
             $netpay=$data->advance;
             $payment_mode=$_POST['payment_mode'];
        }
        

        $ary=array('consignment_id' => $consignment_id,"consignee_id"=>$data->consignee_id,"amount"=> $netpay,"owner_id"=>$data->owner_id,"created_by"=>$user_id,"created_datetime"=>$datetime,"payment_mode"=>$payment_mode);
        $this->db->insert('tbl_payment_advance',$ary);
        
        if($_POST['payment_mode']<3)
        {
            $ary=array('tds_amount' => $tds,"payment_date"=>$date,"ref_id"=>$data->owner_id,"ref_type"=>"3");
            $this->db->insert('tbl_tds',$ary);
        }
        
    }
    public function getconsignmentbyid($consignmentid)
    {
        $query=$this->db->select('consignment_id,tbl_consignment.consignee_id, advance,due,tbl_inward_owner.owner_id')
        ->from('tbl_consignment')
        ->where('consignment_id',$consignmentid)
        ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_consignment.vehicle_id', 'left')
        ->join('tbl_inward_owner', 'tbl_inward_owner.owner_id = tbl_vehicle_inward.owner_id', 'left')
        ->get();
        return $query->row();
    }
    
    // public function getconsignment($start="",$length="",$searchstr="",$column,$type)
    // {
    //   /* $query=$this->db->select('consignment_id')
    //     ->from('tbl_payment_advance')
    //     ->get();

    //     $ids=array();
    //     foreach ($query->result_array() as $row) {
    //         array_push($ids,$row['consignment_id']);
    //     }*/
    //     $col = (int)$column;
    //     $arr=array("consignment_no", "consignment_date", "vehicle_inward_no","owner_name","tbl_inward_owner.mobile_no", "bank_name", "branch","account_no","ifsc_code","tbl_outward_rate.advance");
    //     $this->db->select('distinct(tbl_consignment.consignment_id),consignment_no, consignment_date, vehicle_inward_no,tbl_consignment.owner_name,tbl_inward_owner.mobile_no,bank_name,branch,account_no,ifsc_code,tbl_outward_rate.advance,tbl_consignment.bill_type,sum(tbl_consignment_stock_item.qty) as qty,tbl_outward_rate.due');
    //     if(!empty($searchstr))
    //     {
    //         $this->db->or_like('consignment_no', $searchstr);
    //         $this->db->or_like('consignment_date', $searchstr);
    //         $this->db->or_like('vehicle_inward_no', $searchstr);
    //         $this->db->or_like('owner_name', $searchstr);
    //         $this->db->or_like('tbl_inward_owner.mobile_no', $searchstr);
    //         $this->db->or_like('bank_name', $searchstr);
    //         $this->db->or_like('branch', $searchstr);
    //         $this->db->or_like('account_no', $searchstr);
    //         $this->db->or_like('ifsc_code', $searchstr);
    //         $this->db->or_like('tbl_outward_rate.advance', $searchstr);
    //     }
    //         $this->db->where('tbl_consignment.consignment_id NOT IN (select consignment_id from tbl_payment_advance)', NULL, FALSE);
    //         $this->db->where('tbl_outward_rate.advance >','0');
    //         $this->db->where('tbl_outward_rate.payment_mode','0');
    //     $tempdb = clone $this->db;
    //     $this->db->order_by($arr[$col],$type);
    //     $num_rows = $tempdb->from('tbl_consignment')
    //     ->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_consignment.consignor_id', 'left')
    //     ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_consignment.consignee_id', 'left')
    //     ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_consignment.vehicle_id', 'left')
    //     ->join('tbl_inward_owner', 'tbl_inward_owner.owner_id = tbl_vehicle_inward.owner_id', 'left')
    //     ->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id = tbl_vehicle_inward.vehicle_type_id', 'left')
    //     ->join('tbl_outward_rate', 'tbl_outward_rate.vehicle_type_id = tbl_vehicle_type.vehicle_type_id and tbl_outward_rate.consignee_id=tbl_consignment.consignee_id and tbl_outward_rate.bill_type=tbl_consignment.bill_type', 'left')
    //     ->join('tbl_consignment_stock_item', 'tbl_consignment_stock_item.consignment_id = tbl_consignment.consignment_id', 'left')
    //     ->group_by('tbl_consignment.consignment_id')
    //         ->count_all_results();
    //     if($length>0)
    //         $this->db->limit($length, $start);
    //     $this->db->from('tbl_consignment');
    //     $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_consignment.consignor_id', 'left');
    //     $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_consignment.consignee_id', 'left');
    //     $this->db->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_consignment.vehicle_id', 'left');
    //     $this->db->join('tbl_inward_owner', 'tbl_inward_owner.owner_id = tbl_vehicle_inward.owner_id', 'left');
    //     $this->db->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id = tbl_vehicle_inward.vehicle_type_id', 'left');
    //     $this->db->join('tbl_outward_rate', 'tbl_outward_rate.vehicle_type_id = tbl_vehicle_type.vehicle_type_id and tbl_outward_rate.consignee_id=tbl_consignment.consignee_id and tbl_outward_rate.bill_type=tbl_consignment.bill_type', 'left');
    //     $this->db->join('tbl_consignment_stock_item', 'tbl_consignment_stock_item.consignment_id = tbl_consignment.consignment_id', 'left');
    //     $this->db->order_by('consignment_no','desc');
    //     $this->db->group_by('tbl_consignment.consignment_id');
    //     $query=$this->db->get();
    //     $response['count']=$num_rows;
    //     $response['data']=$query->result_array();
        
    //     return $response;
    // }
    
     public function getconsignment($start="",$length="",$searchstr="",$column,$type)
    {
       /* $query=$this->db->select('consignment_id')
        ->from('tbl_payment_advance')
        ->get();

        $ids=array();
        foreach ($query->result_array() as $row) {
            array_push($ids,$row['consignment_id']);
        }*/
        $col = (int)$column;
        //$arr=array("consignment_no", "consignment_date", "vehicle_inward_no","owner_name","tbl_inward_owner.mobile_no", "bank_name", "branch","account_no","ifsc_code","tbl_outward_rate.advance");
        $arr=array("consignment_no", "consignment_date", "vehicle_inward_no","owner_name","tbl_inward_owner.mobile_no", "bank_name", "branch","account_no","ifsc_code","tbl_consignment.advance");
        $this->db->select('distinct(tbl_consignment.consignment_id),consignment_no, consignment_date, vehicle_inward_no,tbl_inward_owner.owner_name,tbl_inward_owner.mobile_no,bank_name,branch,account_no,ifsc_code,tbl_consignment.advance,tbl_consignment.bill_type,sum(tbl_consignment_stock_item.qty) as qty,tbl_consignment.due');
        if(!empty($searchstr))
        {
            $this->db->or_like('consignment_no', $searchstr);
            $this->db->or_like('consignment_date', $searchstr);
            $this->db->or_like('vehicle_inward_no', $searchstr);
            $this->db->or_like('tbl_inward_owner.owner_name', $searchstr);
            $this->db->or_like('tbl_inward_owner.mobile_no', $searchstr);
            $this->db->or_like('bank_name', $searchstr);
            $this->db->or_like('branch', $searchstr);
            $this->db->or_like('account_no', $searchstr);
            $this->db->or_like('ifsc_code', $searchstr);
            $this->db->or_like('tbl_consignment.advance', $searchstr);
        }
            $this->db->where('tbl_consignment.consignment_id NOT IN (select consignment_id from tbl_payment_advance)', NULL, FALSE);
            $this->db->where('tbl_consignment.advance >','0');
            $this->db->where('tbl_outward_rate.payment_mode','0');
        $tempdb = clone $this->db;
        $this->db->order_by($arr[$col],$type);
        $num_rows = $tempdb->from('tbl_consignment')
        ->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_consignment.consignor_id', 'left')
        ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_consignment.consignee_id', 'left')
        ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_consignment.vehicle_id', 'left')
        ->join('tbl_inward_owner', 'tbl_inward_owner.owner_id = tbl_vehicle_inward.owner_id', 'left')
        ->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id = tbl_vehicle_inward.vehicle_type_id', 'left')
        ->join('tbl_outward_rate', 'tbl_outward_rate.vehicle_type_id = tbl_vehicle_type.vehicle_type_id and tbl_outward_rate.consignee_id=tbl_consignment.consignee_id and tbl_outward_rate.bill_type=tbl_consignment.bill_type', 'left')
        ->join('tbl_consignment_stock_item', 'tbl_consignment_stock_item.consignment_id = tbl_consignment.consignment_id', 'left')
        ->group_by('tbl_consignment.consignment_id')
        ->count_all_results();
        if($length>0)
            $this->db->limit($length, $start);
        $this->db->from('tbl_consignment');
        $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_consignment.consignor_id', 'left');
        $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_consignment.consignee_id', 'left');
        $this->db->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_consignment.vehicle_id', 'left');
        $this->db->join('tbl_inward_owner', 'tbl_inward_owner.owner_id = tbl_vehicle_inward.owner_id', 'left');
        $this->db->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id = tbl_vehicle_inward.vehicle_type_id', 'left');
        $this->db->join('tbl_outward_rate', 'tbl_outward_rate.vehicle_type_id = tbl_vehicle_type.vehicle_type_id and tbl_outward_rate.consignee_id=tbl_consignment.consignee_id and tbl_outward_rate.bill_type=tbl_consignment.bill_type', 'left');
        $this->db->join('tbl_consignment_stock_item', 'tbl_consignment_stock_item.consignment_id = tbl_consignment.consignment_id', 'left');
        $this->db->order_by('consignment_no','desc');
        $this->db->group_by('tbl_consignment.consignment_id');
        $query=$this->db->get();
        $response['count']=$num_rows;
        $response['data']=$query->result_array();
        //echo $this->db->last_query(); exit();
        return $response;
    }
    
    
    // public function gettotaladvance()
    // {
    //     $query=$this->db->select('consignment_id')
    //     ->from('tbl_payment_advance')
    //     ->get();

    //     $ids=array();
    //     foreach ($query->result_array() as $row) {
    //         array_push($ids,$row['consignment_id']);
    //     }
       
    //     $this->db->select('tbl_consignment.consignment_id,tbl_outward_rate.advance,tbl_consignment.bill_type,sum(tbl_consignment_stock_item.qty) as qty');
    //     $this->db->from('tbl_consignment');
    //     if(sizeof($ids)>0)
    //         $this->db->where_not_in('tbl_consignment.consignment_id',$ids);
    //     $this->db->where('tbl_outward_rate.advance >','0');
    //     $this->db->where('tbl_outward_rate.payment_mode','0');
    //     $this->db->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_consignment.vehicle_id', 'left');
    //     //$this->db->join('tbl_inward_owner', 'tbl_inward_owner.owner_id = tbl_vehicle_inward.owner_id', 'left');
    //     $this->db->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id = tbl_vehicle_inward.vehicle_type_id', 'left');
    //     $this->db->join('tbl_outward_rate', 'tbl_outward_rate.vehicle_type_id = tbl_vehicle_type.vehicle_type_id and tbl_outward_rate.consignee_id=tbl_consignment.consignee_id and tbl_outward_rate.bill_type=tbl_consignment.bill_type', 'left');
    //     $this->db->join('tbl_consignment_stock_item', 'tbl_consignment_stock_item.consignment_id = tbl_consignment.consignment_id', 'left');
    //     $this->db->group_by('tbl_consignment.consignment_id');
    //     $query=$this->db->get();
    //     $data=$query->result_array();
    //     $total=0;
    //     foreach ($data as $row) {
    //         # code...
    //         if($row['bill_type']=="1")
    //             $total+=$row['qty']*$row['advance'];
    //         else
    //             $total+=$row['advance'];
    //     }

    //     return $total;
    // }
    
    public function gettotaladvance()
    {
        $query=$this->db->select('consignment_id')
        ->from('tbl_payment_advance')
        ->get();

        $ids=array();
        foreach ($query->result_array() as $row) {
            array_push($ids,$row['consignment_id']);
        }
        
        $this->db->select('tbl_consignment.consignment_id,tbl_consignment.advance,tbl_consignment.bill_type,sum(tbl_consignment_stock_item.qty) as qty');
        $this->db->from('tbl_consignment');
        if(sizeof($ids)>0)
            $this->db->where_not_in('tbl_consignment.consignment_id',$ids);
        $this->db->where('tbl_outward_rate.advance >','0');
        $this->db->where('tbl_outward_rate.payment_mode','0');
        $this->db->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_consignment.vehicle_id', 'left');
        //$this->db->join('tbl_inward_owner', 'tbl_inward_owner.owner_id = tbl_vehicle_inward.owner_id', 'left');
        $this->db->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id = tbl_vehicle_inward.vehicle_type_id', 'left');
        $this->db->join('tbl_outward_rate', 'tbl_outward_rate.vehicle_type_id = tbl_vehicle_type.vehicle_type_id and tbl_outward_rate.consignee_id=tbl_consignment.consignee_id and tbl_outward_rate.bill_type=tbl_consignment.bill_type', 'left');
        $this->db->join('tbl_consignment_stock_item', 'tbl_consignment_stock_item.consignment_id = tbl_consignment.consignment_id', 'left');
        $this->db->group_by('tbl_consignment.consignment_id');
        $query=$this->db->get();
        $data=$query->result_array();
        $total=0;
        foreach ($data as $row) {
            # code...
            if($row['bill_type']=="1")
                $total+=$row['advance'];
            else
                $total+=$row['advance'];
        }

        return $total;
    }
}
?>