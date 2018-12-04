<?php
class Queue {

	protected function pullQueue()
	{	
		$url = array_shift($this->queue);
		$this->push2visited($url);
		
		return $url;
	} 

	protected function pushQueue($urls)
	{	
		if(!empty($urls))
		{
			foreach($urls as $url) 
			{	
				array_push($this->queue, $url);
			}
		}

		$this->queue = array_diff($this->queue,$this->visited);
	}

	protected function push2visited($url)
	{
		array_push($this->visited,$url);
	}
} 

?>