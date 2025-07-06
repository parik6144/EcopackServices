<?php
/**
 * Created by PhpStorm.
 * User: SKYSCRAPER1
 * Date: 06-06-2017
 * Time: 12:08
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('convertDate'))
{
    function convertDate($date = '')
    {
        $last_access=strtotime($date);
        $newDateTime = date('h:i a', $last_access);
        if ($last_access >= strtotime("today"))
        {
            date_default_timezone_set('Asia/Calcutta');
            $current_time = time();
            $time_elapsed = $current_time - $last_access;
            $seconds = $time_elapsed;
            $minutes = round($time_elapsed/60);
            $hours = round($time_elapsed/3600);

            if($seconds <= 60){
                return "Just now";
            }elseif ($minutes <= 60){
                if($minutes == 1){
                    return "one minute ago";
                }else{
                    return "$minutes minutes ago";
                }
            }elseif ($hours <= 24){
                if($hours == 1){
                    return "an hour ago";
                }else{
                    return "$hours hrs ago";
                }
            }
        }

        else if ($last_access >= strtotime("yesterday"))
        {

            return "Yesterday at $newDateTime";
        }

        else
        {
            $olddate=date("d-M", $last_access);
            return $olddate." at ".$newDateTime;
        }
    }
}

if ( ! function_exists('logincheck'))
{
    function logincheck()
    {
        if(!isset($_SESSION['active_user_id']))
            redirect(site_url());
    }
}