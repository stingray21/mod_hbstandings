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
	
	public static function getStandings($team)
	{
		$db = JFactory::getDBO();
		// getting standings of the team from the DB
		$query = $db->getQuery(true);
		$query->select('*, '.
			'IF('.$db->qn('verein').'='.$db->q($team->name).',1,0) AS heimVerein');
		$query->from($db->qn('hb_tabelle'));
		$query->where($db->qn('kuerzel').' = '.$db->q($team->kuerzel));
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

	

	public static function getRanking($team)
	{
		$db = JFactory::getDBO();
		$query = "SELECT 
			mannschaft,

			COUNT(IF(s.hTore IS NOT NULL, s.hTore, 0)) spiele, 
			SUM(IF(w='H', 1, 0)) spieleHeim, 
			SUM(IF(w='A', 1, 0)) spieleGast, 

			SUM( 
			CASE 
			WHEN s.hTore > s.gTore THEN 2 
			WHEN s.hTore = s.gTore THEN 1 
			ELSE 0 
			END) punkte, 

			SUM( 
			CASE 
			WHEN w = 'H' AND s.hTore > s.gTore THEN 2 
			WHEN w = 'H' AND s.hTore = s.gTore THEN 1 
			ELSE 0 
			END) punkteHeim, 

			SUM( 
			CASE 
			WHEN w = 'A' AND s.hTore > s.gTore THEN 2 
			WHEN w = 'A' AND s.hTore = s.gTore THEN 1 
			ELSE 0 
			END) punkteGast, 

			SUM( 
			CASE 
			WHEN s.hTore < s.gTore THEN 2 
			WHEN s.hTore = s.gTore THEN 1 
			ELSE 0 
			END) nPunkte, 

			SUM( 
			CASE 
			WHEN w = 'H' AND s.hTore < s.gTore THEN 2 
			WHEN w = 'H' AND s.hTore = s.gTore THEN 1 
			ELSE 0  
			END) nPunkteHeim, 

			SUM( 
			CASE 
			WHEN w = 'A' AND s.hTore < s.gTore THEN 2 
			WHEN w = 'A' AND s.hTore = s.gTore THEN 1 
			ELSE 0  
			END) nPunkteGast,

			SUM(IF(s.hTore > s.gTore, 1, 0)) s, 
			SUM(IF(w = 'H' AND s.hTore > s.gTore, 1, 0)) sHeim, 
			SUM(IF(w = 'A' AND s.hTore > s.gTore, 1, 0)) sGast, 


			SUM(IF(s.hTore = s.gTore, 1, 0)) u, 
			SUM(IF(w = 'H' AND s.hTore = s.gTore, 1, 0)) uHeim, 
			SUM(IF(w = 'A' AND s.hTore = s.gTore, 1, 0)) uGast, 


			SUM(IF(s.hTore < s.gTore, 1, 0)) n, 
			SUM(IF(w = 'H' AND s.hTore < s.gTore, 1, 0)) nHeim, 
			SUM(IF(w = 'A' AND s.hTore < s.gTore, 1, 0)) nGast, 


			SUM(IF(s.hTore IS NOT NULL, s.hTore, 0)) AS tore, 
			SUM(IF(w = 'H', s.hTore, 0)) AS toreHeim, 
			SUM(IF(w = 'A', s.hTore, 0)) AS toreGast, 

			SUM(IF(s.hTore IS NOT NULL, s.gTore, 0)) AS gegenTore, 
			SUM(IF(w = 'H', s.gTore, 0)) AS gegenToreHeim, 
			SUM(IF(w = 'A', s.gTore, 0)) AS gegenToreGast,	

			SUM(IF(s.hTore IS NOT NULL, s.hTore-s.gTore, 0)) AS diff,
			SUM(IF(w = 'H', s.hTore-s.gTore, 0)) AS diffHeim,
			SUM(IF(w = 'A', s.hTore-s.gTore, 0)) AS diffGast

			FROM ( 
				SELECT heim as mannschaft, kuerzel 
				FROM hb_spiel
				WHERE kuerzel = ".$db->q($team->kuerzel)."
				GROUP BY mannschaft
				) AS m
			LEFT JOIN
			(
				SELECT 
				'H' w, 
				s1.datumZeit datumZeit,
				s1.heim mannschaft, 
				s1.gast gegner, 
				s1.toreHeim hTore, 
				s1.toreGast gTore
				FROM hb_spiel s1 
				WHERE s1.toreHeim IS NOT NULL && kuerzel = ".$db->q($team->kuerzel)."

				UNION 

				SELECT 
				'A' w,
				s2.datumZeit datumZeit,
				s2.gast mannschaft, 
				s2.heim gegner, 
				s2.toreGast hTore, 
				s2.toreHeim gTore 
				FROM hb_spiel s2 
				WHERE s2.toreHeim IS NOT NULL && kuerzel = ".$db->q($team->kuerzel)."
			) AS s USING (mannschaft)

			GROUP BY mannschaft 
			ORDER BY punkte DESC, s DESC, diff DESC";
		//echo "<a>ModelHB->query: </a><pre>"; echo $query; echo "</pre>";
		$db->setQuery($query);
		$result = $db->loadObjectList();
		//echo '<pre>';print_r($result);echo'</pre>';
		return $result;
	}
	
	public static function test($ranking, $teamkey)
	{
		self::getDirectComparison($ranking[4], $ranking[6], $teamkey);
	}
	
	public static function sortRanking($ranking, $teamkey)
	{
		$standings = array();
		foreach ($ranking as $team)
		{
			$standings = self::insertInStandings ($standings, $team);
		}
		//echo '<pre>';print_r($standings);echo'</pre>';
		return $standings;
	}
	
	protected static function insertInStandings ($standings, $team)
	{
		$pos = 0;
		$rank = 1;
		$inserted = false;
		$addRank = false;
		
		foreach ($standings as $key => $row)
		{				
			if (!$inserted) {
				// if more 'punkte' than current element, insert and move current
				if ($team->punkte > $row->punkte) {
					$pos = $key;
					$inserted = true;
					$addRank = true;
				}
				// if 'punkte' equal than current element, call compare function
				elseif ($team->punkte == $row->punkte) {
					//self::compareTiedTeams ($team, $row, $key, $teamkey);
					$pos = $key;
					$inserted = true;
				}
				else {
					$pos++;
					$rank++;
				}
			}
			if ($rank < $row->rank || $addRank) {
				$row->rank++;
			}
			
		}
		$team->rank = $rank;
		//echo '<pre>';print_r($pos);echo'</pre>';
		array_splice( $standings, $pos, 0, array($team) );
		return $standings;
	}

	protected static function compareTiedTeams ($team, $row, $teamkey) 
	{
		//echo '<pre>';print_r($team);echo'</pre>';
		//echo '<pre>';print_r($row);echo'</pre>';
		// negative points
		if ($team->nPunkte < $row->nPunkte) {
			$ret->rank = $row->rank;
			$ret->addRank = 1;
			$ret->pos = $key;			
			return $ret; // better
		}
		elseif ($team->nPunkte == $row->nPunkte) {
			$directComparison = self::getDirectComparison($team, $row, $teamkey);
			return 0; // equal
		}
		else {
			return -1; //worse
		}
	}
	
	protected static function getDirectComparison($team, $opponent, $teamkey)
	{
		$db = JFactory::getDBO();
		$query = "SELECT 
			mannschaft, gegner, 
			SUM(tore - gtore) as diff, 
			SUM(IF(w = 'A', tore, 0)) - SUM(IF(w = 'H', gtore, 0)) AS ausTorDiff
			FROM 
			(SELECT 
			'H' w, 
			DATE(s1.datumZeit) datum,
			s1.heim mannschaft, 
			s1.gast gegner, 
			s1.toreHeim tore, 
			s1.toreGast gtore
			FROM hb_spiel s1 
			WHERE heim=".$db->q($team->mannschaft)."
			AND gast=".$db->q($opponent->mannschaft)."
			AND kuerzel=".$db->q($teamkey)." 

			UNION 

			SELECT 
			'A' w,
			DATE(s2.datumZeit) datum,
			s2.gast mannschaft, 
			s2.heim gegner, 
			s2.toreGast tore, 
			s2.toreHeim gTore 
			FROM hb_spiel s2 
			WHERE gast=".$db->q($team->mannschaft)."
			AND heim=".$db->q($opponent->mannschaft)."
			AND kuerzel=".$db->q($teamkey)." 
			) AS s 

			GROUP BY mannschaft";
		//echo "<a>ModelHB->query: </a><pre>"; echo $query; echo "</pre>";
		$db->setQuery($query);
		$result = $db->loadObject();
		echo '<pre>';print_r($result);echo'</pre>';
		return $result;
	}

}


