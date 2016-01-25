<?php

require 'scraperwiki.php';
$endtime = time() + (60 * 60) * 23; //23h 
	for ($page = 1; $page <= 1; $page++) {
	
	print $page;
	ripByPage($page);
	print "!";
	}
	
function ripByPage($page){
	$pathToDetails = 'http://aramestan.e-sanandaj.ir/BurialRequest/DeadSearch?keyword=&firstName=&lastName=&fatherName=&partNo=0&rowNo=&graveNo=&deathDateFrom=&deathDateTo=&bornDateFrom=&bornDateTo=&page=' . $page;
	$output = scraperwiki::scrape($pathToDetails);
	
	$resultingJsonObject = json_decode($output);
	for ($id = 0; $id <= 9; $id++)
        {
        	$entry = array(
				'id'      => $resultingJsonObject->{'result'}[$id]->{'Id'},
				'fullname' => $resultingJsonObject->{'result'}[$id]->{'DeadFullName'},
				'fathername' => $resultingJsonObject->{'result'}[$id]->{'DeadFatherName'},
				'birthdate' => $resultingJsonObject->{'result'}[$id]->{'BornDate'},
				'deathdate' => $resultingJsonObject->{'result'}[$id]->{'DeathDate'},
				'partNo' => $resultingJsonObject->{'result'}[$id]->{'PartNo'},
				'rowNo' => $resultingJsonObject->{'result'}[$id]->{'RowNo'},
				'graveNo' => $resultingJsonObject->{'result'}[$id]->{'GraveNo'},
				'gender'  => $resultingJsonObject->{'result'}[$id]->{'Gender'},
				'identityCode' => $resultingJsonObject->{'result'}[$id]->{'IdentityCode'}
			);
	        scraperwiki::save_sqlite(array('data'), $entry);
	        var_dump($entry);
	}
}
