<?php
include 'Planning.php';
$annee_ = $_POST ["annee"];

if($annee_ != null && $annee_ != ""){
	$p = new Planning ( $_POST ["annee"] );
	
	if (! isset ( $_POST ["new"] )) {
		$p->stat = array("0" => 0,
				"1" => 0,
				"2" => 0,
				"3" => 0,
				"4" => 0,
				"5" => 0);
	
		foreach ( $p->semaines as $date => $value ) {
			$val = $_POST ["jour" . $date];
	
			if (! isset ( $val ))
				$val = 0;
	
			$p->set ( "" . $date, $val );
		}
	
		arsort($p->stat);
	}
	
	$p->write ();
	header ( 'Location: index.php?annee=' . $p->annee );
}
else 
	header ( 'Location: index.php');

?>