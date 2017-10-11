<?php
namespace Grab;
include_once "Page.php";

class Car extends Page{
	
	public function __construct($id ){
		$this->_url = $this->_one_link.$id;	
	}
	
	
	/**
	* @return array of images for one car
	*/
	public function get_all_images(){
		$query = $this->_html->find('.imagecontainer',0);
		$list  = [];
	    preg_match_all( '/src="([^"]*)"/i', $query, $list ) ;
	    return $list[1];
	
	}
	
	
	
	
	public function get_body(){
		return $this->_html->find(".bd",1);
	}
	
	public function get_contact(){
		$query = $this->_html->find(".removelastborder dd");
		return ['phone'=>$query[1],'person'=>$query[0]];
	}
	public function get_button_url(){
		return $this->_html->find("a.fullwidth",0)->getAttribute("href");
	}
	
}