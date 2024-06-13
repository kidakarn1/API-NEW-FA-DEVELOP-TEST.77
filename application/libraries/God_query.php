<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package CodeIgniter
 * @author  ExpressionEngine Dev Team
 * @copyright  Copyright (c) 2006, EllisLab, Inc.
 * @license http://codeigniter.com/user_guide/license.html
 * @link http://codeigniter.com
 * @since   Version 1.0
 * @filesource
 */

// --------------------------------------------------------------------

/**
 * CodeIgniter Template Class
 *
 * This class is and interface to CI's View class. It aims to improve the
 * interaction between controllers and views. Follow @link for more info
 *
 * @package   CodeIgniter
 * @author    Colin Williams
 * @subpackage  Libraries
 * @category  Libraries
 * @link    http://www.williamsconcepts.com/ci/libraries/template/index.html
 * @copyright  Copyright (c) 2008, Colin Williams.
 * @version 1.4.1
 * 
 */
 

class God_query {
   
   var $CI;
   var $config;
   var $template;
   var $master;
   var $regions = array(
      '_scripts' => array(),
      '_styles' => array(),
   );
   var $output;
   var $cust_name = array();
   var $css = array();
   var $parser = 'parser';
   var $parser_method = 'parse';
   var $parse_template = FALSE;
   
   /**
   * Constructor
   *
   * Loads template configuration, template regions, and validates existence of 
   * default template
   *
   * @access  public
   */
   
   //function CI_Template()
    public function __construct()
    {
     
    }


   
    public function welcome()
    {
       echo "Welcome God_query!!!!";  exit;
    }    
//-----------------------------------------------------------///function////------------------------//
    public function setCust($cust){

      $this->cust_name = $cust;

    } 
    public function getCust($cust){

      $this->cust_name = $cust;

      return $this->cust;
    }        







//-----------------------------------------------------------///run database////------------------------//






//-----------------------------------------------------------///Query String////------------------------//
    public function str_saleSep($date_pick1, $date_pick2, $pd){
        $sqlLoad = "SELECT
               ROW_NUMBER() OVER(ORDER BY T.DESINATED_DLV_DATE ASC) AS NO
              ,M.CUST_NAME AS CUST_NAME
              ,M.CUST_ANAME AS CUST_CD
              ,T.CUST_ITEM_CD AS CUST_ITEM_CD
              ,T.CUST_ITEM_NAME AS CUST_ITEM_NAME
              ,T.ITEM_CD 
              ,MI.ITEM_NAME 
              ,TO_CHAR(T.DESINATED_DLV_DATE,'YYYY/MM/DD') AS INVOICE_DATE
              ,T.INVOICE_NO AS INVOICE_NO
              ,T.SHIP_QTY
              ,'PCS' AS UNIT
              ,T.SHIP_UNIT_PRICE
              ,T.SHIP_AMOUNT
              FROM
               T_SHIP T
              ,M_CUST M
              ,M_ITEM MI
              WHERE
              T.CUST_CD = M.CUST_CD (+)
              AND T.ITEM_CD = MI.ITEM_CD (+)
              AND T.SHIP_WH_CD = '$pd'
              AND TO_CHAR(T.DESINATED_DLV_DATE,'YYYY/MM/DD') BETWEEN '$date_pick1' AND '$date_pick2' ";      

      return $sqlLoad ;
    }

    public function str_saleRep($date_pick1, $date_pick2, $pd){

        $sqlLoad = " SELECT
               ROW_NUMBER() OVER(ORDER BY T.SHIP_DATE ASC) AS NO
              ,TO_CHAR(T.SHIP_DATE,'YYYY-MM-DD') AS SHIP_DATE
              ,T.INVOICE_NO AS INVOICE_NO
              ,T.CUST_ODR_NO AS CUST_ODR_NO
              ,T.CUST_CD AS CUST_CD
              ,M.CUST_NAME AS CUST_NAME
              ,T.CUST_ITEM_CD AS CUST_ITEM_CD
              ,T.CUST_ITEM_NAME AS CUST_ITEM_NAME
              ,T.ITEM_CD AS ITEM_CD
              ,MI.ITEM_NAME
              ,T.SHIP_QTY AS QTY
              ,'PCS' AS UNIT
              ,T.SHIP_UNIT_PRICE
              ,T.SHIP_AMOUNT
              ,CASE WHEN SUBSTR(T.INVOICE_NO, 1, 2) IN ('F1', 'F2', 'F3', 'F4', 'E1', 'E2', 'E3') THEN 0 ELSE (T.SHIP_AMOUNT * 0.07) END AS VAT
              ,CASE WHEN SUBSTR(T.INVOICE_NO, 1, 2) IN ('F1', 'F2', 'F3', 'F4', 'E1', 'E2', 'E3') THEN ( T.SHIP_AMOUNT + 0 )  ELSE (T.SHIP_AMOUNT + (T.SHIP_AMOUNT * 0.07)) END AS TOTAL_VAT
              ,T.CUR_CD 
              FROM
               T_SHIP T
              ,M_CUST M
              ,M_ITEM MI
              WHERE
              T.CUST_CD = M.CUST_CD (+)
              AND T.ITEM_CD = MI.ITEM_CD (+)
              AND T.SHIP_WH_CD = '$pd'
              AND TO_CHAR(T.SHIP_DATE,'YYYY/MM/DD') BETWEEN '$date_pick1' AND '$date_pick2'
              --AND T.INVOICE_NO = 'F318070040'
              ORDER BY
              T.SHIP_DATE ";    

      return $sqlLoad ;
    }






////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
}
// END God_query Class

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */