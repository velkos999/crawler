<?php

include "crawler.class.php";

	$url = 'https://bmprice.ru';

	$crawler = new Crawler($url);

	$crawler->run();

	$crawler->results();

?>