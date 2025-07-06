<?php
class Mdl_due_payment extends CI_Model{

    
    public function getconsignment($start="",$length="",$searchstr="",$column,$type)
    {
        
        $col = (int)$column;
        $arr=array("consignment_no", "tbl_payment_due.created_datetime", "owner_name","tbl_inward_owner.mobile_no", "bank_name", "branch","account_no","ifsc_code","GSTIN","amount");
        $this->db->select('distinct(tbl_consignment.consignment_no), tbl_payment_due.created_datetime,owner_name,tbl_inward_owner.mobile_no,bank_name,branch,account_no,ifsc_code,GSTIN,amount');
        if(!empty($searchstr))
        {
            $this->db->or_like('consignment_no', $searchstr);
            $this->db->or_like('tbl_payment_due.created_datetime', $searchstr);
            $this->db->or_like('owner_name', $searchstr);
            $this->db->or_like('tbl_inward_owner.mobile_no', $searchstr);
            $this->db->or_like('bank_name', $searchstr);
            $this->db->or_like('branch', $searchstr);
            $this->db->or_like('account_no', $searchstr);
            $this->db->or_like('ifsc_code', $searchstr);
            $this->db->or_like('GSTIN', $searchstr);
            $this->db->or_like('amount', $searchstr);
        }
        $this->db->where('amount>','0');
        $tempdb = clone $this->db;
        $this->db->order_by($arr[$col],$type);
        $num_rows = $tempdb->from('tbl_payment_due')
        ->join('tbl_inward_owner', 'tbl_inward_owner.owner_id = tbl_payment_due.owner_id', 'left')
        ->join('tbl_consignment', 'tbl_consignment.consignment_id = tbl_payment_due.consignment_id', 'left')
            ->count_all_results();
        if($length>0)
            $this->db->limit($length, $start);
        $this->db->from('tbl_payment_due');
        $this->db->join('tbl_inward_owner', 'tbl_inward_owner.owner_id = tbl_payment_due.owner_id', 'left');
        $this->db->join('tbl_consignment', 'tbl_consignment.consignment_id = tbl_payment_due.consignment_id', 'left');
        $query=$this->db->get();
        $response['count']=$num_rows;
        $response['data']=$query->result_array();
        return $response;
    }
}
?>