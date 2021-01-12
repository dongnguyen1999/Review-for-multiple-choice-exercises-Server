<?php
 include_once("dbconnect.php");
	/**
	 * 
	 */
	class ResponseData
	{
		public $errorCode;
		public $message;
		public $data;

		function __contructor(){
			$this -> errorCode = 1;
            $this -> message = "Error";
            $this -> data = nulll;
		}


        public static function ResponseSuccess($msg, $data){
        	global $conn;
        	$resultArr = array();

        	if(!empty($data))
        	{
        		$resultArr = array('errorCode' => 0, 'message' => $msg, 'data' => $data);
        	}else{
        		$resultArr = array('errorCode' => 1, 'message' => 'Không có dữ liệu', 'data' => null);
        	}
 			
 			echo json_encode($resultArr);
        }

        public static function ResponseFail($msg){
        	$resultArr = array('errorCode' => 1, 'message' => $msg, 'data' => null);
 			echo json_encode($resultArr);
        }

	}
?>