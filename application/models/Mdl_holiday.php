<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_holiday extends CI_Model{

    public function saveholiday($post)
    {
        //`id`, `holiday_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['holiday_name']))
            $holiday_name="";
        else
            $holiday_name=$_POST['holiday_name'];
         if(empty($_POST['holiday_date']))
            $holiday_date="";
        else
            $holiday_date=date("Y-m-d", strtotime($_POST['holiday_date']));
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        $data=array("holiday_name"=>$holiday_name,"holiday_date"=>$holiday_date,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('tbl_holidays',$data);
        return $this->db->insert_id();

    }
    public function getholiday($start="",$length="",$searchstr="",$column,$type)
    {
         $col = (int)$column;
         $arr=array("holiday_id","holiday_name","holiday_date");
        if($start=='' && $length=='' && $searchstr=='')
        {
            
            $query=$this->db->select('holiday_id,`holiday_name`,holiday_date')
                ->from('tbl_holidays')
                ->where('is_deleted', '0')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('holiday_id,`holiday_name`,holiday_date');
            $this->db->where('is_deleted', '0');
            if(!empty($searchstr))
            {
                $this->db->or_like('holiday_name', $searchstr);

            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('tbl_holidays')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('tbl_holidays');
            $this->db->order_by('holiday_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getholidaybyid($holidayid)
    {
        $query=$this->db->select('`holiday_name`,holiday_id,holiday_date')
            ->from('tbl_holidays')
            ->where(array("holiday_id"=>$holidayid))
            ->get();
        $record['holiday']=$query->result_array();

        return $record;
    }
    public function updateholiday($post)
    {
        if(!empty($post['holiday_name']))
            $holiday_name=$post['holiday_name'];
        else
            $holiday_name='';
        $user_id=$this->session->userdata('user_id');
        if(empty($_POST['holiday_date']))
            $holiday_date="";
        else
            $holiday_date=date("Y-m-d", strtotime($_POST['holiday_date']));
        $datetime=date('Y-m-d h:i:s');
        $data=array("holiday_name"=>$holiday_name,"holiday_date"=>$holiday_date,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['holiday_id']);
        $this->db->where('holiday_id', encryptor("decrypt",$post['holiday_id']));
        $this->db->update('tbl_holidays',$data);
       
    }
    public function deletebyid($holidayid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('holiday_id', $holidayid);
        $this->db->update('tbl_holidays',$data);
        return $this->db->affected_rows();
    }

}
?>