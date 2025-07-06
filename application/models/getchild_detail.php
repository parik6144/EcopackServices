<?php
include("../Database/database.php");
	if(isset($_POST['rch_id']))
	{
		$rch_id=$_POST['rch_id'];
		$sql="SELECT `child_id`,block_name,panchayat_name,health_service_center_short_name, `villege_id`,village_name,anganwadi_center, date_format(dob,'%d-%m-%Y') as dob, `gender`, `rch_id`, `mother_name`, `mother_age`, `aadhar_no`, period_of_gestation, `father_name`, `birth_institution`, `birth_place`, `weight`, `health_worker_name`, `health_worker_designation`, `sevika_name`, `sahiya_name`, `child_status` tbl_child_details.is_deleted FROM `tbl_child_details`left join tbl_anganwadi_center on tbl_anganwadi_center.anganwadi_center_id=tbl_child_details.anganwadi_center_id left join tbl_village on tbl_village.village_id=tbl_child_details.villege_id left join tbl_panchayat on tbl_panchayat.panchayat_id=tbl_child_details.panchayat_id left join tbl_health_service_center on tbl_health_service_center.health_service_center_id=tbl_child_details.health_service_center_id left join tbl_block on tbl_block.block_name_id=tbl_child_details.block_id WHERE child_id='".$rch_id."' and tbl_child_details.is_deleted='0'";
		$result=mysqli_query($link,$sql) or die(mysqli_error($link));
		$response=array();
		while($row=mysqli_fetch_assoc($result))
		{
			array_push($response, $row);
		}
		/*
		json_encode:- convert array to json string	
		*/
		echo json_encode($response);
	}
	if(isset($_POST['get_all']))
	{
	    $sql="SELECT `child_id`,DATE_FORMAT(dob,'%d-%m-%Y') as dob, `gender`, `rch_id`, `mother_name`, `mother_age`, `aadhar_no`,period_of_gestation , `father_name`, `birth_institution`, `birth_place`, `weight`, `health_worker_name`, `health_worker_designation`, `sevika_name`, `sahiya_name`,`child_status`,block_name,panchayat_name,health_service_center_short_name,village_name,anganwadi_center FROM `tbl_child_details` left join tbl_block on tbl_child_details.block_id=tbl_block.block_name_id left join tbl_panchayat on tbl_child_details.panchayat_id=tbl_panchayat.panchayat_id left join tbl_health_service_center on tbl_child_details.health_service_center_id=tbl_health_service_center.health_service_center_id left join tbl_village on tbl_child_details.villege_id=tbl_village.village_id left join tbl_anganwadi_center on tbl_child_details.anganwadi_center_id=tbl_anganwadi_center.anganwadi_center_id  WHERE tbl_block.is_deleted='0' and tbl_panchayat.is_deleted='0' and tbl_health_service_center.is_deleted='0' and tbl_village.is_deleted='0' and tbl_anganwadi_center.is_deleted='0'";
	        $result=mysqli_query($link,$sql);
	        $response=array();
	        if(mysqli_num_rows($result)>0)
	        {
	            $ctr=1;
	            
	            while ($row=mysqli_fetch_assoc($result)) {
	            	array_push($response, $row);
	            }
	        }
	        echo json_encode($response);
	}
?>