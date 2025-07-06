<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/08/2017
 * Time: 12:58
 */
class Setting extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        $data['title']="Setting";
        $this->load->model('Mdl_setting');
    }

    public function access()
    {
        $data['title']="Setting";
        $data['staffrecords'] = $this->Mdl_setting->getstaffrecords();
        $data['catrecords'] = $this->Mdl_setting->getcatrecords();
        $data['modulerecords'] = $this->Mdl_setting->getmodulerecord();
        //  $isview=$this->Mdl_setting->is_access($this->session->userdata('user_id'),1,73,'is_view');
        // print_r($isview);
        // exit();
        //print_r($data); exit();
        $this->load->view('Setting/access_modules',$data);
    }
    
        function add_access_module()
    {
        if(isset($_POST['module_submit'])){
            for ($count = 0; $count < count($_POST['emp_id']); $count++)
            {
                $emp_id = $_POST['emp_id'][$count];
                $mcat_id = $_POST['mcat_id'][$count];
                $msubcat_id = $_POST['msubcat_id'][$count];
                $is_view = $_POST['is_view'][$emp_id][$mcat_id][$msubcat_id]; if($is_view=='') $is_view=0;
                $is_add = $_POST['is_add'][$emp_id][$mcat_id][$msubcat_id]; if($is_add=="") $is_add=0;
                $is_delete = $_POST['is_delete'][$emp_id][$mcat_id][$msubcat_id]; if($is_delete=="") $is_delete=0;
                $count_availability = $this->Mdl_setting->check_access_availability($emp_id,$mcat_id,$msubcat_id);
                if($count_availability==0)
                {
                    $insert_access = $this->Mdl_setting->insert_access($emp_id,$mcat_id,$msubcat_id,$is_view,$is_add,$is_delete);
                    $this->session->set_flashdata('update','Access Module Added Successfully');
                }
                else
                {
                    $update_access = $this->Mdl_setting->update_access($emp_id,$mcat_id,$msubcat_id,$is_view,$is_add,$is_delete);
                    $this->session->set_flashdata('update','Access Module updated Successfully');
                }
            }
            redirect('Setting/access');
        }}

//     function add_access_module()
//     {
//         //var_dump($_POST); exit();
//         if(isset($_POST['module_submit'])){
//         for ($count = 0; $count < count($_POST['emp_id']); $count++)
//             {
//                 //echo $count."&nbsp;";
                
//               $emp_id = $_POST['emp_id'][$count];
//               //echo $emp_id."&nbsp;";
//               $mcat_id = $_POST['mcat_id'][$count];
//               //echo $mcat_id."&nbsp;";
//               $msubcat_id = $_POST['msubcat_id'][$count];
//               //echo $msubcat_id."&nbsp;";
//                 //if(isset($_POST['is_view'][]))
//                  $is_view = $_POST['is_view'][$emp_id];
//                  if($is_view=="")
//                     $is_view=0;
//             //echo $is_view."&nbsp;";
//                     $is_add = $_POST['is_add'][$emp_id]; 
//                      if($is_add=="")
//                     $is_add=0;
//                  //echo $is_add."&nbsp;";
//                  $is_delete = $_POST['is_delete'][$emp_id];
//                   if($is_delete=="")
//                     $is_delete=0;
//                 // echo $is_delete;
//                  //echo "<pre>";
//               $count_availability = $this->Mdl_setting->check_access_availability($emp_id,$mcat_id,$msubcat_id);
              
//               if($count_availability==0)
//                  {
//                   // ho "insert";
//                   $insert_access = $this->Mdl_setting->insert_access($emp_id,$mcat_id,$msubcat_id,$is_view,$is_add,$is_delete);
//                     $this->session->set_flashdata('update','Access Module Added Successfully');
//                  }
//                  else
//                  {
//                   // ho "update";
//                      $update_access = $this->Mdl_setting->update_access($emp_id,$mcat_id,$msubcat_id,$is_view,$is_add,$is_delete);
//                      $this->session->set_flashdata('update','Access Module updated Successfully');
//                  }
//             }
            
//             redirect('Setting/access');
//         }
//           //  exit();



// //        if(isset($_POST['module_submit'])) {
// //
// //
// //


// //            for($count = 0; $count < count($id); $count++)
// //            {
// //                $data = array(
// //                    ':name'   => $name[$count],
// //                    ':address'  => $address[$count],
// //                    ':gender'  => $gender[$count],
// //                    ':designation' => $designation[$count],
// //                    ':age'   => $age[$count],
// //                    ':id'   => $id[$count]
// //                );
// //                $query = "
// //          UPDATE tbl_employee
// //          SET name = :name, address = :address, gender = :gender, designation = :designation, age = :age
// //          WHERE id = :id
// //          ";
// //                $statement = $connect->prepare($query);
// //                $statement->execute($data);
// //            }
//       //  }
//     }

    public function access1()
    {
        $data['title']="Setting";
        $data['staffrecords'] = $this->Mdl_setting->getstaffrecords();
        $data['catrecords'] = $this->Mdl_setting->getcatrecords();
        //print_r($data); exit();
        $this->load->view('Setting/access_modules1',$data);
    }
}
?>