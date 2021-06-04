<?php
/**
 * Functions.php will contain all the common functions
 * which are related to the databse. these functions are totally
 * independent.
 */

    function send_mail($mail, array $param)
    {

        // Set mailer to use SMTP
        $mail->isSMTP();  

        // Specify main and backup SMTP servers                
        $mail->Host = "smtp.gmail.com";  

        //Enable SMTP authentication
        $mail->SMTPAuth = true;   

        //SMTP username
        $mail->Username = "getwebsquad@gmail.com"; 

        //SMTP password
        $mail->Password = "01778414604-Gmail"; 
            
        //Enable TLS encryption, `ssl` also accepted
        $mail->SMTPSecure = "tls"; 

        // TCP port to connect to                          
        $mail->Port = 587;     
        
        //set from E-mail Address
        $mail->setFrom("getwebsquad@gmail.com", "LOBSTER");

        //First clear all Recipients E-mail Address
        $mail->clearAllRecipients();

        //add receiver E-mail Address
        if(isset($param['receiver_name'])){

            $mail->addAddress($param['receiver'], $param['receiver_name']);

        }else{

            $mail->addAddress($param['receiver']);
        }

        //Add a reply to E-mail Address
        $mail->addReplyTo("noreply@getwebsquad.com","No Reply");

        //Set email format to HTML
        $mail->isHTML(true);                                
        
        //Add E-mail Subject
        $mail->Subject = $param['subject'];

        //Add E-mail Body
        $mail->Body    = $param["body"];

        //Add E-mail alt body
        $mail->AltBody = $param["alt_body"];


        //add attachments
        if(isset($param["attachment"])){

            $mail->addAttachment($param["attachment"]);        
        }
        
            //Finally Send the email address
        if(!$mail->send()) {

            return false;
        
        } else {

            return true;
        }

    }
    
    function short_str_word($str,$limit)
    {
    
        $output = "";
    
        $str_array=explode(" ",$str);

        $str_length=count($str_array);

        if($str_length > $limit){

            $str_short=array_slice($str_array,0,$limit);
            
            $output=implode(" ",$str_short). "...";

        }else{

            $output = $str;
        }

        return $output;


    }

    function generate_random_str($length)
    {

        //random charecters for generating random strings
        $random_char="abcdefghijklmnopqrstuvwxyz-_ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        //genrate the random string by using substr and str_shuffle functions
        $string = substr(str_shuffle($random_char),0,$length);
        
        return $string;

        // die();

        // $model_obj=$param["model_obj"];
    
        // $output=$model_obj->select(array(
        //     "where"=>"{$param['column']}='{$generate_string}'"
        // ));

        // $num_rows=$output["num_rows"];

        // if($output["status"] == 1){

        //     while($num_rows > 0){

        //         $generate_string=substr(str_shuffle($string),0,$param["length"]);
        //         $output=$model_obj->select(array(
        //             "table_name"=>"{$param['table_name']}",
        //             "where"=>"{$param['column']}='{$generate_string}'"
        //         ));

        //         $num_rows=$output["num_rows"];
        //     }

        //     return filter_var($generate_string,FILTER_SANITIZE_URL);

        // }else{

        //     echo $output["error"];
        //     die();

        // }

    }

    function get_time_in_ago($date)
    {
        $output = "";

        //set the time zone to Asia/Dhaka
        date_default_timezone_set("Asia/Dhaka");

        //get the $date timestamp
        $date_timestamp=strtotime($date);

        //get the current timestamp
        $current_timestmp=strtotime("now");

        //calculate tatal time difference by subtracting $current_timestmp and $date_timestamp
        $time_diff = ($current_timestmp - $date_timestamp);
    

         //1 minitue in seconds(60)
        $one_minute=60;

        //1 hour in secondes(,600)
        $one_hour= ($one_minute * 60);

        //1 day in secondes(86400)
        $one_day=($one_hour * 24);
            
        //1 week in secondes(604800)
        $one_week=($one_day * 7);
        
        /**
         * Total seconds in a month will be calculated
         * from total days of the last month
         */
        $days_in_last_month=date("t", mktime(0,0,0, date("n") - 1));

        //1 month in secondes(259200) 
        $one_month=($one_day *  $days_in_last_month);

        /**
         * In order to count total seconds in a year.
         * we have to check whather the last was leap year
         */
        
        $is_last_year_leap_year=date("L", mktime(0,0,0,2,0,date("Y")-1));

        //1 year in secondes(31536000) 
        $one_year= ($is_last_year_leap_year) ? ($one_day * 366) : ($one_day * 365);

        if($time_diff < $one_minute){

            $output = "Just now";

        }elseif($time_diff >= $one_minute && $time_diff < $one_hour){

            //calcute the total mintes
            $time = ceil($time_diff/$one_minute);
        
            $output = ($time_diff < ($one_minute * 2)) ? $time . " minute ago" : $time . " minutes ago";

        }elseif($time_diff >= $one_hour && $time_diff < $one_day){

             //calcute the total minutes
            $time = ceil($time_diff/$one_hour);
        
            $output = ($time_diff < ($one_hour * 2)) ? $time . " hour ago" : $time . " hours ago";

        }elseif($time_diff >= $one_day && $time_diff < $one_week){
            
            //calcute the total days
            $time = ceil($time_diff/$one_day);
        
            $output = ($time_diff < ($one_day * 2)) ? $time . " day ago" : $time . " days ago";


        }elseif($time_diff >= $one_week && $time_diff < $one_month){

            //calcute the total weeks
            $time = ceil($time_diff/$one_week);
        
            $output = ($time_diff < ($one_week * 2)) ? $time . " week ago" : $time . " weeks ago";

        }elseif($time_diff >= $one_month && $time_diff < $one_year){


            //calcute the total months
            $time = ceil($time_diff/$one_month);
        
            $output = ($time_diff < ($one_month * 2)) ? $time . " month ago" : $time . " months ago";

        }elseif($time_diff >= $one_year){

            //calcute the total yeasrs
            $time = ceil($time_diff/$one_year);
        
            $output = ($time_diff < ($one_year * 2)) ? $time . " year ago" : $time . " years ago";
        }

        return $output;
    
    }

    function number_format_short($n, $precision = 1)
    {

        if($n < 900){
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';

        }elseif($n < 900000){

            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';

        }elseif($n < 900000000){
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';

        }elseif($n < 900000000000){
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';

        }else{
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }
        
        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if( $precision > 0){
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }

        return $n_format . $suffix;
    }
