<?php
//No access
defined( '_JEXEC' ) or die;

class modHbStandingsHelper
{
	public static function getTeam ($teamkey)
	{
		$db = JFactory::getDBO();
		// getting further Information of the team
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('hb_mannschaft'));
		$query->where($db->quoteName('kuerzel').' = '.$db->quote($teamkey));
		$db->setQuery($query);
		$team = $db->loadObject();
		//echo nl2br($query);//die; //see resulting query
		//display and convert to HTML when SQL error
		if (is_null($posts=$db->loadRowList())) 
		{
			$jAp->enqueueMessage(nl2br($db->getErrorMsg()),'error');
			return;
		}
		if (empty($team)){
			$team = new stdClass();
			$team->mannschaft = 'Mannschaft';
			$team->liga = 'Liga';
			$team->ligaKuerzel = '';
			$team->kuerzel = '';
			$team->name = '';
			$team->nameKurz = '';
		}
		return $team;
	}
	
	public static function getHeadline($option, $team)
	{
		switch ($option)
		{
			case 'title':
				return 'Tabelle';
			case 'not':
				return null;
			case 'title':
			default:
				return 'Tabelle - '.$team->mannschaft;
		}
	}
	
	private static function getSeason()
    {
		$year = strftime('%Y');
		if (strftime('%m') < 8) {
			$year = $year-1;
		}
		
		$season = $year."-".($year+1);
		//echo __FILE__.'('.__LINE__.'):<pre>';print_r($season);echo'</pre>';
		return $season;
    }
	
	public static function getStandings($team)
	{
		$db = JFactory::getDBO();
		// getting standings of the team from the DB
		$query = $db->getQuery(true);
		$query->select('*, '.
			'IF('.$db->qn('mannschaft').'='.$db->q($team->name).',1,0) AS heimVerein');
		$query->from($db->qn('hb_tabelle'));
		$query->where($db->qn('kuerzel').' = '.$db->q($team->kuerzel));
		$query->where('hb_tabelle.'.$db->qn('saison').' = '.$db->q(self::getSeason()));
		$query->order($db->qn('platz'));
		//echo nl2br($query);//die; //see resulting query
		$db->setQuery($query);
		$standings = $db->loadObjectList();
		//echo "<pre>"; print_r($standings); echo "</pre>";
		//display and convert to HTML when SQL error
		if (is_null($posts=$db->loadRowList()))
		{
			$jAp->enqueueMessage(nl2br($db->getErrorMsg()),'error');
			return;
		}
		$standings = self::addBackground($standings);
		return $standings;
	}
	
	protected static function addBackground ($standings)
	{
		$background = false;
		foreach ($standings as $row)
		{
			// switch color of background
			if (!empty($row->platz)) $background = !$background;
			// check value of background
			switch ($background) {
				case true: $row->background = 'odd'; break;
				case false: $row->background = 'even'; break;
			}
		}
		return $standings;
	}

	public static function getDetailedStandings($team)
	{
		$db = JFactory::getDBO();
		// getting standings of the team from the DB
		$query = $db->getQuery(true);
		$query->select('*, '.
			'IF('.$db->qn('mannschaft').'='.$db->q($team->name).',1,0) AS heimVerein');
		$query->from($db->qn('hb_tabelle_details'));
		$query->where($db->qn('kuerzel').' = '.$db->q($team->kuerzel));
		$query->where('hb_tabelle_details.'.$db->qn('saison').' = '.$db->q(self::getSeason()));
		$query->order($db->qn('platz'));
		//echo nl2br($query);//die; //see resulting query
		$db->setQuery($query);
		$standings = $db->loadObjectList();
		//echo "<pre>"; print_r($standings); echo "</pre>";
		//display and convert to HTML when SQL error
		if (is_null($posts=$db->loadRowList()))
		{
			$jAp->enqueueMessage(nl2br($db->getErrorMsg()),'error');
			return;
		}
		$standings = self::addBackground($standings);
		return $standings;
	}

}


