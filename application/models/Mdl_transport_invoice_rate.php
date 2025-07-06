<?php
class Mdl_transport_invoice_rate extends CI_Model{

    public function saveinvoicerate($post)
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
       
            $invoice_type=$_POST['invoice_type'];
            $data_type=$_POST['data_type'];
            
        //echo "ok".$invoice_type;
        //exit;
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        if($invoice_type=="0")
        {
            //echo "if";
            //exit;
            if(isset($_POST['vehicle_type_id']))
            {
                for($i=0;$i<sizeof($_POST['vehicle_type_id']);$i++) {
                    $data=array("consignor_id"=>$consignor_id,"consignee_id"=>$consignee_id,"billing_address_id"=>$consignee_billing_id,"bill_type"=>$invoice_type,"data_type"=>$data_type,"ref_id"=>$_POST['vehicle_type_id'][$i],"amount"=>$_POST['vehicle_price'][$i],"created_by"=>$user_id,"created_datetime"=>$datetime);
                    //var_dump($data);
                    $this->db->insert('tbl_transport_invoice_rate',$data);
                }
            }
            
        }
        else if($invoice_type=="1")
        {
            if(isset($_POST['item_id']))
            {
                 for($i=0;$i<sizeof($_POST['item_id']);$i++) {
                     $data=array("consignor_id"=>$consignor_id,"consignee_id"=>$consignee_id,"billing_address_id"=>$consignee_billing_id,"bill_type"=>$invoice_type,"data_type"=>$data_type,"ref_id"=>$_POST['item_id'][$i],"amount"=>$_POST['item_price'][$i],"created_by"=>$user_id,"created_datetime"=>$datetime);
                    $this->db->insert('tbl_transport_invoice_rate',$data);
                }
            }           
        }
    }
    public function updatetransportinvoicerate($post)
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
       
            $invoice_type=$_POST['invoice_type'];
         $this->db->where(array('consignor_id' =>$consignor_id ,'consignee_id' =>$consignee_id,'bill_type' =>$invoice_type ));
        $this->db->delete('tbl_transport_invoice_rate');
        return $this->saveinvoicerate($_POST);
        
    }
    public function getinwardrate($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        $arr=array("transport_invoice_rate_id", "tbl_consignor.consignor_id", "tbl_consignee.consignee_id", "billing_address_id", "bill_type", "data_type");
        if($start=='' && $length=='' && $searchstr=='')
        {

            $query=$this->db->select('`transport_invoice_rate_id`, tbl_consignor.consignor_id, tbl_consignee.consignee_id, `billing_address_id`, `bill_type`, `data_type`')
                ->from('tbl_transport_invoice_rate')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('`transport_invoice_rate_id`, tbl_consignor.consignor_id,consignor_name, tbl_consignee.consignee_id,consignee_name, `billing_address_id`,consignee_billing_name, `bill_type`,data_type');
            if(!empty($searchstr))
            {
                $this->db->or_like('consignor_name', $searchstr);
                $this->db->or_like('consignee_name', $searchstr);
                $this->db->or_like('consignee_billing_name', $searchstr);

            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_transport_invoice_rate')
            ->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_transport_invoice_rate.consignor_id', 'left')
            ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_transport_invoice_rate.consignee_id', 'left')
            ->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_transport_invoice_rate.billing_address_id', 'left')
            ->group_by(array("consignor_id", "consignee_id","billing_address_id","bill_type","data_type"))
            ->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_transport_invoice_rate');
            $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_transport_invoice_rate.consignor_id', 'left');
            $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_transport_invoice_rate.consignee_id', 'left');
            $this->db->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_transport_invoice_rate.billing_address_id', 'left');
            $this->db->group_by(array("consignor_id", "consignee_id","billing_address_id","bill_type","data_type"));
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function gettransportinvoiceratebyid($transport_invoice_rate_id)
    {
    	$id=encryptor("decrypt",$transport_invoice_rate_id);
        
    	$this->db->select('`transport_invoice_rate_id`, tbl_consignor.consignor_id,consignor_name, tbl_consignee.consignee_id,consignee_name, `billing_address_id`,consignee_billing_name, `bill_type`,data_type');
        $this->db->from('tbl_transport_invoice_rate');
        $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_transport_invoice_rate.consignor_id', 'left');
        $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_transport_invoice_rate.consignee_id', 'left');
        $this->db->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_transport_invoice_rate.billing_address_id', 'left');
        $this->db->where('transport_invoice_rate_id',$id);
        $query=$this->db->get();
        $response['form_data']=$query->row();
        
        if($response['form_data']->bill_type=="0")
        {
            $query=$this->db->select('ref_id,amount,vehicle_type')
            ->from('tbl_transport_invoice_rate')
            ->join('tbl_vehicle_type', 'tbl_transport_invoice_rate.ref_id = tbl_vehicle_type.vehicle_type_id', 'left')
            ->where(array('consignor_id' =>$response['form_data']->consignor_id ,'consignee_id' =>$response['form_data']->consignee_id,'bill_type' =>$response['form_data']->bill_type,'data_type' => $response['form_data']->data_type))
            ->get();
            $response['data']=$query->result_array();
            $temp=[];
            foreach ($response['data'] as $row) {
                array_push($temp, $row['ref_id']);
            }
            $query=$this->db->select('vehicle_type_id as ref_id,"" as amount,vehicle_type')
            ->from('tbl_vehicle_type')
            ->where_not_in('vehicle_type_id',$temp)
            ->get();
            $response['other']=$query->result_array();

        }
        else
        {
            $query=$this->db->select('ref_id,amount,item_name')
            ->from('tbl_transport_invoice_rate')
            ->join('tbl_item', 'tbl_transport_invoice_rate.ref_id = tbl_item.item_id', 'right')
            ->where(array('consignor_id' =>$response['form_data']->consignor_id ,'tbl_transport_invoice_rate.consignee_id' =>$response['form_data']->consignee_id,'bill_type' =>$response['form_data']->bill_type, 'tbl_item.consignee_id' =>$response['form_data']->consignee_id,'data_type' => $response['form_data']->data_type))
            ->get();
            $response['data']=$query->result_array();
            $temp=[];
            foreach ($response['data'] as $row) {
                array_push($temp, $row['ref_id']);
            }
            $query=$this->db->select('item_id as ref_id,"" as amount,item_name')
            ->from('tbl_item')            
            ->where(array('tbl_item.consignee_id' =>$response['form_data']->consignee_id))
            ->where_not_in('item_id',$temp)
            ->get();
            $response['other']=$query->result_array();
        }
        return $response;
        
    }
    public function checkrecord($consignor_id,$consignee_id,$invoice_type,$data_type)
    {
        $query=$this->db->select('transport_invoice_rate_id')
        ->from('tbl_transport_invoice_rate')
        ->where(array('consignor_id' =>$consignor_id ,'consignee_id' =>$consignee_id,'bill_type' =>$invoice_type,"data_type"=>$data_type ))
        ->count_all_results();
        return $query;
        
    }
    public function deletebyid($transport_invoice_rate_id)
    {
        $query=$this->db->select('consignor_id,consignee_id,bill_type,data_type')
        ->from('tbl_transport_invoice_rate')
        ->where(array('transport_invoice_rate_id' => $transport_invoice_rate_id ))
        ->get();
        $row=$query->row();
        $this->db->where(array('consignee_id' => $row->consignee_id,'consignor_id' =>$row->consignor_id,'bill_type' => $row->bill_type,'data_type' => $row->data_type ));
        $this->db->delete('tbl_transport_invoice_rate');
        

        return $this->db->affected_rows();
    }
    public function getreportByVehicleId()
    {
        $date_from=date("Y-m-d", strtotime($_POST['date_from']));
        $date_to=date("Y-m-d", strtotime($_POST['date_to']));
        $vehicle_id=$_POST['vehicle_inward_id'];
       
        $query=$this->db->query("select inward_date,consignor_name,consignee_name,tbl_transport_invoice_rate.driver_price from tbl_transport_invoice_rate LEFT JOIN tbl_inward on tbl_transport_invoice_rate.consignor_id=tbl_inward.source_id and tbl_transport_invoice_rate.consignee_id=tbl_inward.destiantion_id
LEFT JOIN tbl_consignee on tbl_consignee.consignee_id=tbl_inward.destiantion_id
LEFT JOIN tbl_consignor on tbl_consignor.consignor_id=tbl_inward.source_id
WHERE tbl_transport_invoice_rate.vehicle_type_id=7 and vehicle_id=".$vehicle_id." and inward_date>='".$date_from."' and inward_date<='".$date_to."' union select consignment_date as inward_date,consignor_name,consignee_name,tbl_outward_rate.driver_price from tbl_outward_rate LEFT JOIN tbl_consignment on tbl_outward_rate.consignee_id=tbl_consignment.consignee_id
LEFT JOIN tbl_consignee on tbl_consignee.consignee_id=tbl_consignment.consignee_id
LEFT JOIN tbl_consignor on tbl_consignor.consignor_id=tbl_consignment.consignor_id
WHERE tbl_outward_rate.vehicle_type_id=7 and vehicle_id=".$vehicle_id." and consignment_date>='".$date_from."' and consignment_date<='".$date_to."' order by inward_date");

        return $query->result_array();
    }

public function getTransportInvoiceRecordByBillingID($billing_address_id)
{
    $this->db->select('`transport_invoice_rate_id`, tbl_consignor.consignor_id,consignor_name, tbl_consignee.consignee_id,consignee_name, `billing_address_id`,consignee_billing_name, `bill_type`,data_type');
        $this->db->from('tbl_transport_invoice_rate');
        $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_transport_invoice_rate.consignor_id', 'left');
        $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_transport_invoice_rate.consignee_id', 'left');
        $this->db->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_transport_invoice_rate.billing_address_id', 'left');
        $this->db->where('billing_address_id',$billing_address_id);
        $this->db->group_by(array("consignor_id", "consignee_id","bill_type","data_type"));
        $query=$this->db->get();
        return $query->result_array();
    }
}

?>