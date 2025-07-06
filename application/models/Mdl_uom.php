<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_uom extends CI_Model{

    public function saveuom($post)
    {
        //`id`, `uom_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['full_name']))
            $full_name="";
        else
            $full_name=$_POST['full_name'];
        if(empty($_POST['short_name']))
            $short_name="";
        else
            $short_name=$_POST['short_name'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("full_name"=>$full_name,
        "short_name"=>$short_name,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_uom',$data);
        return $this->db->insert_id();

    }
    public function getuom($start="",$length="",$searchstr="",$column,$type)
    {
         $col = (int)$column;
         $arr=array("uom_id","full_name", "short_name");
        if($start=='' && $length=='' && $searchstr=='')
        {
            
            $query=$this->db->select('uom_id,`full_name`, `short_name`')
                ->from('tbl_uom')
                ->where(array("is_deleted"=>'0'))
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('uom_id,`full_name`, `short_name`');
            if(!empty($searchstr))
            {
                $this->db->or_like('full_name', $searchstr);
                $this->db->or_like('short_name', $searchstr);

            }
             $this->db->where(array("is_deleted"=>'0'));
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_uom')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_uom');
            $this->db->order_by('uom_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getuombyid($uomid)
    {
        $query=$this->db->select('`full_name`, `short_name`,uom_id')
            ->from('tbl_uom')
            ->where(array("uom_id"=>$uomid))
            ->get();
        $record['uom']=$query->result_array();

        return $record;
    }
    public function updateuom($post)
    {
        if(!empty($post['full_name']))
            $full_name=$post['full_name'];
        else
            $full_name='';
        if(!empty($post['short_name']))
            $short_name=$post['short_name'];
        else
            $short_name='';
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("full_name"=>$full_name,
            "short_name"=>$short_name,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['uom_id']);
        $this->db->where('uom_id', encryptor("decrypt",$post['uom_id']));
        $this->db->update('tbl_uom',$data);
    }
    public function deletebyid($uomid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('uom_id', $uomid);
        $this->db->update('uom',$data);
        return $this->db->affected_rows();
    }

}
?>