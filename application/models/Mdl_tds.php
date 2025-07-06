<?php
/**
 * 
 */
class Mdl_tds extends CI_Model
{
	
	public function gettds()
	{
		$date_from=date("Y-m-d", strtotime($_POST['date_from']));
        $date_to=date("Y-m-d", strtotime($_POST['date_to']));
        $sql=$this->db->select('tds_amount,payment_date,ref_id,ref_type')
        ->from('tbl_tds')
        ->where('payment_date >=',$date_from)
        ->where('payment_date <=',$date_to)
        ->get();
        return $sql->result_array();
	}
}
?>