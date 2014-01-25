<?php
//don't allow other scripts to grab and execute our file
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

///This is the parameter we get from our xml file above
$highlightHomeTeam = $params->get('highlighthometeam');
$posLeague = $params->get('posLeague');
$headline = $params->get('headline');



// get teamkey parameter from component menu item
$menuitemid = JRequest::getInt('Itemid');
if ($menuitemid)
{
	$menu = JSite::getMenu();
	$menuparams = $menu->getParams( $menuitemid );
}
$kuerzel = $menuparams->get('teamkey');
// echo "TEAMKEY: {$teamkey}";


// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

//Returns the path of the layout file
require JModuleHelper::getLayoutPath('mod_hbstandings', $params->get('layout', 'default'));

