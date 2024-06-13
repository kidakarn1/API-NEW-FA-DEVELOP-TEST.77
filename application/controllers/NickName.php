<?php
class NickName extends CI_Controller
{
    public function GET_HOUR(){
        $shift = $_GET['shift'];
        $shift_times = array(
            'A' => array('start' => '08:00', 'end' => '17:00'),
            'B' => array('start' => '20:00', 'end' => '05:00'),
            'P' => array('start' => '08:00', 'end' => '20:00'),
            'Q' => array('start' => '20:00', 'end' => '08:00'),
            'S' => array('start' => '20:00', 'end' => '05:00'),
            'M' => array('start' => '17:00', 'end' => '20:00'),
            'N' => array('start' => '05:00', 'end' => '08:00')
        );
    
        if (!array_key_exists($shift, $shift_times)) {
            return "Invalid shift";
        }
    
        $start_time = new DateTime($shift_times[$shift]['start']);
        $end_time = new DateTime($shift_times[$shift]['end']);
    
        // ถ้ากะสิ้นสุดในวันถัดไป (เวลาเริ่มต้นมากกว่าเวลาสิ้นสุด)
        if ($start_time > $end_time) {
            // เพิ่มหนึ่งวันให้กับเวลาสิ้นสุด
            $end_time->modify('+1 day');
        }
    
        // คำนวณความแตกต่างของเวลา
        $interval = $start_time->diff($end_time);
    
        // แปลงความแตกต่างเป็นชั่วโมงและนาที
        $hours = $interval->h;
        $minutes = $interval->i;
    
        // คืนค่าผลลัพธ์เป็นชั่วโมง
        $duration = $hours + ($minutes / 60);

        // แปลงผลลัพธ์เป็น JSON
        echo json_encode($duration);
       
    }
}