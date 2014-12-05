<?php
//don't allow other scripts to grab and execute our file
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

///This is the parameter we get from our xml file above
$highlightHomeTeam = $params->get('highlighthometeam');
$posLeague = $params->get('posLeague');
$headlineOption = $params->get('headline');



// get teamkey parameter from component menu item
$menuitemid = JRequest::getInt('Itemid');
if ($menuitemid)
{
	$menu = JFactory::getApplication()->getMenu();
	$menuparams = $menu->getParams( $menuitemid );
}
$teamkey = $menuparams->get('teamkey');
// echo "TEAMKEY: {$teamkey}";

// detailed or original HVW standings
$detailed = true;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$team = modHbStandingsHelper::getTeam($teamkey);
$headline = modHbStandingsHelper::getHeadline($headlineOption, $team);
$standings = modHbStandingsHelper::getStandings($team);
//echo '<p>standings</p><pre>'; print_r($standings); echo '</pre>';
$detailedStandings = modHbStandingsHelper::getDetailedStandings($team);
//echo '<p>rankingSorted</p><pre>'; print_r($detailedStandings); echo '</pre>';


//Returns the path of the layout file
require JModuleHelper::getLayoutPath('mod_hbstandings', $params->get('layout', 'default'));
//TO DO option in backend for layout

//$result = $this->model->getRanking();
//$result = $this->model->getHead2Head('TSV Geislingen', 'SG Tail/Trucht','hbdata_m1_spielplan');
	