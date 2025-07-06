<?php
/**
* 
*/
class Mdl_advance_salary extends CI_Model
{
	
	public function getAdvanceSalary()
	{
		$month=$_POST['month'];
		$year=$_POST['year'];
		$sql=$this->db->select('advance_salary_id,advance_salary,payment_date,staff_name,emp_no')
		->from('tbl_advance_salary')
		->where(array('month_id' => $month,'year_id' => $year, 'payment_date >'=>'0000-00-00'))
		->join('staff','staff.staff_id=tbl_advance_salary.employee_id','left')
		->get();
		return $sql->result_array();
	}
}
?>