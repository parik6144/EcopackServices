<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_pending_consignment extends CI_Model{

    public function changestatus($consignment_id)
    {
        $data=array("consignment_status"=>1);
        $this->db->where('consignment_id',$consignment_id);
        $this->db->update('tbl_consignment',$data);
        return $consignment_id;
        
    }
    public function getpending_consignmentbyid($consignmentid)
    {
        $query=$this->db->select('pending_consignment_id,vehicle_location,pending_consignment_date,remarks,delevery_status')
                ->from('tbl_vehicle_pending_consignment')
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

            $this->db->where("(consignment_no like '%".$searchstr."%' OR consignment_date like '%".$searchstr."%' OR consignor_name like '%".$searchstr."%' OR consignee_name like '%".$searchstr."%' OR tbl_consignment.driver_name like '%".$searchstr."%' ) AND consignment_status = '0'");
        }
        else
            $this->db->where('consignment_status',0);
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
        $response['qry']=$this->db->last_query();
        //echo $this->db->last_query();
        //exit;
        return $response;
    }
}
?>