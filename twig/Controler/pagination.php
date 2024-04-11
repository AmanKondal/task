<?php
class Pagination{
	var $baseURL		= '';
	var $totalRows  	= '';
	var $perPage	 	= '';
	var $numLinks		=  10;
	var $currentPage	=  '';
	var $firstLink   	= '&lsaquo; First';
	var $nextLink		= 'Next';
	var $prevLink		= 'Prev';
	var $lastLink		= 'Last &rsaquo;';
	var $fullTagOpen	= '<div class="pagination">';
	var $fullTagClose	= '</div>';
	var $firstTagOpen	= '';
	var $firstTagClose	= '&nbsp;';
	var $lastTagOpen	= '&nbsp;';
	var $lastTagClose	= '';
	var $curTagOpen		= '&nbsp;<b>';
	var $curTagClose	= '</b>';
	var $nextTagOpen	= '&nbsp;';
	var $nextTagClose	= '&nbsp;';
	var $prevTagOpen	= '&nbsp;';
	var $prevTagClose	= '';
	var $numTagOpen		= '&nbsp;';
	var $numTagClose	= '';
	var $anchorClass	= '';
	var $showCount      = true;
	var $currentOffset	= 0;
	var $contentDiv     = '';
    var $additionalParam= '';
	var $link_func      = '';
    
	function __construct($params = array()){
		if (count($params) > 0){
			$this->initialize($params);		
		}
		if ($this->anchorClass != ''){
			$this->anchorClass = 'class="'.$this->anchorClass.'" ';
		}	
	}
	function initialize($params = array()){
		if (count($params) > 0){
			foreach ($params as $key => $val){
				if (isset($this->$key)){
					$this->$key = $val;
				}
			}		
		}
	}
	
	// Generate the pagination links	
	function createLinks(){ 
		if ($this->totalRows == 0 OR $this->perPage == 0){

			return '';
		}
		// Calculate the total number of pages
		$numPages = ceil($this->totalRows/ $this->perPage);
		
		// Links content string variable
		$output = '';
		
		// Is the page number beyond the result range? the last page will show
		if ($this->currentPage > $this->totalRows){
			$this->currentPage = ($numPages - 1) * $this->perPage;
		}
		
		$uriPageNum = $this->currentPage;
		$this->currentPage = floor(($this->currentPage/$this->perPage) + 1);

		// Calculate the start and end numbers. 
		$start = (($this->currentPage - $this->numLinks) > 0) ? $this->currentPage - ($this->numLinks - 1) : 1;
		$end   = (($this->currentPage + $this->numLinks) < $numPages) ? $this->currentPage + $this->numLinks : $numPages;


		// Render the "previous" link
		if  ($this->currentPage != 1){
			$i = $uriPageNum - $this->perPage;
			if ($i == 0) $i = '';
			$output .= $this->prevTagOpen 
				. $this->getAJAXlink( $i, $this->prevLink )
				. $this->prevTagClose;
		}

		// Write the digit links
		for ($loop = $start -1; $loop <= $end; $loop++){
			$i = ($loop * $this->perPage)+1 - $this->perPage;
					
			if ($i >= 0){
				if ($this->currentPage == $loop){
					$output .= $this->curTagOpen.$loop.$this->curTagClose;
				}else{
					$n = ($i == 0) ? '' : $i;
					$output .= $this->numTagOpen
						. $this->getAJAXlink( $n, $loop )
						. $this->numTagClose;
				}
			}
		}

		// Render the "next" link
		if ($this->currentPage < $numPages){
			$output .= $this->nextTagOpen 
				. $this->getAJAXlink( $this->currentPage * $this->perPage , $this->nextLink )
				. $this->nextTagClose;
		}


		// Remove double slashes
		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->fullTagOpen.$output.$this->fullTagClose;
		
		return $output;		
	}

	function getAJAXlink( $count, $text) {
        if($this->link_func == '' && $this->contentDiv == '')
            return '<a href="'.$this->baseURL.'?'.$count.'"'.$this->anchorClass.'>'.$text.'</a>';
		$pageCount = $count?$count:0;
		if(!empty($this->link_func)){
			$linkClick = 'onclick="'.$this->link_func.'('.$pageCount.')"';
		}else{
			$this->additionalParam = "{'page' : $pageCount}";
			$linkClick = "onclick=\"$.post('". $this->baseURL."', ". $this->additionalParam .", function(data){
					   $('#". $this->contentDiv . "').html(data); }); return false;\"";
		}
		
	    return "<a href=\"javascript:void(0);\" " . $this->anchorClass . "
				". $linkClick .">". $text .'</a>';
	}
}
?>