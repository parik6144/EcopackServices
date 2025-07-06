<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17/08/2017
 * Time: 11:49
 */
class Mdl_designations extends CI_Model{

    public function savedesignations($post)
    {
        $designation_name = $this->input->post('designation_name') ? $this->input->post('designation_name') : "";
        $employee_type_id = $this->input->post('employee_type_id') ? $this->input->post('employee_type_id') : "";
        
        $data = array(
            "designation_name" => $designation_name,
            "employee_type_id" => $employee_type_id
        );
        $this->db->insert('designations', $data);
        return $this->db->insert_id();
    }

    public function getdesignations($start="",$length="",$searchstr="",$column,$type)
    {
         $col = (int)$column;
         $arr=array("designation_id","designation_name","employee_type_id");
        if($start=='' && $length=='' && $searchstr=='')
        {
            
            $query=$this->db->select('d.designation_id, d.designation_name, d.employee_type_id, et.type_name as department_name')
                ->from('designations d')
                ->join('employee_type et', 'et.employee_type_id = d.employee_type_id', 'left')
                ->get();
            return $query->result_array();
        }
        else
        {
            $this->db->select('d.designation_id, d.designation_name, d.employee_type_id, et.type_name as department_name');
            $this->db->from('designations d');
            $this->db->join('employee_type et', 'et.employee_type_id = d.employee_type_id', 'left');
            if(!empty($searchstr))
            {
                $this->db->group_start();
                $this->db->like('d.designation_name', $searchstr);
                $this->db->or_like('et.type_name', $searchstr);
                $this->db->group_end();
            }
            $tempdb = clone $this->db;
            $this->db->order_by($arr[$col],$type);
            $num_rows = $tempdb->where('d.is_deleted','0')->count_all_results();
            if($length>0)
                $this->db->limit($length, $start);
            $this->db->where('d.is_deleted','0');
            $this->db->order_by('d.designation_id','desc');
            $query=$this->db->get();
            $response['count']=$num_rows;
            $response['data']=$query->result_array();
            return $response;
        }
    }
    public function getdesignationsbyid($designation_id)
    {
        $query=$this->db->select('d.designation_name, d.designation_id, d.employee_type_id, et.type_name as department_name')
            ->from('designations d')
            ->join('employee_type et', 'et.employee_type_id = d.employee_type_id', 'left')
            ->where(array("d.designation_id"=>$designation_id))
            ->get();
        $record['designations']=$query->result_array();
        return $record;
    }
    public function updatedesignations($post)
    {
        $designation_name = $this->input->post('designation_name') ? $this->input->post('designation_name') : "";
        $employee_type_id = $this->input->post('employee_type_id') ? $this->input->post('employee_type_id') : "";
        
        $data = array(
            "designation_name" => $designation_name,
            "employee_type_id" => $employee_type_id
        );

        $lastid = encryptor("decrypt", $post['designation_id']);

        $this->db->where('designation_id', $lastid);
        $this->db->update('designations', $data);
    }
    public function deletebyid($designation_id)
    {
        $data=array("is_deleted"=>'1');
        $this->db->where('designation_id', $designation_id);
        $this->db->update('designations',$data);
        return $this->db->affected_rows();
    }
    
    public function getdesignationsbydepartment($employee_type_id)
    {
        $query=$this->db->select('designation_id, designation_name')
            ->from('designations')
            ->where(array("employee_type_id"=>$employee_type_id, "is_deleted"=>'0'))
            ->get();
        return $query->result_array();
    }

}
?>
