<?php

class Mdl_receipt extends CI_Model{
	public function getreceipt($start="",$length="",$searchstr="",$column,$type)
	{
		$col = (int)$column;
        if($start=='' && $length=='' && $searchstr=='')
        {
            $query=$this->db->select('`receipt_id`, `party_name`')
                ->from('tbl_receipt')
                ->where('is_deleted','0')
                ->order_by('party_name','ASC')
                ->get();
            return $query->result_array();
        }
        else
        {

            $arr=array("receipt_id", "receipt_date", "consignee_billing_name", "invoice_no", "invoice_total", "amount", "tds");

            $this->db->select('`receipt_id`, `receipt_date`, `amount`, `payment_mode`,invoice_no,invoice_total,invoice_status,consignee_billing_name,tds');
            if(!empty($searchstr))
            {
                $this->db->or_like('invoice_no', $searchstr);
                $this->db->or_like('invoice_total', $searchstr);
                $this->db->or_like('amount', $searchstr);
                $this->db->or_like('consignee_billing_name', $searchstr);
            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_receipt')
            ->join('tbl_invoice', 'tbl_invoice.invoice_id = tbl_receipt.invoice_id', 'left')
            ->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_receipt.billing_id', 'left')
            ->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_receipt');
            $this->db->join('tbl_invoice', 'tbl_invoice.invoice_id = tbl_receipt.invoice_id', 'left');
            $this->db->join('tbl_consignee_billing', 'tbl_consignee_billing.consignee_billing_id = tbl_receipt.billing_id', 'left');
            $this->db->order_by('receipt_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
	}
    public function savereceipt($post)
    {
        
        if(empty($post['date']))
            $receipt_date="";
        else
            $receipt_date=$post['date'];

        if(empty($post['invoice_id']))
            $invoice_id="";
        else
            $invoice_id=encryptor('decrypt',$post['invoice_id']);

        if(empty($post['amount']))
            $amount="";
        else
            $amount=$post['amount'];

        if(empty($post['tds']))
            $tds="";
        else
            $tds=$post['tds'];

        if(empty($post['status']))
            $status="";
        else
            $status=$post['status'];

        if(empty($post['billing_id']))
            $billing_id="";
        else
            $billing_id=$post['billing_id'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        //`receipt_id`, `receipt_date`, `invoice_id`, `amount`, `tds`, `payment_mode`, `billing_id`,
        $data=array("receipt_date"=>$receipt_date,"invoice_id"=>$invoice_id,"amount"=>$amount,"tds"=>$tds,"billing_id"=>$billing_id,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_receipt',$data);
        $data=array('invoice_status'=>$status);
        $this->db->where('invoice_id',$invoice_id);
        $this->db->update('tbl_invoice',$data);
        return "true";
    }
}