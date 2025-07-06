<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_warehouse extends CI_Model{

    public function savewarehouse($post)
    {
        //`id`, `warehouse_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['warehouse_name']))
            $warehouse_name="";
        else
            $warehouse_name=$_POST['warehouse_name'];

        if(empty($_POST['warehouse_address']))
            $warehouse_address="";
        else
            $warehouse_address=$_POST['warehouse_address'];

        if(empty($_POST['warehouse_gst_no']))
            $warehouse_gst_no="";
        else
            $warehouse_gst_no=$_POST['warehouse_gst_no'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        $data=array("warehouse_name"=>$warehouse_name,"warehouse_address"=>$warehouse_address,"warehouse_gst_no"=>$warehouse_gst_no,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_warehouse',$data);
        return $this->db->insert_id();

    }
    public function getwarehouse($start="",$length="",$searchstr="",$column,$type)
    {
         $col = (int)$column;
         $arr=array("warehouse_id","warehouse_name","warehouse_address","warehouse_gst_no");
        if($start=='' && $length=='' && $searchstr=='')
        {
            
            $query=$this->db->select('warehouse_id,`warehouse_name`,warehouse_address,warehouse_gst_no')
                ->from('tbl_warehouse')
                ->where('is_deleted', '0')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('warehouse_id,`warehouse_name`,warehouse_address,warehouse_gst_no');
            $this->db->where('is_deleted', '0');
            if(!empty($searchstr))
            {
                $this->db->or_like('warehouse_name', $searchstr);
                $this->db->or_like('warehouse_address', $searchstr);
                $this->db->or_like('warehouse_gst_no', $searchstr);

            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_warehouse')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_warehouse');
            $this->db->order_by('warehouse_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getwarehousebyid($warehouseid)
    {
        $query=$this->db->select('`warehouse_name`,warehouse_id,warehouse_address,warehouse_gst_no')
            ->from('tbl_warehouse')
            ->where(array("warehouse_id"=>$warehouseid))
            ->get();
        $record['warehouse']=$query->result_array();

        return $record;
    }
    public function updatewarehouse($post)
    {
        if(!empty($post['warehouse_name']))
            $warehouse_name=$post['warehouse_name'];
        else
            $warehouse_name='';

        if(!empty($post['warehouse_address']))
            $warehouse_address=$post['warehouse_address'];
        else
            $warehouse_address='';
        if(empty($_POST['warehouse_gst_no']))
            $warehouse_gst_no="";
        else
            $warehouse_gst_no=$_POST['warehouse_gst_no'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("warehouse_name"=>$warehouse_name,"warehouse_address"=>$warehouse_address,"warehouse_gst_no"=>$warehouse_gst_no,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['warehouse_id']);
        $this->db->where('warehouse_id', encryptor("decrypt",$post['warehouse_id']));
        $this->db->update('tbl_warehouse',$data);
       
    }
    public function deletebyid($warehouseid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('warehouse_id', $warehouseid);
        $this->db->update('tbl_warehouse',$data);
        return $this->db->affected_rows();
    }
    public function getnotification()
    {
         $query=$this->db->select('`notification_text`,notification_heading')
                ->from('tbl_notification')
                ->where('is_sent', '1')
                ->get();
            return $query->result_array();
    }

}
?>