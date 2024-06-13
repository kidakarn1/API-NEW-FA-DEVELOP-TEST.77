<?php 
class NoongHelper {
  public $name;
  public $color;

  function __construct($name) {
    $this->name = $name; 
  }
  function EncryptNN($str) {
  	$s1 = base64_encode($str);
    $s1 = strlen($s1) < 65 ? str_pad($s1,65,"#") : $s1;
    
	$set1 = substr($s1, 0, 10);
	$set2 = substr($s1, 10, 5);
	$set3 = substr($s1, 15);
	$set4 = ($set1 . $set3);

	$setA = substr($set4, 0, 28);
	$setB = substr($set4, 28);
	$setC = $setA . $set2 . $setB;
    
    $s2 = $setC;
	$set1 = substr($s2, 0, 15);
	$set2 = substr($s2, 15, 15);
	$set3 = substr($s2, 30);
	$set4 = ($set1 . $set3);

	$setA = substr($set4, 0, 30);
	$setB = substr($set4, 30);
	$setC = $setA . $set2 . $setB;
    
    $s3 = $setC;
	$set1 = substr($s3, 0, 30);
	$set2 = substr($s3, 30, 5);
	$set3 = substr($s3, 35);
	$set4 = ($set1 . $set3);

	$setA = substr($set4, 0, 35);
	$setB = substr($set4, 35);
	$setC = $setA . $set2 . $setB;    
    
    $rst = substr($setC, 0, -2);
    return "NONGNOOCH-TICKET={$rst}";
  }
  
  function DecryptNN($str) {
  	
  	$s1 = str_replace("NONGNOOCH-TICKET=", "", $str) . "==";
    
	$set1 = substr($s1, 0, 35);
	$set2 = substr($s1, 35, 5);
	$set3 = substr($s1, 40);
	$set4 = ($set1 . $set3);

	$setA = substr($set4, 0, 30);
	$setB = substr($set4, 30);
	$setC = $setA . $set2 . $setB;
    
    $s2 = $setC;
	$set1 = substr($s2, 0, 30);
	$set2 = substr($s2, 30, 15);
	$set3 = substr($s2, 45);
	$set4 = ($set1 . $set3);

	$setA = substr($set4, 0, 15);
	$setB = substr($set4, 15);
	$setC = $setA . $set2 . $setB;
    
    $s3 = $setC;
	$set1 = substr($s3, 0, 28);
	$set2 = substr($s3, 28, 5);
	$set3 = substr($s3, 33);
	$set4 = ($set1 . $set3);

	$setA = substr($set4, 0, 10);
	$setB = substr($set4, 10);
	$setC = $setA . $set2 . $setB;    
    $setD = base64_decode($setC);
    
    $rst = str_replace("#", "", $setD) ;
    return $rst;
  }  
}
?>