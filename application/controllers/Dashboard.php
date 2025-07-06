<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
            redirect(base_url(), 'refresh');
        $this->load->model('Mdl_setting');

    }
    public function index()
    {  
        $data['title']="Dashboard";
        $this->load->model('Mdl_expense_head');

        //$data['totalinvoice']=$this->Mdl_invoice->getTotalByMonth();
        
        //$data['transportation']=$this->Mdl_expense_head->getmonthlytransportation();
        if(isset($_GET['m']))
        {
            $data['expensehead']=$this->Mdl_expense_head->getmonthlyexpense();
            $this->load->model('Mdl_invoice');
            $this->load->model('Mdl_pending_advance');
            $this->load->model('Mdl_pending_due');
            $this->load->model('Mdl_payment_booking');
            $this->load->model('Mdl_item');
            $this->load->model('Mdl_stock');
            $this->load->model('Mdl_item_master');
            $data['total_outstanding']=$this->Mdl_payment_booking->getTotalOutstanding();
            $data["advance"]=$this->Mdl_pending_advance->gettotaladvance();
            $data["due"]=$this->Mdl_pending_due->gettotaldue();
            $data["outstanding"]=$this->Mdl_invoice->gettmonthlyInvoice($_GET['m'],$_GET['y']);
            $data["credit"]=$this->Mdl_invoice->getcreditinvoice();
           
            $temp=$this->Mdl_item->getrentitem("","","","","");
            
            $total=0;
            foreach ($temp as $row)
            {
                $crstock=$this->Mdl_stock->getRentStockByItemInTable($row['item_id']);
                if($crstock<0)
                    $crstock=0;                                        
                $total+=$crstock*$row['price'];
            }
            
            $data["assign_stock_value"]=$total;
            $temp=$this->Mdl_item_master->getitem("","","","","");
            $total=0;
            foreach ($temp as $row)
            {
                $crstock=$this->Mdl_stock->getIdleItem($row['master_item_id']);
                for($i=0;$i<sizeof($crstock);$i++)
                {
                    $total+=$crstock[$i]*$row['price'];
                }                                        
                
            }
           
            $data["idle_stock_value"]=$total;
            $this->load->view('admin_dashboard',$data);
        }
        else
            $this->load->view('dashboard',$data);
    }
    public function printsunday()
    {
        $firstday=date('Y-m-01');
        $month=date('m');
        $year=date('Y');
        $lastday=date('Y-m-t');
        $begin  = new DateTime($firstday);
        $end    = new DateTime($lastday);
        $number = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 31

        //SELECT * FROM Project WHERE MONTH(DueDate) = 1 AND YEAR(DueDate) = 2010
        //SELECT * FROM Project WHERE MONTH(DueDate) = 1 AND YEAR(DueDate) = 2010

        //SELECT * FROM `devicelogs_10_2018` WHERE DATE(LogDate) NOT in('2018-10-07','2018-10-14','2018-10-21','2018-10-28') AND UserId=25


        echo $number."<br>";
        while ($begin <= $end) // Loop will work begin to the end date 
        {
            if($begin->format("D") == "Sun") //Check that the day is Sunday here
            {
                echo "'". $begin->format("Y-m-d") . "',";
            }

            $begin->modify('+1 day');
        }
    }
  
    public function export(){
		echo "kjhkjhk";
      	exit;
    }

}
?>