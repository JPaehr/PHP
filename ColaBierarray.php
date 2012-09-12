<!-- getraenke.php -->
<html>
<head>
<title> Getraenke-Automat </title>
<link rel="stylesheet" type="text/css" href="style.css" /> 
</head>
<body>
<h1>Statemachine</h1>
<?PHP
// Warnings unterdruecken
error_reporting (E_ALL ^ E_NOTICE);

define ("za", 0);		    // Zustaende
define ("zb", 1);
define ("zc", 2);
define ("zd", 3);

define ("back05", 0);		// Ausgabe
define ("back1", 1);
define ("back15", 2);
define ("outCola", 3);
define ("outBier", 4);
define ("nx",5);

define ("in05", 0);		    // Eingabe
define ("in1", 1);
define ("selCola", 2);
define ("selBier", 3);
define ("backall", 4);

$str_zustand = array ("za (0Eur)", "zb (0,5Eur)", "zc (1Eur)", "zd (1,5Eur)");
$str_ausgabe = array ("50ctzurueck", "1Eur zurueck", "1,5Eur zurueck","Ausgabe Cola", "Ausgabe Bier", "nichts");
$str_eingabe = array ("Einwurf 50ct", "Einwurf 1€", "Auswahl Cola", "Auswahl Bier", "Geldrueckgabe");

function statemachine ($akt_zustand, $input) { 

	$tzustand = array(	array(zb,zc,za,za,za),
						array(zc,zd,zb,zb,za),
						array(zd,zd,za,zc,za),
						array(zd,zd,zb,za,za));
						
						
	$tausgabe = array(	array(nx,nx,nx,nx,nx),
						array(nx,nx,nx,nx,back05),
						array(nx,back05,outCola,nx,back1),
						array(back05,back1,outCola,outBier,back15));
	$neu_zustand = $tzustand[$akt_zustand][$input];
	$ausgabe = $tausgabe[$akt_zustand][$input];
				
	
	
   return array($neu_zustand, $ausgabe);
}
echo "<table border='1'>";
for($i=0; $i < 4;$i++){
	echo "<tr>";
	for($j = 0; $j <5;$j++){
		$a = statemachine($i, $j);
		
		echo "<td>".$str_zustand[$a[0]]."</td>";

	}
	echo "</tr>";
}

echo "</table>";
echo "<br>";
echo "Ausgabe";
echo "<br>";

echo "<table border='1'>";
for($i=0; $i < 4;$i++){
	echo "<tr>";
	for($j = 0; $j <5;$j++){
		$a = statemachine($i, $j);
		
		echo "<td>".$str_ausgabe[$a[1]]."</td>";

	}
	echo "</tr>";
}

echo "</table>";


// main program

if (!isset ($_POST["zustand"])) {
	$akt_zustand = za;				// init
	$akt_ausgabe = nx;
}
if (isset ($_POST["zustand"])) {
	$a = statemachine ($_POST["zustand"], $_POST["in"]);
	$akt_zustand = $a[0];
	$akt_ausgabe = $a[1];
	print_r ($_POST);
	
}
echo "<h3><p>Control:";
echo "<br>Zustand ->".$str_zustand[$akt_zustand];
echo "<br>Ausgabe ->".$str_ausgabe[$akt_ausgabe];
echo "</p></h3>";
echo "<table border='1' cellspacing='0' class='eintable'><tr>";

foreach ($str_eingabe as $key => $value)  {
	echo "<td>".$value."&nbsp;</td>";   // non breaking space
}

echo "<tr>";
echo "<form action='".$_SERVER[PHP_SELF]."' method='post'>"
	 ."<td><input type='submit' name='in' value='".in05."'></td>"
	 ."<td><input type='submit' name='in' value='".in1."'></td>"
	 ."<td><input type='submit' name='in' value='".selCola."'></td>"	
	 ."<td><input type='submit' name='in' value='".selBier."'></td>"
	 ."<td><input type='submit' name='in' value='".backall."'></td>"	 
	 ."<input type='hidden' name='zustand' value='".$akt_zustand."'></td>"
	 ."</form>";
echo "</tr></table>";	 
?>
</body>
</html>