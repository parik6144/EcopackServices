<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:46
 */
class Mdl_login extends CI_Model{
    public function checklogin($username,$password)
    {
        $q=$this->db->select('user_id')
            ->where(array("user_name"=>$username,"user_password"=>$password))
            ->get("tbl_user");
          // echo $this->db->last_query(); exit();
        $data=$q->result_array();
        //echo $q->num_rows(); exit();
        //return $q->num_rows();
        if($q->num_rows()>0)
        {
            $response=$this->getuserrecord($data[0]['user_id']);
            return $response;
        }
        else
            return '0';
    }
    
    public function checkBlock($username,$password)
    {
        $q = $this->db->select('user_id')->where(array("user_name"=>$username,"user_password"=>$password,"is_blocked"=>1))->get("tbl_user");
        // echo $this->db->last_query(); exit();
        return count($q->result_array());
    }
    
    function getuserrecord($userid)
    {
        $q=$this->db->select('*')
            ->where(array("user_id"=>$userid))
            ->get("tbl_user");
        return $q->result_array();
    }
    
}
?>