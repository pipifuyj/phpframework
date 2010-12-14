<?php
require_once("ModelStore.php");
class ModelMongoStore extends ModelStore{
	public $mongodb;
	public $collection;
	public function construct(){
		if(!$this->mongodb)$this->mongodb=$this->model->framework->mongodb;
		if($this->collection)$this->collection=$this->mongodb->selectCollection($this->collection);
		parent::construct();
	}
	/**
	 *return a boolean representing if the array was not empty
	 *an empty array will not be inserted
	 */
	public function add($doc){
		return $this->collection->insert($doc);	
	}
	/**
	 *function:  Querys this collection
	 *parameters:
	 *    $query: the fields for which to search
	 *    $order: results should be sorted by what? ASC(1) or DESC(-1)?
	 *    $fields: Fields of the results to return
	 *return:
	 *    the array of search result
	 */
	public function where($query=array(),$order=array('_id'=>1),$start=0,$limit=0,$fields=array()){
		//a collection contaims different documents，different documents are given different fields
		$cursor=$this->collection->find($query,$fields);
		$cursor->sort($order);
		if($start)$cursor->skip($start);
		if($limit)$cursor->limit($limit);
		$docs=array();
		foreach($cursor as $index=>$value){
			//$docs[]=new $this->model->record($value,$value['_id']);
			$docs[]=$value;
		}
		return $docs;
	}
	public function delete($filters=array()){
		$this->collection->remove($filters);
	} 
	/**
	 *update: update records based on a given criteria
	 *filters: description of the objects to update
	 *newobj: the object with which to update the matching record
	 *array("multiple"=>true): it updates all matching documents by default
	 */
	public function update($filters=array(),$newdoc=array()){
		return $this->collection->update($filters,$newdoc,array("multiple" => true));	
	}
	/**
	 *getTotalCount: find out the number of documents
	 *parameters:
	 *    $query: the restriction to those documents you want to count 
	 *    $limit: indicate that if the cursor limit and skip information is applicable to the count function
	 *return: the number of documents returned by the query
	 */
	public function getTotalCount($query=array(),$limit=false){
		$cursor=$this->collection->find($query);
		return $cursor->count($limit);
	}
	/**
	 *get the name of the collection(just like a table in mysql)
	 */
	public function getName(){
		return $this->collection->getName();
	}
}
?>
