<?php
	/**
	 * 
	 */
	class ResponseData
	{
		public $errorCode;
		public $message;
		public $data;

		function __constructor(){
			$this -> errorCode = 1;
            $this -> message = "Error";
            $this -> data = nulll;
		}


        public static function ResponseSuccess($msg, $data){
        	if(!empty($data))
        	{
        	    if (gettype($data) != "array") {
        	        $data = array($data);
                }
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