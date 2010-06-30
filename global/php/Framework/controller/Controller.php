<?php
class Controller{
	public $framework=null;
	public function index($request=null,$session=null){//index方法什么都不做
		return true;
	}
	public function __call($method,$args){//如果访问一个不存在的方法，那么默认调用index方法
		$this->index();
	}
	public function __get($name){//重载.号方法，表示要引用的属性
		return $this->framework->$name;
	}
}
?>