
<?php
//No access
defined( '_JEXEC' ) or die;



//Add database instance
$db = JFactory::getDBO();
$jAp = JFactory::getApplication();

// getting further Information of the team
$query = $db->getQuery(true);
$query->select('*');
$query->from($db->quoteName('aaa_mannschaft'));
$query->where($db->quoteName('kuerzel').' = '.$db->quote($kuerzel));
$db->setQuery($query);
$mannschaft = $db->loadObject();
//echo nl2br($query);//die; //see resulting query
//display and convert to HTML when SQL error
if (is_null($posts=$db->loadRowList())) 
{
	$jAp->enqueueMessage(nl2br($db->getErrorMsg()),'error');
	return;
}

$tabelleTable = 'hb_data_'.$mannschaft->kuerzel.'tabelle';

// checking if scheduleDB available
$query = $db->getQuery(true);
$query->select('COUNT(*)');
$query->from('information_schema.tables');
$query->where($db->quoteName('table_name').' = '.$db->quote($tabelleTable));
//echo nl2br($query);//die; //see resulting query
$db->setQuery($query);
$tabelleTableExists = $db->loadResult();
//echo "<pre>"; print_r($tabelletableExists); echo "</pre>";
//display and convert to HTML when SQL error
if (is_null($posts=$db->loadRowList()))
{
	$jAp->enqueueMessage(nl2br($db->getErrorMsg()),'error');
	return;
}

if ($tabelleTableExists)
{
	// getting standings of the team from the DB
	$query = $db->getQuery(true);
	$query->select('*');
	$query->from($db->nameQuote($tabelleTable));
	//echo nl2br($query);//die; //see resulting query
	$db->setQuery($query);
	$rows = $db->loadObjectList();
	//echo "<pre>"; print_r($rows); echo "</pre>";
	//display and convert to HTML when SQL error
	if (is_null($posts=$db->loadRowList()))
	{
		$jAp->enqueueMessage(nl2br($db->getErrorMsg()),'error');
		return;
	}
	
	function markHeimInTabelle($mannschaft, $heim, $class = false)
	{
		if (strcmp(trim($mannschaft), trim($heim)) == 0)
		{
			if ($class == true)
			{
				return " class=\"heim\"";
			}
			return " heim";
		}
		return '';
	}
}