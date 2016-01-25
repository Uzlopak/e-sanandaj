<?php

require 'scraperwiki.php';
$pagecount = 2634;

$endtime = time() + (60 * 60) * 23; //23h 
	for ($page = 2633; $page <= $pagecount; $page++) {
	
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
				'fullname' => strVal($resultingJsonObject->{'result'}[$id]->{'DeadFullName'}),
				'fathername' => strVal($resultingJsonObject->{'result'}[$id]->{'DeadFatherName'}),
				'birthdate' => strVal($resultingJsonObject->{'result'}[$id]->{'BornDate'}),
				'deathdate' => strVal($resultingJsonObject->{'result'}[$id]->{'DeathDate'}),
				'partno' => strVal($resultingJsonObject->{'result'}[$id]->{'PartNo'}),
				'rowno' => strVal($resultingJsonObject->{'result'}[$id]->{'RowNo'}),
				'graveno' => strVal($resultingJsonObject->{'result'}[$id]->{'GraveNo'}),
				'gender'  => strVal($resultingJsonObject->{'result'}[$id]->{'Gender'}),
				'identitycode' => strVal($resultingJsonObject->{'result'}[$id]->{'IdentityCode'})
			);
	        scraperwiki::save_sqlite(array('data'), $entry);
	        $pagecount =  $resultingJsonObject->{'PageNumber'};
	}
}
