<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */

class Mdl_invoice extends CI_Model
{

    public $invoiceprefix="ESPL/23-24/";
    public function lastInvoiceNo()
    {
        $query=$this->db->select('invoice_no')
        ->from('tbl_invoice')
        ->where('invoice_date >','2022-03-31')
        ->limit(1,0)
        ->order_by('invoice_id',"desc")
        ->get();
        $data=$query->row();
        
        if(isset($data->invoice_no))
        {
            $arr=explode("/",$data->invoice_no);
            return $arr['2'];
        }
        else
        {
            return "0";
        }
    }
    
    public function getVendorCode($consignee_id,$invoice_type)
    {
        $query=$this->db->select('order_no,vendor_code')
        ->from('tbl_order_no')
        ->where(array('consignee_id' =>$consignee_id,'invoice_type_id'=>$invoice_type ))
        ->get();
        return $query->row();
    }
    
    public function getRentItemForInvoice($consignmentIdArray)
    {
        $query=$this->db->select('sum(qty) as qty,rent_item_name as item_name,price,rent_item_id')
            ->from('tbl_consignment_rent_item')
            ->join('tbl_rent_item', 'tbl_rent_item.rent_item_id = tbl_consignment_rent_item.item_id', 'left')
            ->where_in('consignment_id',$consignmentIdArray)
             ->group_by('tbl_consignment_rent_item.item_id')->get();
             return $query->result_array();
    }
    
    public function getRentItemFormonthlyInvoice($consignee_id)
    {
        $tempdate=date('Y-m-d', strtotime('first day of last month'));
        $lastday= date('Y-m-d', strtotime('last day of previous month'));
        $sql="select t.consignor_id,t.consignee_id, qty,rent_item_name as item_name,price,rent_item_id,consignment_date FROM tbl_consignment AS t 
    left join tbl_consignment_rent_item on tbl_consignment_rent_item.consignment_id=t.consignment_id
    left join tbl_rent_item on tbl_rent_item.rent_item_id=tbl_consignment_rent_item.item_id
    where t.consignee_id =".$consignee_id." and t.consignment_date >= '".$tempdate."' and t.consignment_date < '".$lastday."' and t.consignment_type='1' and tbl_rent_item.rent_type=1 order by consignment_date";
    
        /*$query=$this->db->select('qty,rent_item_name as item_name,price,rent_item_id')
            ->from('tbl_consignment_rent_item')
            ->join('tbl_rent_item', 'tbl_rent_item.rent_item_id = tbl_consignment_rent_item.item_id', 'left')
            ->where_in('consignment_id',$consignmentIdArray)
             ->group_by('tbl_consignment_rent_item.item_id')->get();
             return $query->result_array();*/
             $query=$this->db->query($sql);
             return $query->result_array();
    }
    
     public function getinvoicerent($start="",$length="",$searchstr="",$column,$type)
    {
        //echo 897686; exit();
        $col = (int)$column;
        $arr=array("invoice_id", "invoice_no", "invoice_date", "consignee_name", "total_tax", "invoice_total","round_off","category_name,is_invoice_sent");

        $this->db->select('tbl_invoice.invoice_id, `invoice_no`, `invoice_date`, `consignee_name`,consignee_billing_name, `total_tax`, `invoice_total`, `round_off`, `invoice_type_id`,category_name,is_invoice_sent,invoice_status,max(receipt_date) as receipt_date,tracking_no,courier_name');
        if(!empty($searchstr))
        {
            $where  = "(`invoice_no` LIKE '%$searchstr%' OR ";
            $where .= "`invoice_date` LIKE '%$searchstr%' OR";
            $where .= "`consignee_name` LIKE '%$searchstr%' OR";
            $where .= "`consignee_billing_name` LIKE '%$searchstr%' OR";
            $where .= "`total_tax` LIKE '%$searchstr%' OR";
            $where .= "`round_off` LIKE '%$searchstr%' OR";
            $where .= "`category_name` LIKE '%$searchstr%' OR";
            $where .= "`invoice_total` LIKE '%$searchstr%')";
            $this->db->where($where);
        }

        $tempdb = clone $this->db;
        $this->db->order_by($arr[$col],$type);
        $num_rows = $tempdb->from('tbl_invoice')
        ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_invoice.consignee_id', 'left')
        ->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_invoice.billing_address_id', 'left')
        ->join('tbl_invoice_category', 'tbl_invoice_category.category_id = tbl_invoice.invoice_type_id', 'left')
        ->join('tbl_receipt', 'tbl_receipt.invoice_id = tbl_invoice.invoice_id', 'left')
        ->where('tbl_invoice.invoice_type_id',3)
        ->group_by('tbl_invoice.invoice_id')
        ->count_all_results();

        if($length>0)
        $this->db->limit($length, $start);
        $this->db->from('tbl_invoice');
        $this->db ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_invoice.consignee_id', 'left');
        $this->db ->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_invoice.billing_address_id', 'left');
        $this->db->join('tbl_invoice_category', 'tbl_invoice_category.category_id = tbl_invoice.invoice_type_id', 'left');
        $this->db->join('tbl_receipt', 'tbl_receipt.invoice_id = tbl_invoice.invoice_id', 'left');
        $this->db->where('tbl_invoice.invoice_type_id',3);
        $this->db->group_by('tbl_invoice.invoice_id');
        $this->db->order_by('invoice_id','desc');
        $query=$this->db->get();
        $response['count']=$num_rows;
        $response['data']=$query->result_array();
        //echo $this->db->last_query();
        //exit;
        return $response;
    }

    public function getinvoicetransport($start="",$length="",$searchstr="",$column,$type)
    {
        //echo 897686; exit();
        $col = (int)$column;
        $arr=array("invoice_id", "invoice_no", "invoice_date", "consignee_name", "total_tax", "invoice_total","round_off","category_name,is_invoice_sent");

        $this->db->select('tbl_invoice.invoice_id, `invoice_no`, `invoice_date`, `consignee_name`,consignee_billing_name, `total_tax`, `invoice_total`, `round_off`, `invoice_type_id`,category_name,is_invoice_sent,invoice_status,max(receipt_date) as receipt_date,tracking_no,courier_name');
        if(!empty($searchstr))
        {
            $where  = "(`invoice_no` LIKE '%$searchstr%' OR ";
            $where .= "`invoice_date` LIKE '%$searchstr%' OR";
            $where .= "`consignee_name` LIKE '%$searchstr%' OR";
            $where .= "`consignee_billing_name` LIKE '%$searchstr%' OR";
            $where .= "`total_tax` LIKE '%$searchstr%' OR";
            $where .= "`round_off` LIKE '%$searchstr%' OR";
            $where .= "`category_name` LIKE '%$searchstr%' OR";
            $where .= "`invoice_total` LIKE '%$searchstr%')";
            $this->db->where($where);
        }

        $tempdb = clone $this->db;
        $this->db->order_by($arr[$col],$type);
        $num_rows = $tempdb->from('tbl_invoice')
            ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_invoice.consignee_id', 'left')
            ->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_invoice.billing_address_id', 'left')
            ->join('tbl_invoice_category', 'tbl_invoice_category.category_id = tbl_invoice.invoice_type_id', 'left')
            ->join('tbl_receipt', 'tbl_receipt.invoice_id = tbl_invoice.invoice_id', 'left')
            ->where('tbl_invoice.invoice_type_id',5)
            ->group_by('tbl_invoice.invoice_id')
            ->count_all_results();

        if($length>0)
        $this->db->limit($length, $start);
        $this->db->from('tbl_invoice');
        $this->db ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_invoice.consignee_id', 'left');
        $this->db ->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_invoice.billing_address_id', 'left');
        $this->db->join('tbl_invoice_category', 'tbl_invoice_category.category_id = tbl_invoice.invoice_type_id', 'left');
        $this->db->join('tbl_receipt', 'tbl_receipt.invoice_id = tbl_invoice.invoice_id', 'left');
        $this->db->where('tbl_invoice.invoice_type_id',5);
      
        //$date_to='2021-04-15';
        //$date_from='2021-01-01';
        //if($date_from!=''){ $this->db->where('tbl_invoice.invoice_date >=', $date_from); }
        //if($date_to!=''){ $this->db->where('tbl_invoice.invoice_date <=', $date_to); }
      
      
      
        $this->db->group_by('tbl_invoice.invoice_id');
        $this->db->order_by('invoice_id','desc');
        $query=$this->db->get();
        $response['count']=$num_rows;
        $response['data']=$query->result_array();
        //echo $this->db->last_query();
        //exit;
        return $response;
    }
  
  
    public function getpendingtransportconsignments($transport_invoice_rate_id)
    {
        $query=$this->db->select("`transport_invoice_rate_id`, `consignor_id`, `consignee_id`, `billing_address_id`, `bill_type`, `ref_id`, `amount`, `data_type`")
        ->from("tbl_transport_invoice_rate")
        ->where("transport_invoice_rate_id",$transport_invoice_rate_id)
        ->get();
        $row=$query->row();
        if($row->data_type=="0")
        {
            //outward
            $this->db->select('consignment_id,`invoice_id`,consignment_no, consignment_date, consignor_name, consignee_name, bill_type, vehicle_inward_no,tbl_consignment.driver_name,consignment_status');
            $this->db->from('tbl_consignment');
            $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_consignment.consignor_id', 'left');
            $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_consignment.consignee_id', 'left');
            $this->db->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_consignment.vehicle_id', 'left');
            $this->db->where('tbl_consignment.consignor_id',$row->consignor_id);
            $this->db->where('tbl_consignment.consignee_id',$row->consignee_id);
            $this->db->where('tbl_consignment.invoice_id','0');
            $this->db->order_by('consignment_no','desc');
            $query=$this->db->get();
           return $query->result_array();

        }
        else
        {
            //inward
            $this->db->select('inward_id as consignment_id,inward_no as consignment_no, inward_date as consignment_date, consignor_name, consignee_name, vehicle_inward_no, driver_name, "1" as consignment_status,"0" as bill_type');
            $this->db->from('tbl_inward');
            $this->db->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_inward.source_id', 'left');
            $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_inward.destiantion_id', 'left');
            $this->db->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_inward.vehicle_id', 'left');
            $this->db->where('tbl_inward.source_id',$row->consignor_id);
            $this->db->where('tbl_inward.destiantion_id',$row->consignee_id);
            $this->db->where('tbl_inward.invoice_id','0');
            //$this->db->order_by('vehicle_inward_id','desc');
            $query=$this->db->get();
            return $query->result_array();
        }
    }
    
     public function getpendingtransportconsignments_old($post)
    {
        //echo "<pre>";
//        for($i=0;$i<sizeof($post['transport_invoice_rate_id']);$i++){
//          //  print_r($post);
//        }
//        exit();
        for($i=0;$i<sizeof($post['transport_invoice_rate_id']);$i++) {
            $billtype = $post['bill_type'][$i];
            $data_type = $post['data_type'][$i];
            if ($billtype == "1") {
                $tblname = "tbl_item";
                if ($data_type == "0") {
                    //echo 298; exit();
                    $query = $this->db->select('tbl_consignment.consignment_id,tbl_consignment.consignment_no,
                     tbl_consignment.consignment_date,tbl_consignment.invoice_id,consignor_name,
                     consignee_name,tbl_consignment.consignor_id,tbl_consignment.consignee_id,
                     tbl_item.item_id,tbl_item.item_name,qty,bill_type,vehicle_inward_no,tbl_consignment.driver_name,consignment_status')
                        ->from('tbl_consignment')
                        ->join('tbl_consignor', 'tbl_consignor.consignor_id = tbl_consignment.consignor_id', 'left')
                        ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_consignment.consignee_id', 'left')
                        ->join('tbl_consignment_stock_item', 'tbl_consignment_stock_item.consignment_id=tbl_consignment.consignment_id', 'left')
                        ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id = tbl_consignment.vehicle_id', 'left')
//                        ->join('tbl_transport_invoice_rate', 'tbl_transport_invoice_rate.ref_id=tbl_consignment_stock_item.item_id', 'left')
                        ->join('tbl_item', 'tbl_item.item_id=tbl_consignment_stock_item.item_id', 'left')
                        ->where(array('tbl_consignment.consignor_id' => $post['consignor_id'][$i], 'tbl_consignment.consignee_id' => $post['consignee_id'][$i],
                            //'tbl_transport_invoice_rate.consignor_id' => $post['consignor_id'][$i], 'tbl_transport_invoice_rate.consignee_id' => $post['consignee_id'][$i],
                            //'tbl_transport_invoice_rate.bill_type' => "1", 'tbl_transport_invoice_rate.data_type' => "0",
                             'tbl_consignment.invoice_id' => "0",
                        ))
//                        ->group_by('item_id')
                        ->get();

//                    $query = $this->db->select('tbl_consignment.consignment_id,item_name, tbl_item.item_id, amount, sum(qty) as qty')
//                        ->from('tbl_consignment')
//                        ->join('tbl_consignment_stock_item', 'tbl_consignment_stock_item.consignment_id=tbl_consignment.consignment_id', 'left')
//                        ->join('tbl_transport_invoice_rate', 'tbl_transport_invoice_rate.ref_id=tbl_consignment_stock_item.item_id', 'left')
//                        ->join('tbl_item', 'tbl_item.item_id=tbl_consignment_stock_item.item_id', 'left')
//                        ->where(array('tbl_consignment.consignor_id' => $post['consignor_id'][$i], 'tbl_consignment.consignee_id' => $post['consignee_id'][$i],
//                            'tbl_transport_invoice_rate.consignor_id' => $post['consignor_id'][$i], 'tbl_transport_invoice_rate.consignee_id' => $post['consignee_id'][$i],
//                            'tbl_transport_invoice_rate.bill_type' => "1", 'tbl_transport_invoice_rate.data_type' => "0"
//                        ))
//                        ->group_by('item_id')
//                        ->get();

//                    $query=$this->db->select('tbl_consignment.consignment_id,item_name, tbl_item.item_id, amount, sum(qty) as qty')
//                    ->from('tbl_consignment')
//                    ->join('tbl_consignment_stock_item', 'tbl_consignment_stock_item.consignment_id=tbl_consignment.consignment_id', 'left')
//                    ->join('tbl_transport_invoice_rate', 'tbl_transport_invoice_rate.ref_id=tbl_consignment_stock_item.item_id', 'left')
//                    ->join('tbl_item', 'tbl_item.item_id=tbl_consignment_stock_item.item_id', 'left')
//                    ->where(array('tbl_consignment.consignor_id' =>$post['consignor_id'][$i] , 'tbl_consignment.consignee_id' =>$post['consignee_id'][$i] , 'tbl_transport_invoice_rate.consignor_id' => $post['consignor_id'][$i], 'tbl_transport_invoice_rate.consignee_id' =>$post['consignee_id'][$i] ,'tbl_transport_invoice_rate.bill_type'=>"1",'tbl_transport_invoice_rate.data_type'=>"0",'tbl_consignment.consignment_date <'=>$comparedate,'tbl_consignment.consignment_date >='=>$tempdate ))
//                    ->group_by('item_id')
//                    ->get();
//                    echo $this->db->last_query();
//                    exit();
                } else {
                   // echo 444; exit();
                    $query = $this->db->select('tbl_inward.inward_id,item_name, tbl_item.item_id, amount, sum(qty) as qty')
                        ->from('tbl_inward')
                        ->join('tbl_inward_details', 'tbl_inward_details.inward_id=tbl_inward.inward_id', 'left')
                        ->join('tbl_transport_invoice_rate', 'tbl_transport_invoice_rate.ref_id=tbl_consignment_stock_item.item_id', 'left')
                        ->join('tbl_item', 'tbl_item.item_id=tbl_inward_details.item_id', 'left')
                        ->where(array('tbl_inward.source_id' => $post['consignor_id'][$i], 'tbl_inward.destiantion_id' => $post['consignee_id'][$i], 'tbl_transport_invoice_rate.consignor_id' => $post['consignor_id'][$i], 'tbl_transport_invoice_rate.consignee_id' => $post['consignee_id'][$i], 'tbl_transport_invoice_rate.bill_type' => "1", 'tbl_transport_invoice_rate.data_type' => "1",
                          ))
                        ->group_by('item_id')
                        ->get();
//                    echo $this->db->last_query();
//                    exit();
                }
            } else {
                //echo 3; exit();
                $tblname = "tbl_vehicle_inward";
                if ($data_type == "0") {
                   // echo 643; exit();
                    $query = $this->db->select('tbl_consignment.consignment_id,tbl_consignment.consignment_no,tbl_consignment.invoice_id,consignment_date,  vehicle_type, amount, tbl_vehicle_inward.vehicle_type_id as item_id, count(tbl_vehicle_inward.vehicle_type_id) as qty')
                        ->from('tbl_consignment')
                        ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id=tbl_consignment.vehicle_id', 'left')
                        ->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id=tbl_vehicle_inward.vehicle_type_id', 'left')
                        ->join('tbl_transport_invoice_rate', 'tbl_transport_invoice_rate.ref_id=tbl_vehicle_type.vehicle_type_id', 'left')
                        ->where(array('tbl_consignment.consignor_id' => $post['consignor_id'][$i], 'tbl_consignment.consignee_id' => $post['consignee_id'][$i], 'tbl_transport_invoice_rate.consignor_id' => $post['consignor_id'][$i], 'tbl_transport_invoice_rate.consignee_id' => $post['consignee_id'][$i], 'tbl_transport_invoice_rate.bill_type' => "0", 'invoice_id' => "0", "amount>" => '0'))
                        ->group_by('tbl_vehicle_inward.vehicle_type_id')
                        ->get();
                    //  echo $this->db->last_query();
                }
                else
                {
                    // echo 898; exit();
                    $query = $this->db->select('tbl_inward.inward_id,inward_date,  vehicle_type, amount, tbl_vehicle_inward.vehicle_type_id as item_id, count(tbl_vehicle_inward.vehicle_type_id) as qty')
                        ->from('tbl_inward')
                        ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id=tbl_inward.vehicle_id', 'left')
                        ->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id=tbl_vehicle_inward.vehicle_type_id', 'left')
                        ->join('tbl_transport_invoice_rate', 'tbl_transport_invoice_rate.ref_id=tbl_vehicle_type.vehicle_type_id', 'left')
                        ->where(array('tbl_inward.source_id' => $post['consignor_id'][$i], 'tbl_inward.destiantion_id' => $post['consignee_id'][$i], 'tbl_transport_invoice_rate.consignor_id' => $post['consignor_id'][$i], 'tbl_transport_invoice_rate.consignee_id' => $post['consignee_id'][$i], 'tbl_transport_invoice_rate.bill_type' => "0", 'tbl_transport_invoice_rate.data_type' => "1", 'invoice_id' => "0", 'invoice_id' => "0", 'tbl_inward.inward_date <' => $comparedate, 'tbl_inward.inward_date >=' => $tempdate))
                        ->group_by('tbl_vehicle_inward.vehicle_type_id')
                        ->get();
                    //echo $this->db->last_query();
                }
            }
        }
           // echo $this->db->last_query();
            // exit();

         return $result = $query->result_array();
          //  print_r($result);
           // exit();
            //$insertdata = array();



        //exit();
    }
    
    public function getTaxDetails($category_id)
    {
        $query=$this->db->select('hsn_code,tax_rate')
        ->from('tbl_invoice_category')
        ->where('category_id',$category_id)
        ->get();
        return $query->row();
    }
    
    public function getbillingaddress($consignee_id)
    {
        $query=$this->db->select('billing_id')
        ->from('tbl_consignee')
        ->where('consignee_id',$consignee_id)
        ->get();
        $data=$query->row();
        return $data->billing_id;
    }
    
    public function saverentinvoice($post)
    {
        $temp_no=$this->lastInvoiceNo(); 
        $temp_no=$temp_no+1; 
        $invoice_no=$this->invoiceprefix.$temp_no;
        $invoice_date=date('Y-m-d');
        $order_details=$this->getVendorCode($post['consignee_name'],'3');
        if(isset($order_details->vendor_code))
        {
            $vendor_code=$order_details->vendor_code;
        }
        else
        {
           $vendor_code="";  
        }
        if(isset($order_details->order_no))
        {
            $order_no=$order_details->order_no;
  
        }
        else
        { 
           $order_no=""; 
        }
        
        $consignee_id=$post['consignee_name'];
        $billing_id=$this->getbillingaddress($consignee_id);
        $invoice_type_id="3";
        $total_tax=0;
        $invoice_total=0;
        $round_off=0;
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("invoice_no"=>$invoice_no,"invoice_date"=>$invoice_date,"order_no"=>$order_no,"vendor_code"=>$vendor_code,"consignee_id"=>$consignee_id,"invoice_type_id"=>$invoice_type_id,"billing_address_id"=>$billing_id,"created_by"=>$user_id,"created_datetime"=>$datetime);
        //var_dump($data);
        //exit;
        $this->db->insert('tbl_invoice',$data);
        $invoice_id=$this->db->insert_id();
        $gstdetails=$this->getTaxDetails('3');

        
        /* invoice details work*/
        $bill_type=0;
        if(isset($_POST['bill_type']))
            $bill_type=$post['bill_type'];
        if($bill_type=='1')
        {
            /* Monthly rent calculation*/
            $itemidary=$this->getRentItemFormonthlyInvoice($post['consignee_name']);
            $tempdate=date('Y-m-d', strtotime('first day of last month'));
            $qry=$this->db->select('tbl_consignment.consignment_id,tbl_consignment.consignor_id,tbl_consignment.consignee_id,consignment_date,qty,item_id')
        ->from('tbl_consignment')
        ->join('tbl_consignment_rent_item', 'tbl_consignment_rent_item.consignment_id = tbl_consignment.consignment_id', 'left')
        ->where(array('consignment_type' => 1,'consignee_id '=>$post['consignee_name']))
        ->where('tbl_consignment.consignment_date <',$tempdate)
        ->order_by('tbl_consignment.consignment_id','desc')->get();
            $lastqty=$qry->row();
            $qty=$lastqty->qty;
             $tempdate=date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $tempdate) ) ));
            $item_id=0;
            $price=0;
            
            for($i=0;$i<=sizeof($itemidary);$i++)
            {
                if(isset($itemidary[$i]))
                    $row=$itemidary[$i];
                else
                    $row=[];
                $invoice_id=$invoice_id;
                if(isset($row['rent_item_id']))
                {
                    $item_id=$row['rent_item_id'];
                }
                
                $gst_rate=$gstdetails->tax_rate;
                
                $attribute_name='Day';
                //$date1=date_create("2013-03-15");
                //$date2=date_create("2013-03-18");
                if(isset($row['consignment_date']))
                {
                    $diff=date_diff(date_create($row['consignment_date']),date_create($tempdate));
                    echo $row['consignment_date'].",".$tempdate."<br/>";
                    $tempdate=$row['consignment_date'];
                }
                else
                {
                    $lastday= date('Y-m-d', strtotime('last day of previous month'));
                    $diff=date_diff(date_create($tempdate),date_create($lastday));
                    echo "else".$tempdate.$lastday."<br/>";

                }
                
                $attribute_value=$diff->format("%a");
                if($attribute_value==0)
                    $attribute_value=1;
                echo $attribute_value."<br/>";
                if(isset($row['price']))
                    $price=$row['price'];
                //$price=$row['price'];
                $total=$qty*$price*$attribute_value;
                $gst_amount=($total*$gst_rate)/100;
                $total_tax+=$gst_amount;
                $invoice_total+=$total+$gst_amount;
                $data=array("invoice_id"=>$invoice_id,"item_id"=>$item_id,"gst_rate"=>$gst_rate,"qty"=>$qty,"price"=>$price,"gst_amount"=>$gst_amount,"ref_table_name"=>'tbl_rent_item','attribute_value'=>$attribute_value,'attribute_name'=>$attribute_name);
                $this->db->insert('invoice_details',$data);
                if(isset($row['qty']))
                    $qty=$row['qty'];
            }
            
            
        }
        else{
            $itemidary=$this->getRentItemForInvoice($post['consignment_id']);
            foreach ($itemidary as $row) {
                $invoice_id=$invoice_id;
                $item_id=$row['rent_item_id'];
                $gst_rate=$gstdetails->tax_rate;
                $qty=$row['qty'];
                $price=$row['price'];
                $total=$qty*$price;
                $gst_amount=($total*$gst_rate)/100;
                $total_tax+=$gst_amount;
                $invoice_total+=$total+$gst_amount;
                $data=array("invoice_id"=>$invoice_id,"item_id"=>$item_id,"gst_rate"=>$gst_rate,"qty"=>$qty,"price"=>$price,"gst_amount"=>$gst_amount,"ref_table_name"=>'tbl_rent_item');
                $this->db->insert('invoice_details',$data);
            }
        }
        //var_dump($itemidary);
        //exit;
        
        $roundoff=round($invoice_total)-$invoice_total;
        $invoice_total=round($invoice_total);
        $data=array("total_tax"=>$total_tax,"invoice_total"=>$invoice_total,"round_off"=>$roundoff);
        $this->db->where('invoice_id',$invoice_id);
        $this->db->update('tbl_invoice',$data);
        if($bill_type!='1')
        {
            $data=array('invoice_id'=>$invoice_id);
            $this->db->where_in('consignment_id',$post['consignment_id']);
            $this->db->update('tbl_consignment',$data);
        }
        //$this->db->insert('tbl_invoice_category',$data);
        return $this->db->insert_id();
    }
    
    
    public function savewarehouserentinvoice($post)
    {
        $temp_no=$this->lastInvoiceNo();
        $temp_no=$temp_no+1;
        $invoice_no=$this->invoiceprefix.$temp_no;
        $invoice_date=date('Y-m-d');
        $order_details=$this->getVendorCode($_POST['consignee_name'],'4');
        if(!empty($order_details->vendor_code))
            $vendor_code=$order_details->vendor_code;
        else
            $vendor_code="";

        if(!empty($order_details->order_no))
            $order_no=$order_details->order_no;
        else
            $order_no="";
        //$order_no=$order_details->order_no;
        $consignee_id=$post['consignee_name'];
        $billing_id=$this->getbillingaddress($consignee_id);
        $invoice_type_id="4";
        $total_tax=0;
        $invoice_total=0;
        $round_off=0;
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("invoice_no"=>$invoice_no,"invoice_date"=>$invoice_date,"order_no"=>$order_no,"vendor_code"=>$vendor_code,"consignee_id"=>$consignee_id,"invoice_type_id"=>$invoice_type_id,"billing_address_id"=>$billing_id,"created_by"=>$user_id,"created_datetime"=>$datetime);
        //var_dump($data);
        //exit;
        $this->db->insert('tbl_invoice',$data);
        $invoice_id=$this->db->insert_id();
        $gstdetails=$this->getTaxDetails('3');

        
        /* invoice details work*/
        $query=$this->db->select('`rent_warehouse_id`, `rent_warehouse_area`, `price`')
            ->from('tbl_rent_warehouse')
            ->where(array("tbl_rent_warehouse.consignee_id"=>$consignee_id))
            ->get();
        $itemidary=$query->result_array();
        //$itemidary=$this->getRentItemForInvoice($post['consignment_id']);

        foreach ($itemidary as $row) {
            $invoice_id=$invoice_id;
            $item_id=$row['rent_warehouse_id'];
            $gst_rate=$gstdetails->tax_rate;
            $qty=$row['rent_warehouse_area'];
            $price=$row['price'];
            $total=$qty*$price;
            $gst_amount=($total*$gst_rate)/100;
            $total_tax+=$gst_amount;
            $invoice_total+=$total+$gst_amount;
            $data=array("invoice_id"=>$invoice_id,"gst_rate"=>$gst_rate,"qty"=>$qty,"price"=>$price,"gst_amount"=>$gst_amount,"ref_table_name"=>'tbl_rent_warehouse');
            $this->db->insert('invoice_details',$data);
        }
        $roundoff=round($invoice_total)-$invoice_total;
        $invoice_total=round($invoice_total);
        $data=array("total_tax"=>$total_tax,"invoice_total"=>$invoice_total,"round_off"=>$roundoff);
        $this->db->where('invoice_id',$invoice_id);
        $this->db->update('tbl_invoice',$data);
        
        $data=array('invoice_id'=>$invoice_id);
        //exit;
        //$this->db->where_in('consignment_id',$post['consignment_id']);
        //$this->db->update('tbl_consignment',$data);
        //$this->db->insert('tbl_invoice_category',$data);
        //return $this->db->insert_id();
    }
    
    public function savetransportinvoice($post)
    {
        $temp_no=$this->lastInvoiceNo();
        $temp_no=$temp_no+1;
        $invoice_no=$this->invoiceprefix.$temp_no;
        $invoice_date=date('Y-m-d');
        $order_details=$this->getVendorCode($_POST['consignee_id']['0'],'5');
        if(is_null($order_details))
        {
            //echo "if";
            $vendor_code="";
            $order_no="";
        }
        else
        {
            $vendor_code=$order_details->vendor_code;
            $order_no=$order_details->order_no;
        }
        
        $billing_address_id=$post['billing_address_id'];
        $invoice_type_id="5";
        $total_tax=0;
        $invoice_total=0;
        $round_off=0;
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("invoice_no"=>$invoice_no,"invoice_date"=>$invoice_date,"order_no"=>$order_no,"vendor_code"=>$vendor_code,"billing_address_id"=>$billing_address_id,"invoice_type_id"=>$invoice_type_id,"created_by"=>$user_id,"created_datetime"=>$datetime);
        //var_dump($data);
        //exit;
        $this->db->insert('tbl_invoice',$data);
        $invoice_id=$this->db->insert_id();
        $gstdetails=$this->getTaxDetails('5');
        $comparedate=date('Y-m-01');
        //$comparedate=date('Y-m-d', strtotime('+1 month'));
        $tempdate=date('Y-m-d', strtotime('first day of last month'));
        //$tempdate=date('Y-m-01');
        //$tempdate=date('Y-01-01');
        
        for($i=0;$i<sizeof($post['consignor_id']);$i++)
        {
            $billtype=$post['bill_type'][$i];
            $data_type=$post['data_type'][$i];
            if($billtype=="1")
            {
                $tblname="tbl_item";
                if($data_type=="0")
                {
                    $query=$this->db->select('tbl_consignment.consignment_id,item_name, tbl_item.item_id, amount, sum(qty) as qty')
                    ->from('tbl_consignment')
                    ->join('tbl_consignment_stock_item', 'tbl_consignment_stock_item.consignment_id=tbl_consignment.consignment_id', 'left')
                    ->join('tbl_transport_invoice_rate', 'tbl_transport_invoice_rate.ref_id=tbl_consignment_stock_item.item_id', 'left')
                    ->join('tbl_item', 'tbl_item.item_id=tbl_consignment_stock_item.item_id', 'left')
                    ->where(array('tbl_consignment.consignor_id' =>$post['consignor_id'][$i] , 'tbl_consignment.consignee_id' =>$post['consignee_id'][$i] , 'tbl_transport_invoice_rate.consignor_id' => $post['consignor_id'][$i], 'tbl_transport_invoice_rate.consignee_id' =>$post['consignee_id'][$i] ,'tbl_transport_invoice_rate.bill_type'=>"1",'tbl_transport_invoice_rate.data_type'=>"0",'invoice_id'=>"0",'tbl_consignment.consignment_date <'=>$comparedate,'tbl_consignment.consignment_date >='=>$tempdate ))
                    ->group_by('item_id')
                    ->get();
                }
                else
                {
                    $query=$this->db->select('tbl_inward.inward_id,item_name, tbl_item.item_id, amount, sum(qty) as qty')
                    ->from('tbl_inward')
                    ->join('tbl_inward_details', 'tbl_inward_details.inward_id=tbl_inward.inward_id', 'left')
                    ->join('tbl_transport_invoice_rate', 'tbl_transport_invoice_rate.ref_id=tbl_consignment_stock_item.item_id', 'left')
                    ->join('tbl_item', 'tbl_item.item_id=tbl_inward_details.item_id', 'left')
                    ->where(array('tbl_inward.source_id' =>$post['consignor_id'][$i] , 'tbl_inward.destiantion_id' =>$post['consignee_id'][$i] , 'tbl_transport_invoice_rate.consignor_id' => $post['consignor_id'][$i], 'tbl_transport_invoice_rate.consignee_id' =>$post['consignee_id'][$i] ,'tbl_transport_invoice_rate.bill_type'=>"1",'tbl_transport_invoice_rate.data_type'=>"1",'invoice_id'=>"0",'tbl_inward.inward_date <'=>$comparedate,'tbl_inward.inward_date >='=>$tempdate ))
                    ->group_by('item_id')
                    ->get();
                }
                
            }
            else
            {
                $tblname="tbl_vehicle_inward";                
                if($data_type=="0")
                {
                    $query=$this->db->select('tbl_consignment.consignment_id,consignment_date,  vehicle_type, amount, tbl_vehicle_inward.vehicle_type_id as item_id, count(tbl_vehicle_inward.vehicle_type_id) as qty')
                    ->from('tbl_consignment')
                    ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id=tbl_consignment.vehicle_id', 'left')
                    ->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id=tbl_vehicle_inward.vehicle_type_id', 'left')
                    ->join('tbl_transport_invoice_rate', 'tbl_transport_invoice_rate.ref_id=tbl_vehicle_type.vehicle_type_id', 'left')
                    ->where(array('tbl_consignment.consignor_id' =>$post['consignor_id'][$i] , 'tbl_consignment.consignee_id' =>$post['consignee_id'][$i] , 'tbl_transport_invoice_rate.consignor_id' => $post['consignor_id'][$i], 'tbl_transport_invoice_rate.consignee_id' =>$post['consignee_id'][$i] ,'tbl_transport_invoice_rate.bill_type'=>"0",'invoice_id'=>"0","amount>"=>'0','tbl_consignment.consignment_date <'=>$comparedate,'tbl_consignment.consignment_date >='=>$tempdate ))
                    ->group_by('tbl_vehicle_inward.vehicle_type_id')
                    ->get();
                }
                else
                {
                    $query=$this->db->select('tbl_inward.inward_id,inward_date,  vehicle_type, amount, tbl_vehicle_inward.vehicle_type_id as item_id, count(tbl_vehicle_inward.vehicle_type_id) as qty')
                    ->from('tbl_inward')
                    ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id=tbl_inward.vehicle_id', 'left')
                    ->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id=tbl_vehicle_inward.vehicle_type_id', 'left')
                    ->join('tbl_transport_invoice_rate', 'tbl_transport_invoice_rate.ref_id=tbl_vehicle_type.vehicle_type_id', 'left')
                    ->where(array('tbl_inward.source_id' =>$post['consignor_id'][$i] , 'tbl_inward.destiantion_id' =>$post['consignee_id'][$i] , 'tbl_transport_invoice_rate.consignor_id' => $post['consignor_id'][$i], 'tbl_transport_invoice_rate.consignee_id' =>$post['consignee_id'][$i] ,'tbl_transport_invoice_rate.bill_type'=>"0",'tbl_transport_invoice_rate.data_type'=>"1",'invoice_id'=>"0",'invoice_id'=>"0",'tbl_inward.inward_date <'=>$comparedate,'tbl_inward.inward_date >='=>$tempdate ))
                    ->group_by('tbl_vehicle_inward.vehicle_type_id')
                    ->get();
                }
            }

            $result=$query->result_array();
            
            $insertdata=array();
            
            foreach ($result as $row) {
                $invoice_id=$invoice_id;
                $item_id=$row['item_id'];
                $gst_rate=$gstdetails->tax_rate;
                $qty=$row['qty'];
                $price=$row['amount'];
                $total=$qty*$price;
                $gst_amount=($total*$gst_rate)/100;
                $total_tax+=$gst_amount;
                $invoice_total+=$total+$gst_amount;
                $bill_data_type=$data_type;
                $data=array("invoice_id"=>$invoice_id,"item_id"=>$item_id,"gst_rate"=>$gst_rate,"qty"=>$qty,"price"=>$price,"gst_amount"=>$gst_amount,"ref_table_name"=>$tblname,'bill_data_type'=>$bill_data_type);
                array_push($insertdata, $data);
                
            }
            if(sizeof($insertdata)>0)
            {
                $this->db->insert_batch('invoice_details',$insertdata);
                $data=array('invoice_id'=>$invoice_id);
                if($data_type=="0")
                {
                    $qry=$this->db->select('consignment_id')
                    ->from('tbl_consignment')
                    ->where(array('`tbl_consignment`.`consignor_id`' =>$post['consignor_id'][$i] ,'`tbl_consignment`.`consignee_id`' =>$post['consignee_id'][$i],'tbl_consignment.consignment_date <'=>$comparedate,'tbl_consignment.consignment_date >='=>$tempdate))
                    ->get();
                    $consignment_idary=array();
                    foreach ($qry->result_array() as $row) {
                        array_push($consignment_idary, $row['consignment_id']);
                    }

                    $this->db->where_in('consignment_id',$consignment_idary);
                    $this->db->update('tbl_consignment',$data);
                }
                else
                {
                    $qry=$this->db->select('inward_id')
                    ->from('tbl_inward')
                    ->where(array('`tbl_inward`.`source_id`' =>$post['consignor_id'][$i] ,'`tbl_inward`.`destiantion_id`' =>$post['consignee_id'][$i],'tbl_inward.inward_date <'=>$comparedate,'tbl_inward.inward_date >='=>$tempdate))
                    ->get();
                    $consignment_idary=array();
                    foreach ($qry->result_array() as $row) {
                        array_push($consignment_idary, $row['inward_id']);
                    }

                    $this->db->where_in('inward_id',$consignment_idary);
                    $this->db->update('tbl_inward',$data);
                }
                $data = array('invoice_id' => $invoice_id,'consignor_id'=>$post['consignor_id'][$i],'consignor_id'=>$post['consignee_id'][$i]);
                $this->db->insert('tbl_invoice_billing_details',$data);
            }
            
        }

        $roundoff=round($invoice_total)-$invoice_total;
        $invoice_total=round($invoice_total);
        $data=array("total_tax"=>$total_tax,"invoice_total"=>$invoice_total,"round_off"=>$roundoff);
        $this->db->where('invoice_id',$invoice_id);
        $this->db->update('tbl_invoice',$data);
        if($invoice_total<1)
        {
            $this->db->where('invoice_id',$invoice_id);
            $this->db->delete('tbl_invoice');
        }

    }
    public function TransportCreateConsignmentInvoice($post)
    {
        $query=$this->db->select("`transport_invoice_rate_id`, `consignor_id`, `consignee_id`, `billing_address_id`, `bill_type`, `ref_id`, `amount`, `data_type`")
        ->from("tbl_transport_invoice_rate")
        ->where("transport_invoice_rate_id",$post['transport_invoice_rate_id'])
        ->get();
        $pricerow=$query->row();
        $consignment_id_ary=[];
        if(!isset($_POST['consignment_id']))
        {
            echo "select 1 record";
            exit;
        }

        for($i=0;$i<sizeof($_POST['consignment_id']);$i++)
        {
            array_push($consignment_id_ary,$_POST['consignment_id'][$i]);
        }
        if(sizeof($consignment_id_ary)<=0)
        {
            echo "select 1 record";
            exit;
        }
        $temp_no=$this->lastInvoiceNo();
        $temp_no=$temp_no+1;
        $invoice_no=$this->invoiceprefix.$temp_no;
        $invoice_date=date('Y-m-d');
        $order_details=$this->getVendorCode($pricerow->consignee_id,'5');
        if(is_null($order_details))
        {
            //echo "if";
            $vendor_code="";
            $order_no="";
        }
        else
        {
            $vendor_code=$order_details->vendor_code;
            $order_no=$order_details->order_no;
        }
        
        $billing_address_id=$pricerow->billing_address_id;
        $invoice_type_id="5";
        $total_tax=0;
        $invoice_total=0;
        $round_off=0;
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("invoice_no"=>$invoice_no,"invoice_date"=>$invoice_date,"order_no"=>$order_no,"vendor_code"=>$vendor_code,"billing_address_id"=>$billing_address_id,"invoice_type_id"=>$invoice_type_id,"created_by"=>$user_id,"created_datetime"=>$datetime);
        //var_dump($data);
        //exit;
        $this->db->insert('tbl_invoice',$data);
        $invoice_id=$this->db->insert_id();
        $gstdetails=$this->getTaxDetails('5');
        $comparedate=date('Y-m-01');
        //$comparedate=date('Y-m-d', strtotime('+1 month'));
        $tempdate=date('Y-m-d', strtotime('first day of last month'));
        //$tempdate=date('Y-m-01');
        //$tempdate=date('Y-01-01');
        
        
            $billtype=$pricerow->bill_type;
            $data_type=$pricerow->data_type;
            if($billtype=="1")
            {
                $tblname="tbl_item";
                if($data_type=="0")
                {
                    $query=$this->db->select('tbl_consignment.consignment_id,item_name, tbl_item.item_id, amount, sum(qty) as qty')
                    ->from('tbl_consignment')
                    ->join('tbl_consignment_stock_item', 'tbl_consignment_stock_item.consignment_id=tbl_consignment.consignment_id', 'left')
                    ->join('tbl_transport_invoice_rate', 'tbl_transport_invoice_rate.ref_id=tbl_consignment_stock_item.item_id', 'left')
                    ->join('tbl_item', 'tbl_item.item_id=tbl_consignment_stock_item.item_id', 'left')
                    ->where(array('tbl_consignment.consignor_id' =>$pricerow->consignor_id, 'tbl_consignment.consignee_id' =>$pricerow->consignee_id , 'tbl_transport_invoice_rate.consignor_id' => $pricerow->consignor_id, 'tbl_transport_invoice_rate.consignee_id' =>$pricerow->consignee_id ,'tbl_transport_invoice_rate.bill_type'=>"1",'tbl_transport_invoice_rate.data_type'=>"0",'invoice_id'=>"0" ))
                    ->where_in('tbl_consignment.consignment_id', $consignment_id_ary)
                    ->group_by('item_id')
                    ->get();

                }
                else
                {
                    $query=$this->db->select('tbl_inward.inward_id,item_name, tbl_item.item_id, amount, sum(qty) as qty')
                    ->from('tbl_inward')
                    ->join('tbl_inward_details', 'tbl_inward_details.inward_id=tbl_inward.inward_id', 'left')
                    ->join('tbl_transport_invoice_rate', 'tbl_transport_invoice_rate.ref_id=tbl_consignment_stock_item.item_id', 'left')
                    ->join('tbl_item', 'tbl_item.item_id=tbl_inward_details.item_id', 'left')
                    ->where(array('tbl_inward.source_id' =>$pricerow->consignor_id, 'tbl_inward.destiantion_id' =>$pricerow->consignee_id , 'tbl_transport_invoice_rate.consignor_id' => $pricerow->consignor_id, 'tbl_transport_invoice_rate.consignee_id' =>$pricerow->consignee_id ,'tbl_transport_invoice_rate.bill_type'=>"1",'tbl_transport_invoice_rate.data_type'=>"1",'invoice_id'=>"0" ))
                    ->where_in('tbl_inward.inward_id', $consignment_id_ary)
                    ->group_by('item_id')
                    ->get();
                }
                
            }
            else
            {
                $tblname="tbl_vehicle_inward";                
                if($data_type=="0")
                {
                    $query=$this->db->select('tbl_consignment.consignment_id,consignment_date,  vehicle_type, amount, tbl_vehicle_inward.vehicle_type_id as item_id, count(tbl_vehicle_inward.vehicle_type_id) as qty')
                    ->from('tbl_consignment')
                    ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id=tbl_consignment.vehicle_id', 'left')
                    ->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id=tbl_vehicle_inward.vehicle_type_id', 'left')
                    ->join('tbl_transport_invoice_rate', 'tbl_transport_invoice_rate.ref_id=tbl_vehicle_type.vehicle_type_id', 'left')
                    ->where(array('tbl_consignment.consignor_id' =>$pricerow->consignor_id, 'tbl_consignment.consignee_id' =>$pricerow->consignee_id , 'tbl_transport_invoice_rate.consignor_id' => $pricerow->consignor_id, 'tbl_transport_invoice_rate.consignee_id' =>$pricerow->consignee_id ,'tbl_transport_invoice_rate.bill_type'=>"0",'invoice_id'=>"0","amount>"=>'0' ))
                    ->where_in('tbl_consignment.consignment_id', $consignment_id_ary)
                    ->group_by('tbl_vehicle_inward.vehicle_type_id')
                    ->get();
                }
                else
                {
                    $query=$this->db->select('tbl_inward.inward_id,inward_date,  vehicle_type, amount, tbl_vehicle_inward.vehicle_type_id as item_id, count(tbl_vehicle_inward.vehicle_type_id) as qty')
                    ->from('tbl_inward')
                    ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id=tbl_inward.vehicle_id', 'left')
                    ->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id=tbl_vehicle_inward.vehicle_type_id', 'left')
                    ->join('tbl_transport_invoice_rate', 'tbl_transport_invoice_rate.ref_id=tbl_vehicle_type.vehicle_type_id', 'left')
                    ->where(array('tbl_inward.source_id' =>$pricerow->consignor_id, 'tbl_inward.destiantion_id' =>$pricerow->consignee_id , 'tbl_transport_invoice_rate.consignor_id' => $pricerow->consignor_id, 'tbl_transport_invoice_rate.consignee_id' =>$pricerow->consignee_id ,'tbl_transport_invoice_rate.bill_type'=>"0",'tbl_transport_invoice_rate.data_type'=>"1",'invoice_id'=>"0",'invoice_id'=>"0" ))
                    ->where_in('tbl_inward.inward_id', $consignment_id_ary)
                    ->group_by('tbl_vehicle_inward.vehicle_type_id')
                    ->get();
                }
            }

            $result=$query->result_array();
            
            $insertdata=array();
            
            foreach ($result as $row) {
                $invoice_id=$invoice_id;
                $item_id=$row['item_id'];
                $gst_rate=$gstdetails->tax_rate;
                $qty=$row['qty'];
                $price=$row['amount'];
                $total=$qty*$price;
                $gst_amount=($total*$gst_rate)/100;
                $total_tax+=$gst_amount;
                $invoice_total+=$total+$gst_amount;
                $bill_data_type=$data_type;
                $data=array("invoice_id"=>$invoice_id,"item_id"=>$item_id,"gst_rate"=>$gst_rate,"qty"=>$qty,"price"=>$price,"gst_amount"=>$gst_amount,"ref_table_name"=>$tblname,'bill_data_type'=>$bill_data_type);
                array_push($insertdata, $data);
                
            }
            if(sizeof($insertdata)>0)
            {
                $this->db->insert_batch('invoice_details',$insertdata);
                $data=array('invoice_id'=>$invoice_id);
                if($data_type=="0")
                {
                    
                    $this->db->where_in('consignment_id',$consignment_id_ary);
                    $this->db->update('tbl_consignment',$data);
                }
                else
                {
                    
                    $this->db->where_in('inward_id',$consignment_id_ary);
                    $this->db->update('tbl_inward',$data);
                }
                $data = array('invoice_id' => $invoice_id,'consignor_id'=>$pricerow->consignor_id,'consignor_id'=>$pricerow->consignee_id);
                $this->db->insert('tbl_invoice_billing_details',$data);
            }
            
        

        $roundoff=round($invoice_total)-$invoice_total;
        $invoice_total=round($invoice_total);
        $data=array("total_tax"=>$total_tax,"invoice_total"=>$invoice_total,"round_off"=>$roundoff);
        $this->db->where('invoice_id',$invoice_id);
        $this->db->update('tbl_invoice',$data);
        if($invoice_total<1)
        {
            $this->db->where('invoice_id',$invoice_id);
            $this->db->delete('tbl_invoice');
        }



    }


    public function savelaborinvoice($post)
    {
        $temp_no=$this->lastInvoiceNo();
        $temp_no=$temp_no+1;
        $invoice_no=$this->invoiceprefix.$temp_no;
        $invoice_date=date('Y-m-d');
        $order_details=$this->getVendorCode($_POST['consignee_id']['0'],'6');
        if(is_null($order_details))
        {
            //echo "if";
            $vendor_code="";
            $order_no="";
        }
        else
        {
            $vendor_code=$order_details->vendor_code;
            $order_no=$order_details->order_no;
        }
        
        $billing_address_id=$post['billing_address_id'];
        $invoice_type_id="6";
        $total_tax=0;
        $invoice_total=0;
        $round_off=0;
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $gstdetails=$this->getTaxDetails('6');
        $gst_rate=$gstdetails->tax_rate;
        $qty=$_POST['qty'];
        $price=$_POST['amount'];
        $total=$qty*$price;
        $gst_amount=($total*$gst_rate)/100;
        $total_tax=$gst_amount;
        $invoice_total=$total+$gst_amount;
        $roundoff=round($invoice_total)-$invoice_total;
        $invoice_total=round($invoice_total);

        $data=array("invoice_no"=>$invoice_no,"invoice_date"=>$invoice_date,"order_no"=>$order_no,"vendor_code"=>$vendor_code,"billing_address_id"=>$billing_address_id,"invoice_type_id"=>$invoice_type_id,"total_tax"=>$total_tax,"invoice_total"=>$invoice_total,"round_off"=>$roundoff,"created_by"=>$user_id,"created_datetime"=>$datetime);
        //var_dump($data);
        //exit;
        $this->db->insert('tbl_invoice',$data);
        $invoice_id=$this->db->insert_id();
        $data=array("invoice_id"=>$invoice_id,"item_id"=>'0',"gst_rate"=>$gst_rate,"qty"=>$qty,"price"=>$price,"gst_amount"=>$gst_amount,"ref_table_name"=>'tbl_labor_item');
        $this->db->insert('invoice_details',$data);
        if($invoice_total<1)
        {
            $this->db->where('invoice_id',$invoice_id);
            $this->db->delete('tbl_invoice');
        }

    }

    public function updaterentinvoice($post)
    {
        
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        
        $invoice_id=encryptor('decrypt',$post['invoice_id']);
        $gstdetails=$this->getTaxDetails('3');
        
        /* invoice details work*/
        $itemidary=$this->getRentItemForInvoice($post['consignment_id']);
        $this->db->where('invoice_id',$invoice_id);
        $this->db->delete('invoice_details');
        foreach ($itemidary as $row) {
            $invoice_id=$invoice_id;
            $item_id=$row['rent_item_id'];
            $gst_rate=$gstdetails->tax_rate;
            $qty=$row['qty'];
            $price=$row['price'];
            $total=$qty*$price;
            $gst_amount=($total*$gst_rate)/100;
            $total_tax+=$gst_amount;
            $invoice_total+=$total+$gst_amount;
            $data=array("invoice_id"=>$invoice_id,"item_id"=>$item_id,"gst_rate"=>$gst_rate,"qty"=>$qty,"price"=>$price,"gst_amount"=>$gst_amount);
            $this->db->insert('invoice_details',$data);
        }
        $roundoff=round($invoice_total)-$invoice_total;
        $invoice_total=round($invoice_total);
        $data=array("total_tax"=>$total_tax,"invoice_total"=>$invoice_total,"round_off"=>$roundoff);
        $this->db->where('invoice_id',$invoice_id);
        $this->db->update('tbl_invoice',$data);

        $data=array('invoice_id'=>'0');
        $this->db->where_in('invoice_id',$invoice_id);
        $this->db->update('tbl_consignment',$data);
        
        $data=array('invoice_id'=>$invoice_id);
        $this->db->where_in('consignment_id',$post['consignment_id']);
        $this->db->update('tbl_consignment',$data);
        //$this->db->insert('tbl_invoice_category',$data);
        //return $this->db->insert_id();
    }
    public function getinvoice($start="",$length="",$searchstr="",$column,$type)
    {
        $col = (int)$column;
        $arr=array("invoice_id", "invoice_no", "invoice_date", "consignee_name", "total_tax", "invoice_total","round_off","category_name,is_invoice_sent");
        
            $this->db->select('tbl_invoice.invoice_id, `invoice_no`, `invoice_date`, `consignee_name`,consignee_billing_name, `total_tax`, `invoice_total`, `round_off`, `invoice_type_id`,category_name,is_invoice_sent,invoice_status,max(receipt_date) as receipt_date,tracking_no,courier_name');
            if(!empty($searchstr))
            {
                $this->db->or_like('invoice_no', $searchstr);
                $this->db->or_like('invoice_date', $searchstr);
                $this->db->or_like('consignee_name', $searchstr);
                $this->db->or_like('consignee_billing_name', $searchstr);
                $this->db->or_like('total_tax', $searchstr);
                $this->db->or_like('invoice_total', $searchstr);
                $this->db->or_like('round_off', $searchstr);
                $this->db->or_like('category_name', $searchstr);
            }
            
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_invoice')
            
                ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_invoice.consignee_id', 'left')
                ->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_invoice.billing_address_id', 'left')
                ->join('tbl_invoice_category', 'tbl_invoice_category.category_id = tbl_invoice.invoice_type_id', 'left')
                ->join('tbl_receipt', 'tbl_receipt.invoice_id = tbl_invoice.invoice_id', 'left')
                ->group_by('tbl_invoice.invoice_id')
                ->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_invoice');
            $this->db ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_invoice.consignee_id', 'left');
            $this->db ->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_invoice.billing_address_id', 'left');
            $this->db->join('tbl_invoice_category', 'tbl_invoice_category.category_id = tbl_invoice.invoice_type_id', 'left');
            $this->db->join('tbl_receipt', 'tbl_receipt.invoice_id = tbl_invoice.invoice_id', 'left');
            $this->db->group_by('tbl_invoice.invoice_id');
            $this->db->order_by('invoice_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            //echo $this->db->last_query();
            //exit;
            return $response;
    }
    public function getinvoicebyid($invoice_id)
    {  
        $query=$this->db->select('`invoice_id`, `invoice_no`, `invoice_date`, `total_tax`, `invoice_total`, `round_off`,billing_id,tbl_invoice.consignee_id,invoice_type_id,tbl_invoice.billing_address_id,vendor_code,order_no')
        ->from('tbl_invoice')
        ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_invoice.consignee_id', 'left')
        ->where('invoice_id',$invoice_id)
        ->get();
            $response['invoice']=$query->row();
            
        if($response['invoice']->billing_id=="0" && $response['invoice']->billing_address_id=="0")
        {
            $query=$this->db->select('`consignee_name`, `address`, `city`, `state`, `state_code`, `mobile_no`,gstin,pincode')
            ->from('tbl_consignee')
            ->where('consignee_id',$response['invoice']->consignee_id)
            ->get();
            $response['consignee']=$query->row();
        }
        else
        {
            if($response['invoice']->billing_address_id=="0")
               $response['invoice']->billing_address_id=$response['invoice']->billing_id;

            $query=$this->db->select('consignee_billing_name as consignee_name, `address`, `city`, `state`, `state_code`, `mobile_no`,gstin,pincode')
            ->from('tbl_consignee_billing')
            ->where('consignee_billing_id',$response['invoice']->billing_address_id)
            ->get();
            $response['consignee']=$query->row();
        }
        $response['tax_details']=$this->getTaxDetails($response['invoice']->invoice_type_id);
        
        $response['order_no']=$this->getVendorCode($response['invoice']->consignee_id, $response['invoice']->invoice_type_id);
        if($response['invoice']->invoice_type_id=="3")
        {
            /*$qry=$this->db->select('vehicle_inward_no,vehicle_type,way_bill_no')
            ->from('tbl_consignment')
            ->join('tbl_vehicle_inward','tbl_vehicle_inward.vehicle_inward_id = tbl_consignment.vehicle_id','left')
            ->join('tbl_vehicle_type','tbl_vehicle_type.vehicle_type_id = tbl_vehicle_inward.vehicle_type_id','left')
            ->where('invoice_id',$response['invoice']->invoice_id)
            ->get();
            $response['vehicle_details']=$qry->row();*/
            $query1=$this->db->select('tbl_consignment.consignment_id,`tbl_consignment`.`consignee_id`,consignment_date,consignment_no,dc_no,rent_item_name as item_name,qty,way_bill_no')
            ->from('tbl_consignment')
            ->join('tbl_consignment_rent_item', 'tbl_consignment_rent_item.consignment_id=tbl_consignment.consignment_id', 'left')
            ->join('tbl_rent_item', 'tbl_rent_item.rent_item_id=tbl_consignment_rent_item.item_id', 'left')
            ->where('tbl_consignment.invoice_id',$invoice_id)
            ->order_by('consignment_no')
            ->get();
            //echo $this->db->last_query(); exit();
            
            $response['annexure']=$query1->result_array();
            $query1=$this->db->select('tbl_vehicle_inward.vehicle_inward_no')
            ->from('tbl_consignment')
            ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id=tbl_consignment.vehicle_id', 'left')
            ->where('tbl_consignment.invoice_id',$invoice_id)
            ->order_by('consignment_no')
            ->get();
 
            $response['vehicle_details']=$query1->result_array();

            $query=$this->db->select('rent_item_name as item_name,invoice_details.attribute_value,`item_id`, `gst_rate`, `gst_amount`, `qty`, invoice_details.price,ref_table_name')
                ->from('invoice_details')
                ->join('tbl_rent_item', 'tbl_rent_item.rent_item_id = invoice_details.item_id', 'left')
                ->where('invoice_id',$response['invoice']->invoice_id)
                ->get();
        }
        else if($response['invoice']->invoice_type_id=="4")
        {
            $query=$this->db->select('"Ware House Rent" as item_name,invoice_details.attribute_value, `gst_rate`, `gst_amount`, `qty`, invoice_details.price,ref_table_name')
                ->from('invoice_details')
                ->where('invoice_id',$response['invoice']->invoice_id)
                ->get();
        }
        else if($response['invoice']->invoice_type_id=="6")
        {
            $query=$this->db->select('"Employee Charges" as item_name,invoice_details.attribute_value, `gst_rate`, `gst_amount`, `qty`, invoice_details.price,ref_table_name')
                ->from('invoice_details')
                ->where('invoice_id',$response['invoice']->invoice_id)
                ->get();
        }
        else
        {
            $query=$this->db->select('item_name,vehicle_type,invoice_details.item_id,invoice_details.attribute_value, `gst_rate`, `gst_amount`, `qty`, invoice_details.price,ref_table_name')
                ->from('invoice_details')
                ->join('tbl_item', 'tbl_item.item_id = invoice_details.item_id', 'left')
                ->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id = invoice_details.item_id', 'left')
                ->where('invoice_id',$response['invoice']->invoice_id)
                ->get();
            $query1=$this->db->select('consignment_date,consignment_no,d_c_no,item_name,sum(qty) as qty,vehicle_type,way_bill_no,tbl_vehicle_type.vehicle_type_id,tbl_consignment.vehicle_id')
            ->from('tbl_consignment')
            ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id=tbl_consignment.vehicle_id', 'left')
            ->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id=tbl_vehicle_inward.vehicle_type_id', 'left')
            ->join('tbl_consignment_stock_item', 'tbl_consignment_stock_item.consignment_id=tbl_consignment.consignment_id', 'left')
            ->join('tbl_item', 'tbl_item.item_id=tbl_consignment_stock_item.item_id', 'left')
            ->where('tbl_consignment.invoice_id',$invoice_id)
            ->order_by('consignment_no')
            ->group_by(array('consignment_no'))
            ->get();
           
            $response['annexure']['outward']=$query1->result_array();
            
            $query1=$this->db->select('placeA.place_name as source, placeB.place_name as destination,tbl_consignment.source_id,tbl_consignment.destination_id')
            ->from('tbl_consignment')
            ->join('place placeA','placeA.place_id=tbl_consignment.source_id','left')
            ->join('place placeB','placeB.place_id=tbl_consignment.destination_id','left')
            ->where('tbl_consignment.invoice_id',$invoice_id)
            ->group_by(array("source_id", "destination_id"))
            ->get();
            $response['location']=$query1->row();
            $query1=$this->db->select('inward_date as consignment_date,tbl_inward.inward_id as consignment_no,"" as d_c_no,item_name,qty,vehicle_type,"" as way_bill_no,tbl_inward.vehicle_id')
            ->from('tbl_inward')
            ->join('tbl_vehicle_inward', 'tbl_vehicle_inward.vehicle_inward_id=tbl_inward.vehicle_id', 'left')
            ->join('tbl_vehicle_type', 'tbl_vehicle_type.vehicle_type_id=tbl_vehicle_inward.vehicle_type_id', 'left')
            ->join('tbl_inward_details', 'tbl_inward_details.inward_id=tbl_inward.inward_id', 'left')
            ->join('tbl_item', 'tbl_item.item_id=tbl_inward_details.item_id', 'left')
            ->where('tbl_inward.invoice_id',$invoice_id)
            ->order_by('tbl_inward.inward_id')
            ->group_by('tbl_inward.inward_id')
            ->get();
            
            
            
            
            $response['annexure']['inward']=$query1->result_array();



            
        }
        
        $response['item']=$query->result_array();
        return $response;
    }
    public function getConsigneebyinvoiceid($invoice_id)
    {
        $query=$this->db->select('tbl_invoice.consignee_id')
        ->from('tbl_invoice')
        ->where('invoice_id',$invoice_id)
        ->get();
        return $query->row();
    }
    public function getextraparam($invoice_id)
    {
        $query=$this->db->select('attribute_name')
        ->from('invoice_details')
        ->where('invoice_id',$invoice_id)
        ->get();
        $data=$query->row();
        return $data->attribute_name;

    }

    public function getInvoiceByConsignee()
    {
        if(isset($_POST['consignee_billing_id']))
        {
            $consignee_billing_id=$_POST['consignee_billing_id'];
            $date_from=date("Y-m-d", strtotime($_POST['date_from']));
            $date_to=date("Y-m-d", strtotime($_POST['date_to']));
        }
        else
        {
            $consignee_billing_id="all";
            $date_from=date('01-m-d');
            $date_to=date('Y-m-d');
        }
       
        $this->db->select('tbl_invoice.invoice_id, `invoice_no`, `invoice_date`, `consignee_name`,consignee_billing_name, `total_tax`, `invoice_total`, `round_off`, `invoice_type_id`,category_name,tbl_consignee_billing.gstin,sum(gst_amount) as gst_amount,gst_rate');
            
        $this->db->from('tbl_invoice');
        $this->db ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_invoice.consignee_id', 'left');
        $this->db ->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_invoice.billing_address_id', 'left');
        $this->db ->join('invoice_details', 'invoice_details.invoice_id = tbl_invoice.invoice_id', 'left');
        $this->db->join('tbl_invoice_category', 'tbl_invoice_category.category_id = tbl_invoice.invoice_type_id', 'left');
        $this->db->where('invoice_date >=',$date_from);
        $this->db->where('invoice_date <=',$date_to);
        if($consignee_billing_id!="all")
        $this->db->where('tbl_invoice.billing_address_id',$consignee_billing_id);
        $this->db->order_by('tbl_invoice.invoice_id','asc');
        $this->db->group_by('invoice_id');
        $query=$this->db->get();
        $response=$query->result_array();
            //echo $this->db->last_query();
            //exit;
            return $response;
    }
    public function getgst()
    {
        if(isset($_POST['month']))
        {
            $month=$_POST['month'];
            $year=$_POST['year'];
        }
        $this->db->select('tbl_invoice.invoice_id, `invoice_no`, `invoice_date`, `consignee_name`,consignee_billing_name, `total_tax`, `invoice_total`, `round_off`, `invoice_type_id`,category_name,tbl_consignee_billing.gstin,sum(gst_amount) as gst_amount,gst_rate');
        $this->db->from('tbl_invoice');
        $this->db ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_invoice.consignee_id', 'left');
        $this->db ->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_invoice.billing_address_id', 'left');
        $this->db ->join('invoice_details', 'invoice_details.invoice_id = tbl_invoice.invoice_id', 'left');
        $this->db->join('tbl_invoice_category', 'tbl_invoice_category.category_id = tbl_invoice.invoice_type_id', 'left');
        $this->db->where('MONTH(invoice_date)',$month);
        $this->db->where('YEAR(invoice_date)',$year);
        $this->db->order_by('tbl_invoice.invoice_id','asc');
        $this->db->group_by('invoice_id');
        $query=$this->db->get();
        $response['sale']=$query->result_array();
        //return $response;
        $query=$this->db->select('remarks,tbl_account.party_name,GSTIN,taxable_value,tax,amount')
        ->from('tbl_payment_booking')
        ->join('tbl_account','tbl_account.account_id=tbl_payment_booking.ref_id')
        ->where('tbl_payment_booking.tax >','0')
        ->where('MONTH(booking_date)',$month)
        ->where('YEAR(booking_date)',$year)
        ->get();
        $response['purchase']=$query->result_array();
        
        return $response;
    }
    public function bookdebts()
    {
        $this->db->select('`invoice_id`, `invoice_no`, `invoice_date`, `consignee_name`,consignee_billing_name, `total_tax`, `invoice_total`, `round_off`, `invoice_type_id`,category_name');
            
        $this->db->from('tbl_invoice');
        $this->db ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_invoice.consignee_id', 'left');
        $this->db ->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_invoice.billing_address_id', 'left');
        $this->db->join('tbl_invoice_category', 'tbl_invoice_category.category_id = tbl_invoice.invoice_type_id', 'left');
        $this->db->where('invoice_status','0');
        $this->db->order_by('invoice_id','asc');
        $query=$this->db->get();

        $response=$query->result_array();
        return $response;
    }
    
    public function getPendingInvoiceByConsignee()
    {
        $consignee_billing_id=$_POST['consignee_billing_id'];
        
        $this->db->select('tbl_invoice.invoice_id, `invoice_no`, `invoice_date`, `consignee_name`,consignee_billing_name, `total_tax`, `invoice_total`, `round_off`, `invoice_type_id`,category_name,sum(amount) as amount');
            
        $this->db->from('tbl_invoice');
        $this->db ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_invoice.consignee_id', 'left');
        $this->db ->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_invoice.billing_address_id', 'left');
        $this->db->join('tbl_invoice_category', 'tbl_invoice_category.category_id = tbl_invoice.invoice_type_id', 'left');
        $this->db->join('tbl_receipt', 'tbl_receipt.invoice_id = tbl_invoice.invoice_id', 'left');
        $this->db->where('invoice_status','0');
        $this->db->where('tbl_invoice.billing_address_id',$consignee_billing_id);
        $this->db->group_by('invoice_id');
        $this->db->order_by('invoice_id','asc');
        $query=$this->db->get();
        $response=$query->result_array();
            //echo $this->db->last_query();
            //exit;
            return $response;
    }
    public function changeSentStatus($invoice_id)
    {
        $tracking_no=$_POST['tracking_no'];
        $data=array("is_invoice_sent"=>"1","tracking_no"=>$tracking_no,"courier_name"=>"dtdc");
        $this->db->where('invoice_id',$invoice_id);
        $this->db->update('tbl_invoice',$data);
    }
    public function getshippingAddress($consignee_id)
    {
        $query=$this->db->select('`consignee_name`, `address`, `city`, `state`, `state_code`, `mobile_no`,gstin,pincode')
            ->from('tbl_consignee')
            ->where('consignee_id',$consignee_id)
            ->get();
            return $query->row();
    }
    public function gettmonthlyInvoice($month,$year)
    {
        
        $query=$this->db->query("SELECT tbl_consignee_billing.consignee_billing_name, sum(invoice_total) as outstanding FROM `tbl_invoice` LEFT JOIN tbl_consignee_billing on tbl_consignee_billing.consignee_billing_id=tbl_invoice.billing_address_id WHERE invoice_status=0   GROUP by tbl_invoice.billing_address_id");
        return $query->result_array();

    }
    public function getcreditinvoice()
    {
        $days_ago = date('Y-m-d', strtotime('-90 days'));
        
        $query=$this->db->query("SELECT tbl_consignee_billing.consignee_billing_name, sum(invoice_total) as outstanding FROM `tbl_invoice` LEFT JOIN tbl_consignee_billing on tbl_consignee_billing.consignee_billing_id=tbl_invoice.billing_address_id WHERE invoice_status=0 and invoice_date<='".$days_ago."'  GROUP by tbl_invoice.billing_address_id");
        return $query->result_array();

    }
}

//SELECT tbl_consignee_billing.consignee_billing_name, sum(invoice_total) FROM `tbl_invoice` LEFT JOIN tbl_consignee_billing on tbl_consignee_billing.consignee_billing_id=tbl_invoice.billing_address_id WHERE invoice_status=0  GROUP by tbl_invoice.billing_address_id

?>