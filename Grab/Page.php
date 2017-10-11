<?

namespace Grab;
include_once "simple_html_dom.php";

class Page{
	
	protected $_clear_link = "https://www.finn.no/pw/search/car-norway?orgId=1556904584";
	protected $_one_link = "https://www.finn.no/pw/ad/" ;
	
	
	protected $_count = 0;
	private $_list  = [];
	protected $_url  ;
	protected $_html;
	
	
	public function __construct($url = NULL  ){
		if ($url){
			$this->_url = $this->_clear_link.$url;
		}else{
			$this->_url = $this->_clear_link;
		}
		
	}
	
	
	
	
	
	/**
	* functon load html dom 
	* @return true|false
	*/
	public function load(){
		
		$this->_html  = file_get_html($this->_url);
		return true;
	}
	
	
	
	/**
	* 
	* 
	* @return array evry value is option
	*/
	public function get_select(){
		$select = [];
		$query =  $this->_html->find(".inlineblockify option");
		foreach($query as $value){
			$select[] = $value;
		}
		return $select;
	}
	
	/**
	* 
	* 
	* @return array for list
	*/
	public function get_list(){
		$list = [];
		$query =  $this->_html->find(".result-item");
		foreach($query as $value){
			
			$url = $value->getElementByTagName("a")->getAttribute("href"); 	
			
			$url = str_replace($this->_one_link,"",$url);
					
			$img = $value->getElementByTagName("img")->getAttribute("src");
			$title = $value->find(".t4",0)->plaintext;
			$values = $value->find(".t5 span");
			
			$year = $values[0];
			$distance = $values[1];
			$price = $values[2];
			
			
			$desc= $value->find("ul.d1 li",1)->plaintext;

			$list[$url] = ['url'=>$url,'img'=>$img,'title'=>$title,
			'year'=>$year,'distance'=>$distance,'price'=>$price,'desc'=>$desc];
		}
		
		return $list;
	}

	/**
	* 
	* @param undefined $id
	* 
	* @return correct url
	*/
	public function link_to_car($id){
		$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		if (strpos($url,"?") != FALSE){
			return $url."&car=".$id;
		}else{
			return $url."?car=".$id;
		}
	}
	
}