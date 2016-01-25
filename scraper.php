<?php

require 'scraperwiki.php';
$endtime = time() + (60 * 60) * 23; //23h 
	for ($page = 0; $page <= 2; $page++) {
	
	print $page;
	ripByPage($page);
	print "!";
	}
	
function ripByPage($page){
	$pathToDetails = 'http://aramestan.e-sanandaj.ir/BurialRequest/DeadSearch?keyword=&firstName=&lastName=&fatherName=&partNo=0&rowNo=&graveNo=&deathDateFrom=&deathDateTo=&bornDateFrom=&bornDateTo=&page=' . $page;
	$output = scraperwiki::scrape($pathToDetails);
	
	$resultingJsonObject = json_decode($output);
        foreach ($resultingJsonObject->{'result'} as $record) 
        {
	        scraperwiki::save_sqlite(array('data'), 
			array(
				'id'      => $record->Id,
				'fullname' => $record->DeadFullName,
				'fathername' => $record->DeadFatherName, 
				'birthdate' => $record->BornDate, 
				'deathdate' => $record->DeathDate,
				'partNo' => $record->PartNo,
				'rowNo' => $record->RowNo,
				'graveNo' => $record->GraveNo,
				'gender'  => $record->Gender,
				'identityCode' => $record->IdentityCode,
				'photoTag' => $record->PhotoTag
			)
		);
	}
}
