<?php
class Mdl_outwardrate extends CI_Model{

    public function saveoutwardrate($post)
    {
        // json_encode($_POST['item_advance_price']); exit();
    	//var_dump($_POST); exit();
        if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];

        if(empty($_POST['consignor_id']))
            $consignor_id="";
        else
            $consignor_id=$_POST['consignor_id'];

        if(empty($_POST['vehicle_type_id']))
            $vehicle_type_id="";
        else
            $vehicle_type_id=$_POST['vehicle_type_id'];

        if(empty($_POST['advance']))
            $advance="";
        else
            $advance=$_POST['advance'];

        if(empty($_POST['driver_price']))
            $driver_price="";
        else
            $driver_price=$_POST['driver_price'];

        if(empty($_POST['due']))
            $due="";
        else
            $due=$_POST['due'];

        if(empty($_POST['bill_type']))
            $bill_type="";
        else
            $bill_type=$_POST['bill_type'];

        if(empty($_POST['employee_charge']))
            $employee_charge="";
        else
            $employee_charge=$_POST['employee_charge'];

        if(empty($_POST['payment_mode']))
            $payment_mode="";
        else
            $payment_mode=$_POST['payment_mode'];


        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        if($bill_type==1){
        for ($count = 0; $count < count($_POST['item_id']); $count++){
        $data=array(
            "consignee_id"=>$consignee_id,
            "consignor_id"=>$consignor_id,
            "vehicle_type_id"=>$vehicle_type_id,
            "item"=>$_POST['item_id'][$count],
            "advance"=>$_POST['item_advance_price'][$count],
            "due"=>$_POST['item_due_price'][$count],
            "driver_price"=>$driver_price,
            "employee_charge"=>$employee_charge,
            "bill_type"=>$bill_type,
            "payment_mode"=>$payment_mode,
            "created_by"=>$user_id,
            "created_datetime"=>$datetime);
        $this->db->insert('tbl_outward_rate',$data);
        // echo $this->db->last_query();
        }}

        if($bill_type==0){
        $data=array(
            "consignee_id"=>$consignee_id,
            "consignor_id"=>$consignor_id,
            "vehicle_type_id"=>$vehicle_type_id,
            "advance"=>$advance,
            "due"=>$due,
            "driver_price"=>$driver_price,
            "employee_charge"=>$employee_charge,
            "bill_type"=>$bill_type,
            "payment_mode"=>$payment_mode,
            "created_by"=>$user_id,
            "created_datetime"=>$datetime);
        $this->db->insert('tbl_outward_rate',$data);
        // echo $this->db->last_query();
       }

        $outward_rate_id=$this->db->insert_id();    
        return $outward_rate_id;
    }

    public function updateoutwardrate($post)
    {
        
        if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];

        if(empty($_POST['consignor_id']))
            $consignor_id="";
        else
            $consignor_id=$_POST['consignor_id'];

        if(empty($_POST['vehicle_type_id']))
            $vehicle_type_id="";
        else
            $vehicle_type_id=$_POST['vehicle_type_id'];

        if(empty($_POST['bill_type']))
            $bill_type="";
        else
            $bill_type=$_POST['bill_type'];

        if(empty($_POST['item_id']))
            $item="";
        else
            $item=$_POST['item_id'];

        if($bill_type=="1")
        {
            if(empty($_POST['item_advance_price']))
                $advance="";
            else
                $advance=$_POST['item_advance_price'];
            if(empty($_POST['item_due_price']))
                $due="";
            else
                $due=$_POST['item_due_price'];
        }
        else
        {
            if(empty($_POST['advance']))
                $advance="";
            else
                $advance=$_POST['advance'];
            if(empty($_POST['due']))
                $due="";
            else
                $due=$_POST['due'];
        }

        if(empty($_POST['driver_price']))
            $driver_price="";
        else
            $driver_price=$_POST['driver_price'];

        if(empty($_POST['employee_charge']))
            $employee_charge="";
        else
            $employee_charge=$_POST['employee_charge'];

        if(empty($_POST['payment_mode']))
            $payment_mode="";
        else
            $payment_mode=$_POST['payment_mode'];

        $user_id=$this->session->userdata('user_id');
        $datetime = date('Y-m-d h:i:s');
        $data=array("consignee_id"=>$consignee_id,"consignor_id"=>$consignor_id,"vehicle_type_id"=>$vehicle_type_id,"advance"=>$advance,"driver_price"=>$driver_price,"due"=>$due,"employee_charge"=>$employee_charge,"bill_type"=>$bill_type,"payment_mode"=>$payment_mode,"updated_by"=>$user_id,"updated_datetime"=>$datetime);
        $rate_id=encryptor('decrypt',$_POST['rate_id']);
        $this->db->where('rate_id',$rate_id);
        $this->db->update('tbl_outward_rate',$data);
        return $outward_id;
    }

    public function getoutwardrate($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        $arr=array("rate_id", "consignor_name", "consignee_name", "vehicle_type","bill_type", "advance", "due", "driver_price", "employee_charge", "payment_mode");
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`rate_id`, `consignee_id`, `vehicle_type_id`, `driver_price`, `item`, `advance`, `due`, `employee_charge`, `bill_type`,payment_mode')
                ->from('tbl_outward_rate')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('`rate_id`, `consignor_name`,`consignee_name`, `vehicle_type`, `driver_price`,`item`, `advance`, `due`, `employee_charge`, `bill_type`,payment_mode');
            if(!empty($searchstr))
            {
                $this->db->or_like('consignee_name', $searchstr);
                $this->db->or_like('consignor_name', $searchstr);
                $this->db->or_like('vehicle_type', $searchstr);
                $this->db->or_like('advance', $searchstr);
                $this->db->or_like('driver_price', $searchstr);

            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_outward_rate')
            ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_outward_rate.consignee_id', 'left')
            ->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_outward_rate.consignor_id', 'left')
            ->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id = tbl_outward_rate.vehicle_type_id', 'left')
            ->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_outward_rate');
            $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_outward_rate.consignee_id', 'left');
            $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_outward_rate.consignor_id', 'left');
            $this->db->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id = tbl_outward_rate.vehicle_type_id', 'left');
            //$this->db->order_by('vehicle_outward_id','desc');
            $query=$this->db->get();
            // echo $this->db->last_query();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }

    public function getoutwardratebyid($outward_id)
    {
    	$id=encryptor("decrypt",$outward_id);
    	$query=$this->db->select('`rate_id`, consignor_id,`consignee_id`, `vehicle_type_id`, `driver_price`, `advance`, `due`, `employee_charge`, `bill_type`,payment_mode')
                ->from('tbl_outward_rate')
                ->where('rate_id',$id)
                ->get();
            $response=$query->row();
            return $response;
    }

    public function getprice($consignee_id,$consignor_id,$vehicle_type_id="0",$bill_type)
    {
        $query=$this->db->select('`driver_price`, `advance`, `due`, `employee_charge`,payment_mode')
        ->from('tbl_outward_rate')
        ->where(array('consignee_id' =>$consignee_id,'consignor_id' =>$consignor_id,'vehicle_type_id' =>$vehicle_type_id,'bill_type' =>$bill_type ))
        ->get();
        //echo $this->db->last_query();
        $response['vehicle_price']=$query->result_array();
        
        return $response;
    }

    public function get_item($rate_id=null)
    {
        $query=$this->db->select('tbl_outward_rate.item,item_name,advance,due')
        ->from('tbl_outward_rate')
        ->join('tbl_item','tbl_outward_rate.item=tbl_item.item_id', 'left')
        ->where('rate_id', $rate_id )
        ->get();
        //echo $this->db->last_query();
       return $query->result();
        
    }

    public function deletebyid($rate_id)
    {
        $query=$this->db->select('consignee_id,vehicle_type_id')
        ->from('tbl_outward_rate')
        ->where(array('rate_id' => $rate_id ))
        ->get();
        $row=$query->row();
        $this->db->where(array('rate_id' => $rate_id ));
        $this->db->delete('tbl_outward_rate');

        return $this->db->affected_rows();
    }

}
?>