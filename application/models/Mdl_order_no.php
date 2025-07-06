<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_order_no extends CI_Model{

    public function saveorderno($post)
    {
        //`id`, `place_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];

        if(empty($_POST['invoice_type_id']))
            $invoice_type_id="";
        else
            $invoice_type_id=$_POST['invoice_type_id'];

        if(empty($_POST['order_no']))
            $order_no="";
        else
            $order_no=$_POST['order_no'];
        if(empty($_POST['vendor_code']))
            $vendor_code="";
        else
            $vendor_code=$_POST['vendor_code'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("consignee_id"=>$consignee_id,"invoice_type_id"=>$invoice_type_id,"order_no"=>$order_no,"vendor_code"=>$vendor_code,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_order_no',$data);
        return $this->db->insert_id();

    }
    public function getplace($start="",$length="",$searchstr="",$column,$type)
    {
         $col = (int)$column;
         $arr=array("order_no_id","consignee_name","category_name","order_no","vendor_code");
        if($start=='' && $length=='' && $searchstr=='')
        {
            
            $query=$this->db->select('`order_no_id`, `consignee_id`, `invoice_type_id`, `order_no`, `vendor_code`')
                ->from('tbl_order_no')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('order_no_id,`consignee_name`,`category_name`,`order_no`,vendor_code');
            if(!empty($searchstr))
            {
                $this->db->or_like('consignee_name', $searchstr);
                $this->db->or_like('category_name', $searchstr);
                $this->db->or_like('order_no', $searchstr);
                $this->db->or_like('vendor_code', $searchstr);

            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_order_no')
            ->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_order_no.consignee_id', 'left')
            ->join('tbl_invoice_category', 'tbl_invoice_category.category_id = tbl_order_no.invoice_type_id', 'left')
            ->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_order_no');
            $this->db->join('tbl_consignee', 'tbl_consignee.consignee_id = tbl_order_no.consignee_id', 'left');
            $this->db->join('tbl_invoice_category', 'tbl_invoice_category.category_id = tbl_order_no.invoice_type_id', 'left');
            $this->db->order_by('order_no_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getordernobyid($orderid)
    {
        $query=$this->db->select('`order_no_id`, `consignee_id`, `invoice_type_id`, `order_no`,vendor_code')
            ->from('tbl_order_no')
            ->where(array("order_no_id"=>$orderid))
            ->get();
        $record['order_no']=$query->result_array();

        return $record;
    }
    public function updateorderno($post)
    {
        if(empty($_POST['consignee_id']))
            $consignee_id="";
        else
            $consignee_id=$_POST['consignee_id'];

        if(empty($_POST['invoice_type_id']))
            $invoice_type_id="";
        else
            $invoice_type_id=$_POST['invoice_type_id'];

        if(empty($_POST['order_no']))
            $order_no="";
        else
            $order_no=$_POST['order_no'];

        if(empty($_POST['vendor_code']))
            $vendor_code="";
        else
            $vendor_code=$_POST['vendor_code'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("consignee_id"=>$consignee_id,"invoice_type_id"=>$invoice_type_id,"order_no"=>$order_no,"vendor_code"=>$vendor_code,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['orderno_id']);
        $this->db->where('order_no_id', encryptor("decrypt",$post['orderno_id']));
        $this->db->update('tbl_order_no',$data);
       
    }
    public function deletebyid($placeid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('order_no_id', $placeid);
        $this->db->delete('tbl_order_no');
        return $this->db->affected_rows();
    }

}
?>