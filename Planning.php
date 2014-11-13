<?php
class Planning
{
	var $semaines;
	var $annee;
	var $etudiants;
	var $liste;
	var $stat;
	
	function __construct($an)
	{
		$this->etudiants = array("Personne","David","Aicha","Julie","Hubert","Jonnathan");
		$this->stat = array("0" => 0,
							"1" => 0,
							"2" => 0,
							"3" => 0,
							"4" => 0,
							"5" => 0);
		
		$this->annee = intval($an);
		if($this->annee == null)
			$this->annee = date("Y");
		$this->semaines = array();
		
		if(!$this->get())
			$this->init();
		
		$this->liste = $this->getPlanningListe();
	}
	
	function init()
	{
		$mois = 1;
		$an = intval($this->annee);
		$jour = date("w",mktime(0,0,0,$mois,1,$this->annee));
		if($jour > 0)
			$jour = (7 - $jour) + 2;
		$nbJMois = date("t",mktime(0,0,0,$mois,1,$an));
		
		while($an <= $this->annee)
		{
			$this->semaines[date("Ymd",mktime(0,0,0,$mois,$jour,$an))] = 0;
			$jour += 7;
			
			if($jour > $nbJMois)
			{
				$jour %= $nbJMois;
				$nbJMois = date("t",mktime(0,0,0,++$mois,1,$an));
			}
			
			if($mois > 12)
				$an++;
			
		}
	}
	
	function write()
	{
		$obj = array("annee" => $this->annee,
					 "semaines" => $this->semaines,
					 "stat" => $this->stat);
		
		$res = file_put_contents('plannings/'.$this->annee . '.json', json_encode($obj));

		return (!$res)?"erreur":$res;
	}
	
	function get()
	{
		if(file_exists('plannings/'.$this->annee . '.json'))
		{
			$s = file_get_contents('plannings/'.$this->annee . '.json',FILE_USE_INCLUDE_PATH);
			$a = json_decode($s);
			$this->annee = $a->annee;
			$this->semaines = json_decode(json_encode($a->semaines),true);
			$this->stat = json_decode(json_encode($a->stat),true);
			return true;
		}
		
		return false;
	}
	
	function set($date,$eleve)
	{
		$this->semaines[$date] = $eleve;
		$this->stat[$eleve] += 1;
	}
	
	function parseDate($d)
	{
		$a = substr($d,0,4);
		$m = substr($d,4,2);
		$j = substr($d,6);
		
		return "$j/$m/$a";
	}
	
	function getPlanningListe()
	{
		$liste = array();
		$tab = scandir("plannings");
		foreach ($tab as $key => $val)
		{
			$texte = explode(".", $val);
			if($texte[0] != "")
			{
				$liste[$key] = $texte[0];
			}
		}
		
		sort($liste, SORT_REGULAR | SORT_NUMERIC);
		
		return $liste;
	}
	
}

?>