<?php
/**
 * 
 */
class Tds extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $this->load->model('Mdl_tds');
        $this->load->model('Mdl_setting');
	}
	public function index()
	{
		$data['title']="TDS";
        $this->load->view('tds/tds_form',$data);
	}
	public function getrecord()
	{
		$record=$this->Mdl_tds->gettds();
		$this->load->model('Mdl_payment_booking');
		$data['title']="TDS Record";
		$str="";
		foreach ($record as $row) {
                $str.="<tr>";
                $str.= "<td>".date("d-m-Y",strtotime($row['payment_date']))."</td>";
                $str.= "<td>".$row['tds_amount']."</td>";
                $rec=$this->Mdl_payment_booking->getUserName($row['ref_type'],$row['ref_id']);
                $str.= "<td>".$rec->ref_name."</td>";
               // $str.= "<td>".$rec->receiver_type."</td>";
                $str.= "<td>".$rec->gstin."</td>";
                $str.="</tr>";
        }
        
        $data['html']=$str;
        $this->load->view('tds/tds_data',$data);

	}
}
?>