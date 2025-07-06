<?php
class Mdl_labor_invoice_rate extends CI_Model{

    public function savelaborrate($post)
    {
    	if(empty($_POST['consignor_id']))
            $consignor_id="";
        else
            $consignor_id=$_POST['consignor_id'];

        if(empty($_POST['consignee_billing_id']))
            $consignee_billing_id="";
        else
            $consignee_billing_id=$_POST['consignee_billing_id'];

        if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];

        if(empty($_POST['amount']))
            $amount="";
        else
            $amount=$_POST['amount'];
       
            
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        
        $data=array("consignor_id"=>$consignor_id,"consignee_id"=>$consignee_id,"billing_address_id"=>$consignee_billing_id,"amount"=>$amount,"created_by"=>$user_id,"created_datetime"=>$datetime);
        //var_dump($data);
        $this->db->insert('tbl_labor_invoice_rate',$data);
    }
    public function updatelaborinvoicerate($post)
    {
        if(empty($_POST['labor_invoice_rate_id']))
            $labor_invoice_rate_id="";
        else
            $labor_invoice_rate_id=$_POST['labor_invoice_rate_id'];

        if(empty($_POST['consignee_billing_id']))
            $consignee_billing_id="";
        else
            $consignee_billing_id=$_POST['consignee_billing_id'];

        if(empty($_POST['amount']))
            $amount="";
        else
            $amount=$_POST['amount'];
         $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("billing_address_id"=>$consignee_billing_id,"amount"=>$amount,"updated_by"=>$user_id,"updated_datetime"=>$datetime);

         $this->db->where(array('labor_invoice_rate_id' =>encryptor('decrypt',$labor_invoice_rate_id)));

        $this->db->update('tbl_labor_invoice_rate',$data);
        //return $this->saveinvoicerate($_POST);
        
    }
    public function getlaborrate($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        $arr=array("labor_invoice_rate_id", "tbl_consignor.consignor_id", "tbl_consignee.consignee_id", "billing_address_id", "amount");
        if($start=='' && $length=='' && $searchstr=='')
        {

            $query=$this->db->select('`labor_invoice_rate_id`, tbl_consignor.consignor_id, tbl_consignee.consignee_id, `billing_address_id`, amount')
                ->from('tbl_labor_invoice_rate')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('`labor_invoice_rate_id`, tbl_consignor.consignor_id,consignor_name, tbl_consignee.consignee_id,consignee_name, `billing_address_id`,consignee_billing_name, amount');
            if(!empty($searchstr))
            {
                $this->db->or_like('consignor_name', $searchstr);
                $this->db->or_like('consignee_name', $searchstr);
                $this->db->or_like('consignee_billing_name', $searchstr);

            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_labor_invoice_rate')
            ->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_labor_invoice_rate.consignor_id', 'left')
            ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_labor_invoice_rate.consignee_id', 'left')
            ->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_labor_invoice_rate.billing_address_id', 'left')
            ->group_by(array("consignor_id", "consignee_id","billing_address_id"))
            ->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_labor_invoice_rate');
            $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_labor_invoice_rate.consignor_id', 'left');
            $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_labor_invoice_rate.consignee_id', 'left');
            $this->db->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_labor_invoice_rate.billing_address_id', 'left');
            $this->db->group_by(array("consignor_id", "consignee_id","billing_address_id"));
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getlaborinvoiceratebyid($labor_invoice_rate_id)
    {
    	$id=encryptor("decrypt",$labor_invoice_rate_id);
    	$this->db->select('`labor_invoice_rate_id`, tbl_consignor.consignor_id,consignor_name, tbl_consignee.consignee_id,consignee_name, `billing_address_id`,consignee_billing_name,amount');
        $this->db->from('tbl_labor_invoice_rate');
        $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_labor_invoice_rate.consignor_id', 'left');
        $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_labor_invoice_rate.consignee_id', 'left');
        $this->db->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_labor_invoice_rate.billing_address_id', 'left');
        $this->db->where('labor_invoice_rate_id',$id);
        $query=$this->db->get();
        $response['form_data']=$query->row();
        
        return $response;
        
    }
    public function checkrecord($consignor_id,$consignee_id)
    {
        $query=$this->db->select('labor_invoice_rate_id')
        ->from('tbl_labor_invoice_rate')
        ->where(array('consignor_id' =>$consignor_id ,'consignee_id' =>$consignee_id))
        ->count_all_results();
        return $query;
        
    }
    public function deletebyid($labor_invoice_rate_id)
    {
        $query=$this->db->select('consignor_id,consignee_id,bill_type,data_type')
        ->from('tbl_labor_invoice_rate')
        ->where(array('labor_invoice_rate_id' => $labor_invoice_rate_id ))
        ->get();
        $row=$query->row();
        $this->db->where(array('consignee_id' => $row->consignee_id,'consignor_id' =>$row->consignor_id,'bill_type' => $row->bill_type,'data_type' => $row->data_type ));
        $this->db->delete('tbl_labor_invoice_rate');
        

        return $this->db->affected_rows();
    }
    public function getreportByVehicleId()
    {
        $date_from=date("Y-m-d", strtotime($_POST['date_from']));
        $date_to=date("Y-m-d", strtotime($_POST['date_to']));
        $vehicle_id=$_POST['vehicle_inward_id'];
       
        $query=$this->db->query("select inward_date,consignor_name,consignee_name,tbl_labor_invoice_rate.driver_price from tbl_labor_invoice_rate LEFT JOIN tbl_inward on tbl_labor_invoice_rate.consignor_id=tbl_inward.source_id and tbl_labor_invoice_rate.consignee_id=tbl_inward.destiantion_id
LEFT JOIN tbl_consignee on tbl_consignee.consignee_id=tbl_inward.destiantion_id
LEFT JOIN tbl_consignor on tbl_consignor.consignor_id=tbl_inward.source_id
WHERE tbl_labor_invoice_rate.vehicle_type_id=7 and vehicle_id=".$vehicle_id." and inward_date>='".$date_from."' and inward_date<='".$date_to."' union select consignment_date as inward_date,consignor_name,consignee_name,tbl_outward_rate.driver_price from tbl_outward_rate LEFT JOIN tbl_consignment on tbl_outward_rate.consignee_id=tbl_consignment.consignee_id
LEFT JOIN tbl_consignee on tbl_consignee.consignee_id=tbl_consignment.consignee_id
LEFT JOIN tbl_consignor on tbl_consignor.consignor_id=tbl_consignment.consignor_id
WHERE tbl_outward_rate.vehicle_type_id=7 and vehicle_id=".$vehicle_id." and consignment_date>='".$date_from."' and consignment_date<='".$date_to."' order by inward_date");

        return $query->result_array();
    }

public function getLaborInvoiceRecordByBillingID($billing_address_id)
{

    $this->db->select('`labor_invoice_rate_id`, tbl_consignor.consignor_id,consignor_name, tbl_consignee.consignee_id,consignee_name, `billing_address_id`,consignee_billing_name, amount');
        $this->db->from('tbl_labor_invoice_rate');
        $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_labor_invoice_rate.consignor_id', 'left');
        $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_labor_invoice_rate.consignee_id', 'left');
        $this->db->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_labor_invoice_rate.billing_address_id', 'left');
        $this->db->where('billing_address_id',$billing_address_id);
       
        $query=$this->db->get();
        return $query->result_array();
    }
}

?>