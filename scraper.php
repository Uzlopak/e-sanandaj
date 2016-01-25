
<?php
require 'scraperwiki.php';
$endtime = time() + (60 * 60) * 23; //23h 
for ($page = 0; $page <= 2; $page++) {
	if ($endtime <= time())
	{
		exit;
	}
	$i = 1;
	$delay = 250000;
	  print $page;
	  while (!validateEntry($id))
	  {
	    print ".";
	  	$delay = $delay + $i * 250000;
	  	//limit to 5 secs
	  	if ($delay > 5000000) {
	  		$delay = 5000000;
	  	}
	  	if ($i % 20 == 0)
	  	{
	  		$delay = 60000000;
	  	}
	  	if ($i == 61)
	  	{
	  		exit;
	  	}
	    usleep($delay);
	    ripByPage($page);
	    $i++;
	  print "!";
  }
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
	                          ));
        }
}
