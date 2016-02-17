<?php namespace App\Lists;

use Session;

class BaseList {
	protected $objects;
    protected $data_arr = array();
	protected $filter;
	protected $keys;
    protected $maxPerPage = 20;
	private $paginationForm = null;
    
    /**
	 * Create a new BaseList instance.
	 *
	 * @return bool
	 */
    public function __construct(){
        
    }
    
	/**
	 * Handle filter request for creating propel query.
	 *
	 * @param  array  $filter_request
	 * @param  string   $filter_name
	 * @return bool
	 */
    public function handleFilterRequest($filter_request, $filter_name){
		if(session($filter_name)) $filter = session($filter_name);
		else $filter = array();
        
		if(isset($filter_request['reset'])){
			session::forget($filter_name);
            $filter = array();
			$this->createQuery($filter, false);
		}
		else if(isset($filter_request['search'])){
			$this->createQuery($filter_request, true);
		}
		else{
			$this->createQuery($filter, false);
		}
    }
    
    /**
	 * Set paginationForm html.
	 *
	 * @param  int  $cnt
	 * @param  int   $page
	 * @param  string  $path
	 * @return bool
	 */
    public function setPaginationForm($cnt, $page, $path){
        if($cnt > $this->maxPerPage){
			$this->paginationForm = '<ul class="pagination pagination-sm">';
			if($page > 1) {
				$this->paginationForm .= '<li><a href="'.url($path.'/page/1').'"><span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span></a></li>';
				$this->paginationForm .= '<li><a href="'.url($path.'/page/'.($page-1)).'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
			}
			$num_pages = ceil($cnt/$this->maxPerPage);
			
			if($page < 5) $sp = 1;
			elseif($page >= ($num_pages - 2) ) $sp = $num_pages - 5 + 1;
			elseif($page >= 5) $sp = $page  - 2;
			
			for($i = $sp; $i < $sp+5; $i++){
				if($i > $num_pages) continue;//break;
				if($page == $i) $this->paginationForm .= '<li class="active"><a href="'.url($path.'/page/'.$i).'">'.$i.'</a></li>';
				else $this->paginationForm .= '<li><a href="'.url($path.'/page/'.$i).'">'.$i.'</a></li>';
			}
			if($page < $num_pages){
				$this->paginationForm .= '<li><a href="'.url($path.'/page/'.($page+1)).'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
				$this->paginationForm .= '<li><a href="'.url($path.'/page/'.$num_pages).'"><span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span></a></li>';
			}
			$this->paginationForm .= '</ul>
			<div class="pagination-info">Page '.$page.' of '.$num_pages.'</div>';
		}
    }
    
    /**
	 * Getter for keys array.
	 *
	 * @return array
	 */
	public function getKeys(){
		return $this->keys;
	}
	
	/**
	 * Getter for data_arr array.
	 *
	 * @return array
	 */
	public function getDataArr(){
		return $this->data_arr;
	}
    
    /**
	 * Getter for paginationForm html.
	 *
	 * @return string
	 */
	public function getPaginationForm(){
		return $this->paginationForm;
	}
}

?>