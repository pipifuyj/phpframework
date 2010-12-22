<?php
//require_once("ModelRecord.php");
class ModelMongoRecord {
	public $model=null;
	public $id=null;
	public $data=array();

	public function construct($data=array(),$id=null){
		$this->id=$id;
		$this->data=$data;
	}
	public function __toString(){
		return json_encode($this->data);
	}
	public function __get($name){
		return $this->get($name);
	}
	public function get($key){
		$result=array();
		$this->travel($this->data,$key,$result);
		//$record=new ModelMongoRecord();
		//$record->construct($result);
		if(count($result)==1)return $result[0];
		else return $result;
	}
	public function travel($arr,$name,&$res,$path=""){
		if(!is_array($arr)){
			return false;
		}
		foreach($arr as $key => $val ) {
			if ($key!==$name) {
				if($path=="")$this->travel($val,$name,$res,ucfirst($key));
				else $this->travel($val,$name,$res,ucfirst($path).ucfirst($key));
			}else {
				if($path=="")$path=ucfirst($key);
				else $path=ucfirst($path).ucfirst($key);
				//$res[$path]=$val;
				$res[]=$val;
			}
		}
	}
}
?>
