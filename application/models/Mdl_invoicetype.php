<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */

class Mdl_invoicetype extends CI_Model{

    public function saveinvoicetype($post)
    {
        //`id`, `category_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['category_name']))
            $category_name="";
        else
            $category_name=$_POST['category_name'];

        if(empty($_POST['hsn_code']))
            $hsn_code="";
        else
            $hsn_code=$_POST['hsn_code'];

        if(empty($_POST['tax_rate']))
            $tax_rate="";
        else
            $tax_rate=$_POST['tax_rate'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        $data=array("category_name"=>$category_name,"hsn_code"=>$hsn_code,"tax_rate"=>$tax_rate,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_invoice_category',$data);
        return $this->db->insert_id();

    }
    public function getinvoicetype($start="",$length="",$searchstr="",$column,$type)
    {
         $col = (int)$column;
         $arr=array("category_id","category_name","hsn_code","tax_rate");
        if($start=='' && $length=='' && $searchstr=='')
        {
            
            $query=$this->db->select('`category_id`, `category_name`, `hsn_code`, `tax_rate`')
                ->from('tbl_invoice_category')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('`category_id`, `category_name`, `hsn_code`, `tax_rate`');
            if(!empty($searchstr))
            {
                $this->db->or_like('category_name', $searchstr);
                $this->db->or_like('hsn_code', $searchstr);
                $this->db->or_like('tax_rate', $searchstr);

            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_invoice_category')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_invoice_category');
            $this->db->order_by('category_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getinvoicetypebyid($invoicetypeid)
    {
        $query=$this->db->select('`category_name`,category_id,tax_rate,hsn_code')
            ->from('tbl_invoice_category')
            ->where(array("category_id"=>$invoicetypeid))
            ->get();
        $record['invoicetype']=$query->result_array();

        return $record;
    }
    public function updateinvoicetype($post)
    {
        if(empty($_POST['category_name']))
            $category_name="";
        else
            $category_name=$_POST['category_name'];

        if(empty($_POST['hsn_code']))
            $hsn_code="";
        else
            $hsn_code=$_POST['hsn_code'];

        if(empty($_POST['tax_rate']))
            $tax_rate="";
        else
            $tax_rate=$_POST['tax_rate'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("category_name"=>$category_name,"hsn_code"=>$hsn_code,"tax_rate"=>$tax_rate,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['category_id']);
        $this->db->where('category_id', encryptor("decrypt",$post['category_id']));
        $this->db->update('tbl_invoice_category',$data);
       
    }
    public function deletebyid($invoicetypeid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('category_id', $invoicetypeid);
        //$this->db->update('tbl_invoice_category',$data);
        $this->db->delete('tbl_invoice_category');
        return $this->db->affected_rows();
    }

}
?>