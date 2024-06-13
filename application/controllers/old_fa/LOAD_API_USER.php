<?php
class LOAD_API_USER extends CI_Controller
{
   
	public function GET_TEST(){
        parse_str($_SERVER['QUERY_STRING'], $_GET); 
        $a = $_GET["user_id"];
	}
	public function test_redirect(){
	// header('Location: https://www.lotto.ktbnetbank.com/KTBLotto/#/login');
		header('Location: https://www.google.com/');
		// echo "<input type='submit' id='lname' name='lname' disabled>";
	}
}