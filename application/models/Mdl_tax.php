<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_tax extends CI_Model{

    public function savetax($post)
    {
        //`id`, `tax_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['tax_name']))
            $tax_name="";
        else
            $tax_name=$_POST['tax_name'];

        if(empty($_POST['tax_rate']))
            $tax_rate="";
        else
            $tax_rate=$_POST['tax_rate'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        $data=array("tax_name"=>$tax_name,"tax_rate"=>$tax_rate,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_tax',$data);
        return $this->db->insert_id();

    }
    public function gettax($start="",$length="",$searchstr="",$column,$type)
    {
         $col = (int)$column;
         $arr=array("tax_id","tax_name");
        if($start=='' && $length=='' && $searchstr=='')
        {
            
            $query=$this->db->select('tax_id,`tax_name`,tax_rate')
                ->from('tbl_tax')
                ->where('is_deleted', '0')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('tax_id,`tax_name`,tax_rate');
            $this->db->where('is_deleted', '0');
            if(!empty($searchstr))
            {
                $this->db->like('tax_name', $searchstr);

            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_tax')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_tax');
            $this->db->order_by('tax_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function gettaxbyid($taxid)
    {
        $query=$this->db->select('`tax_name`,tax_id,tax_rate')
            ->from('tbl_tax')
            ->where(array("tax_id"=>$taxid))
            ->get();
        $record['tax']=$query->result_array();

        return $record;
    }
    public function updatetax($post)
    {
        if(!empty($post['tax_name']))
            $tax_name=$post['tax_name'];
        else
            $tax_name='';
        if(empty($_POST['tax_rate']))
            $tax_rate="";
        else
            $tax_rate=$_POST['tax_rate'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("tax_name"=>$tax_name,"tax_rate"=>$tax_rate,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['tax_id']);
        $this->db->where('tax_id', encryptor("decrypt",$post['tax_id']));
        $this->db->update('tbl_tax',$data);
       
    }
    public function deletebyid($taxid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('tax_id', $taxid);
        $this->db->update('tbl_tax',$data);
        return $this->db->affected_rows();
    }

}
?>