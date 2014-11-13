<?php 
include 'Planning.php';
$p = new Planning($_GET["annee"]);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="css/style.css" rel="stylesheet">
<script>
function changeColor(id){
	var elt = document.getElementById(id);
	elt.setAttribute("class","style" + elt.value);
}

function verifAnnee(){
	var elt = document.getElementById(id);
	if(isNaN(elt.value) || Number(elt.value) > 2050 || Number(elt.value) < 2000)
		alert("ceci n'est pas un nombre");
	return false;
}
</script>
<title>PLANNING</title>
</head>
    <body>
    <div class="main">
    <h1>Planning de corv&eacute;es de <?php echo $p->annee;?></h1>
    <form action="index.php" <?php echo (count($p->liste) < 2)?"style='display:none;'":'';?> method="GET" >
    Ann&eacute;e : 
    <select name="annee">
    <?php 
	    foreach ($p->liste as $opt => $value)
	    {
	    	$selected = "";
	    	if ($value == $p->annee)
	    	{
	    		$selected = "selected";
	    	}
	    	print("<option value='" . $value . "'" .$selected. ">$value</option>\n");
	    }
    ?>
    </select>
    <input type="submit" value="voir le planning">
    </form>
    <div class="space"> </div>
    <div id="planning">
    <form action="save.php" method="POST">
    <input type="hidden" value="<?php echo $p->annee?>" name="annee">
    <table>
    <tr>
    <?php 
    $count = 0;
    foreach ($p->semaines as $key => $val)
    {
    	if($count%4 == 0)
    		print("</tr><tr>");
    	print("<td>" . $p->parseDate($key) . "\n");
    	print("<select name='jour$key' id='jour$key' class='style$val' onchange='changeColor(this.id);'>\n");
    	foreach ($p->etudiants as $opt => $value)
    	{
    		$selected = "";
    		if ($opt == $val)
			{
				$selected = "selected";
    		}
    		print("<option value='" . $opt . "'" .$selected. ">$value</option>\n");
    	}
    	print("</select>");
    	$count++;
    }
    ?>
    </tr>
    </table>
    <div class="space">
    <input type="submit" value="valider le planning">
    </div>
    </form>
    </div>
    <div id="stats">
    <h2>Statistiques</h2>
    <ol>
    <?php 
    arsort($p->stat);
    foreach ($p->stat as $key => $val)
	{
		if($key != '0')
			print("<li class='style$key'>".$p->etudiants[intval($key)] .": $val</li>\n");
    }
    ?>
    </ol>
    </div>
    <div class='inline'>
    <form action="save.php" method="POST" id="nouveau" >
    <input type="hidden" value="1" name="new" />
    Ann&eacute;e : 
   	<input type="text" name="annee" id="annee">
    <button onclick="verifAnnee();">Ajouter un planning</button>
    </form>
    </div>
    </div>
    </body>
</html>