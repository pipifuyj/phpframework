<?php
class Model{
	public $_record="ModelRecord";//私有变量，保存Model里的Record类名，以对应Record类文件，并设置默认值
	public $_store="ModelStore";//私有变量，保存Model里的Store类名，以对应Store类文件，并设置默认值
	public $framework=null;//framework的引用
	public $id="";
	public $path="";
	public $fields=array();//Model的对应的域名（即：attribute）
	function construct(){//Model对象实体化的构造函数
		$this->Fields=array();
		foreach($this->fields as &$field){
			if(is_string($field))$field=new ModelField($field);
			elseif(is_array($field)){
				$name="Model{$field['type']}Field";
				$field=new $name($field);
			}
			$this->Fields[$field->name]=$field;
		}
		//判断是否有public $_record里定义的record文件，如有则保存到私有变量，_record并require进来。
		require_once("{$this->_record}.php");
		$path="{$this->path}/{$this->id}{$this->_record}.php";
		if(is_file($path)){
			require_once($path);
			$this->_record="{$this->id}{$this->_record}";
		}
		//判断是否有public$_store定义的store文件
		require_once("{$this->_store}.php");
		$path="{$this->path}/{$this->id}{$this->_store}.php";
		if(is_file($path)){
			require_once($path);
			$this->_store="{$this->id}{$this->_store}";
		}
	}
	public function hasField($name){
		return isset($this->Fields[$name]);
	}
	public function field($name){
		return $this->Fields[$name];
	}
	public function record($data=array(),$id=null){
		$name=$this->_record;
		$record=new $name();
		$record->model=&$this;
		$record->construct($data,$id);
		return $record;
	}
	public function store(){
		$name=$this->_store;
		$store=new $name();
		$store->model=&$this;
		$store->construct();
		return $store;
	}
}
?>
