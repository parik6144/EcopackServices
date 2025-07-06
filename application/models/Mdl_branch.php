<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_branch extends CI_Model{

    public function savebranch($post)
    {
        //`id`, `branch_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['branch_name']))
            $branch_name="";
        else
            $branch_name=$_POST['branch_name'];
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');

        $data=array("branch_name"=>$branch_name,"created_by"=>$user_id,"created_datetime"=>$datetime);
        $this->db->insert('branch',$data);
        return $this->db->insert_id();

    }
    public function getbranch($start="",$length="",$searchstr="",$column,$type)
    {
         $col = (int)$column;
         $arr=array("branch_id","branch_name");
        if($start=='' && $length=='' && $searchstr=='')
        {
            
            $query=$this->db->select('branch_id,`branch_name`')
                ->from('branch')
                ->where('is_deleted', '0')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('branch_id,`branch_name`');
            $this->db->where('is_deleted', '0');
            if(!empty($searchstr))
            {
                $this->db->or_like('branch_name', $searchstr);

            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->from('branch')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->from('branch');
            $this->db->order_by('branch_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getbranchbyid($branchid)
    {
        $query=$this->db->select('`branch_name`,branch_id')
            ->from('branch')
            ->where(array("branch_id"=>$branchid))
            ->get();
        $record['branch']=$query->result_array();

        return $record;
    }
    public function updatebranch($post)
    {
        if(!empty($post['branch_name']))
            $branch_name=$post['branch_name'];
        else
            $branch_name='';
        $user_id=$this->session->userdata('user_id');
        $datetime=date('Y-m-d h:i:s');
        $data=array("branch_name"=>$branch_name,"updated_datetime"=>$datetime,"updated_by"=>$user_id);
        $lastid=encryptor("decrypt",$post['branch_id']);
        $this->db->where('branch_id', encryptor("decrypt",$post['branch_id']));
        $this->db->update('branch',$data);
       
    }
    public function deletebyid($branchid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('branch_id', $branchid);
        $this->db->update('branch',$data);
        return $this->db->affected_rows();
    }

}
?>