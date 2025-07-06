<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_working_day extends CI_Model{

    public function saveworking_day($post)
    {
        //`id`, `working_day_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['working_day_name']))
            $working_day_name="";
        else
            $working_day_name=$_POST['working_day_name'];
         if(empty($_POST['working_day_date']))
            $working_day_date="";
        else
            $working_day_date=date("Y-m-d", strtotime($_POST['working_day_date']));
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        $data=array("working_day_name"=>$working_day_name,"working_day_date"=>$working_day_date,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_working_day',$data);
        return $this->db->insert_id();

    }
    public function getworking_day($start="",$length="",$searchstr="",$column,$type)
    {
         $col = (int)$column;
         $arr=array("working_day_id","working_day_name","working_day_date");
        if($start=='' && $length=='' && $searchstr=='')
        {
            
            $query=$this->db->select('working_day_id,`working_day_name`,working_day_date')
                ->from('tbl_working_day')
                ->where('is_deleted', '0')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('working_day_id,`working_day_name`,working_day_date');
            $this->db->where('is_deleted', '0');
            if(!empty($searchstr))
            {
                $this->db->or_like('working_day_name', $searchstr);

            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_working_day')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_working_day');
            $this->db->order_by('working_day_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getworking_daybyid($working_dayid)
    {
        $query=$this->db->select('`working_day_name`,working_day_id,working_day_date')
            ->from('tbl_working_day')
            ->where(array("working_day_id"=>$working_dayid))
            ->get();
        $record['working_day']=$query->result_array();

        return $record;
    }
    public function updateworking_day($post)
    {
        if(!empty($post['working_day_name']))
            $working_day_name=$post['working_day_name'];
        else
            $working_day_name='';
        $user_id=$this->session->userdata('user_id');
        if(empty($_POST['working_day_date']))
            $working_day_date="";
        else
            $working_day_date=date("Y-m-d", strtotime($_POST['working_day_date']));
        $datetime=date('Y-m-d h:i:s');
        $data=array("working_day_name"=>$working_day_name,"working_day_date"=>$working_day_date,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['working_day_id']);
        $this->db->where('working_day_id', encryptor("decrypt",$post['working_day_id']));
        $this->db->update('tbl_working_day',$data);
       
    }
    public function deletebyid($working_dayid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('working_day_id', $working_dayid);
        $this->db->update('tbl_working_day',$data);
        return $this->db->affected_rows();
    }

}
?>