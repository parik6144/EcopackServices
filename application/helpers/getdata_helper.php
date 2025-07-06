<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Bipin Kumar
 * Date: 13-06-2017
 * Time: 11:29 AM
 */
if ( ! function_exists('getData'))
{
    function getData($key,$user_id,$data_type = true)
    {
        $CI = & get_instance();
        $user_id = empty($user_id) ? $CI->session->userdata('active_user_id') : $user_id;
        $sql =  $CI->db->select('users.user_id,CONCAT(`first_name`," ",`last_name`) AS user_name,first_name,last_name,email,mobile_number,segments,profession_id,occupation.name,profile_img,img_name,`dob`,`gender`,`bio`,`contact_no`,`occupation`,`designation`,`company_name`,`qualification`,`university`,`professional_courses`,`address_line_1`,`address_line_2`,cities.`city_id`,states.`state_id`,countries.`country_id`,`zipcode`,`profile_img`,`profession_id`,`segments`,`city_name`,`country_name`, users.created_datetime,`online_user.last_seen`')
         ->from('users')
         ->join('user_profile', 'users.user_id = user_profile.user_id','left')
         ->join('images', 'user_profile.profile_img = images.id','left')
         ->join('occupation', 'user_profile.profession_id = occupation.id','left')
         ->join('cities', 'user_profile.city_id = cities.city_id','left')
         ->join('states', 'user_profile.state_id = states.state_id','left')
         ->join('countries', 'user_profile.country_id = countries.country_id','left')
         ->join('online_user', 'users.user_id = online_user.user_id','left')
         ->where(array("users.user_id"=>$user_id))
         ->get();
        $data = $sql->result();

       if($data) {
           if ($key === 'status') {

           }
           if ($key === 'status') {

           }
       }
    }
}
