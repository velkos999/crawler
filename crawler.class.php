<?php

include "queue.class.php";

class Crawler extends Queue 
{
	/**
	* array urls queue
	**/
	protected $queue = [];
	
	/**
	* array urls visited
	**/
	protected $visited = [];

	/**
	* array broken links (!200)
	**/
	protected $broken_links = [];


	public function __construct($url)
	{
		$this->pushQueue(array($url));
	}

	public function run()
	{
		while(!empty($this->queue))
		{	
			$this->crawler();
		}
	}

	private function crawler()
	{	
		$links = $this->step();

		$this->pushQueue($links);	
	}

	/**
	* @return all links on the page
	**/
	private function step()
	{	
		$url = $this->pullQueue();
		
		$html = @file_get_contents($url);
		
		if($this->get_http_status($http_response_header) !== 200)
			$this->push2broken_links($url);

		preg_match_all('/href="([^"]+)"/',$html,$matches);

		return $matches[1];
	}

	private function get_http_status($http_response_header)
	{	
		if(is_array($http_response_header))
	    {
	        $parts=explode(' ',$http_response_header[0]);
	        if(count($parts)>1)
	            return intval($parts[1]);
	    }
	    return 0;
	}

	private function push2broken_links($url)
	{
		array_push($this->broken_links,$url);
	}

	public function results()
	{	
		echo PHP_EOL;
		echo "########################";
		echo " VISITED ";
		echo "########################".PHP_EOL;
		print_r($this->visited);

		echo PHP_EOL;
		echo "########################";
		echo " BROKEN LINKS ";
		echo "########################".PHP_EOL;
		print_r($this->broken_links);
	}
}

?>