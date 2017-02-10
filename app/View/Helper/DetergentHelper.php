<?php
class DetergentHelper extends AppHelper {

    /**/
	function __construct($options = array()) {
		return parent::__construct($options);
	}
    /**/

    public function urlsafe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_','.'),$data);

        return $data;
    }

    public function urlsafe_b64decode($string) {
        $data = str_replace(array('-','_','.'),array('+','/','='),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }

        return base64_decode($data);
    }

    public function get_as_of($date1, $date2 = null, $format = "F d, Y") {
            if (empty($date2)) $date2 = date('Y-m-d 00:00:00');

            $date1a = explode(" ", $date1);
            
            $timestamp1 = strtotime($date1a[0]." 00:00:00");
            #$timestamp1 = strtotime($date1);
            $timestamp2 = strtotime($date2);

            $seconds_diff = $timestamp2 - $timestamp1;
            $day_diff = floor($seconds_diff / 3600 / 24);
            
            if ($day_diff==0) {
                return "Today";
            } else if ($day_diff==1) {
                return "Yesterday";
            } else {
                return date($format, $timestamp1);
                //return $date1;
            }
    }

    

}

?>