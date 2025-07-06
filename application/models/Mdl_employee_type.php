<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_employee_type extends CI_Model{

	public function __construct()
	{
		parent::__construct(); // Call the parent CI_Model constructor
		// echo 12345; exit();
	}

	public function getemployee_type($start="",$length="",$searchstr="",$column='',$type='')
	{
		$col = (int)$column;
		$arr=array("employee_type_id","type_name");
		if($start=='' && $length=='' && $searchstr=='')
		{
			$query=$this->db->select('employee_type_id,`type_name`')
				->from('employee_type')
				->get();
			return $query->result_array();
		}
		else
		{
			$this->db->select('employee_type_id,`type_name`');
			if(!empty($searchstr))
			{
				$this->db->or_like('type_name', $searchstr);
			}
			$tempdb = clone $this->db;
			$this->db->order_by($arr[$col],$type);
			$num_rows = $tempdb->from('employee_type')->where('is_deleted','0')->count_all_results();
			if($length>0)
				$this->db->limit($length, $start);
			$this->db->from('employee_type');
			$this->db->where('is_deleted','0');
			$this->db->order_by('employee_type_id','desc');
			$query=$this->db->get();
			$response['count']=$num_rows;
			$response['data']=$query->result_array();
			return $response;
		}
	}

	public function saveemployee_type($post)
    {
        //`id`, `uom_name`, `mobile`, `mobile2`, `phone`, `phone2`
        if(empty($_POST['type_name']))
            $type_name="";
        else
            $type_name=$_POST['type_name'];
        
        $data=array("type_name"=>$type_name);
        $this->db->insert('employee_type',$data);
        return $this->db->insert_id();

    }

    public function getemployee_typebyid($employee_type_id)
    {
        $query=$this->db->select('`type_name`,employee_type_id')
            ->from('employee_type')
            ->where(array("employee_type_id"=>$employee_type_id))
            ->get();
        $record['employee_type']=$query->result_array();
        return $record;
    }
    public function updateemployee_type($post)
    {
         if(empty($_POST['type_name']))
            $type_name="";
        else
            $type_name=$_POST['type_name'];        
        $data=array("type_name"=>$type_name);

        $lastid=encryptor("decrypt",$post['employee_type_id']);

        $this->db->where('employee_type_id', $lastid);
        $this->db->update('employee_type',$data);
       
    }
    public function deletebyid($uomid)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('employee_type_id', $uomid);
        $this->db->update('employee_type',$data);
        return $this->db->affected_rows();
    }

}
?>
