<?php
require('config.inc.php');
if(array_key_exists('appname',$_REQUEST)) $appname=$_REQUEST['appname']; else $appname='';
if(array_key_exists('appurl',$_REQUEST)) $appurl=$_REQUEST['appurl']; else $appurl='';
if($appname=='') {
	$appname='Projets';
	$appurl='http://sebbu.naedev.org/projects/';
	include('header.inc.php');
	echo "\r\n";
	echo '<h2>Liste :</h2>'."\r\n";
	echo "\r\n";
	echo '<ul>'."\r\n";
	$files=glob('*.txt');
	$num=0;
	foreach($files as $file) {
		$projet=substr($file,0,strrpos($file,'.'));
		if(strpos($projet,'__')!==false) continue;
		echo '<li><a href="projet.php?appname='.$projet.'">'.$projet.'</a></li>'."\r\n";
		$num++;
	}
	if($num==0) {
		echo '<li>aucun projet pour l&#039;instant</li>'."\r\n";
	}
	echo '</ul>'."\r\n";
	include('footer.inc.php');
	die();
}
if(file_exists($appname.'.txt')) {
	$fp=fopen($appname.'.txt','r');
	while(!feof($fp)) {
		$ligne=trim(fgets($fp));
		if(strlen($ligne)==0) continue;
		if($ligne[0]!='|') continue;
		$ligne=explode('|',$ligne);
		foreach($ligne as $k=>$v) $ligne[$k]=trim($v);
		//var_dump($ligne);
		if($ligne[2]==1) {
			${$ligne[1]}=$ligne[3];
		}
		else ${$ligne[1]}='';
	}
	fclose($fp);
}
//$appurl='http://sebbu.naedev.org/projects/oracle-sql/';
include('header.inc.php');
?>
<h2>Status</h2>

<?php
if(file_exists($appname.'.txt')) {
	$fp=fopen($appname.'.txt','r');
	echo '<table border="1">'."\r\n";
	echo '	<tr>'."\r\n";
	echo '		<th>Fonctionnalité</th>'."\r\n";
	echo '		<th>Status</th>'."\r\n";
	echo '		<th>Version</th>'."\r\n";
	echo '	</tr>'."\r\n";
	while(!feof($fp)) {
		$ligne=trim(fgets($fp));
		if(strlen($ligne)==0) continue;
		if($ligne[0]=='@') continue;
		if($ligne[0]=='|') continue;
		$ligne=explode('#',$ligne);
		foreach($ligne as $k=>$v) $ligne[$k]=trim($v);
		echo '	<tr>'."\r\n";
		switch($ligne[1]) {
			case "en cours":
			case "à finir":
			case "à compléter":
			case "a completer":
			case "à continuer":
			case "a continuer":
			case "commencé":
			case "commence":
				echo '	<td>'.$ligne[0].'</td>'."\r\n";
				echo '	<td style="background-color: greenyellow;">'.$ligne[1].'</td>'."\r\n";
				break;
			case "fait":
			case "fini":
			case "fini/abandonné":
			case "fini/abandonne":
				echo '	<td>'.$ligne[0].'</td>'."\r\n";
				echo '	<td style="background-color: green;color: white;">'.$ligne[1].'</td>'."\r\n";
				break;
			case "à voir":
			case "suggestion":
				echo '	<td>'.$ligne[0].'</td>'."\r\n";
				echo '	<td style="background-color: yellow;">'.$ligne[1].'</td>'."\r\n";
				break;
			case "d'origine":
			case "origine":
			case "original":
				echo '	<td>'.$ligne[0].'</td>'."\r\n";
				echo '	<td style="background-color: cyan;">'.$ligne[1].'</td>'."\r\n";
				break;
			case "erreur":
			case "érreur":
			case "bug":
			case "à refaire":
			case "bloqué":
			case "bloque":
				echo '	<td>'.$ligne[0].'</td>'."\r\n";
				echo '	<td style="background-color: red;">'.$ligne[1].'</td>'."\r\n";
				break;
			case "à faire":
			case "pas fait":
				echo '	<td>'.$ligne[0].'</td>'."\r\n";
				echo '	<td style="background-color: orange;">'.$ligne[1].'</td>'."\r\n";
				break;
			case "abandonné":
			case "abandonne":
				echo '	<td>'.$ligne[0].'</td>'."\r\n";
				echo '	<td style="background-color: black;color:white;">'.$ligne[1].'</td>'."\r\n";
				break;
			case "N/A":
				echo '	<td><u><i>'.$ligne[0].'</i></u></td>'."\r\n";
				echo '	<td style="background-color: silver;"><b><i>'.$ligne[1].'</i></b></td>'."\r\n";
				break;
			default:
				echo '	<td>'.$ligne[0].'</td>'."\r\n";
				echo '	<td>'.((strlen($ligne[1])>0)?$ligne[1]:'&nbsp;').'</td>'."\r\n";
				break;
		}
		if(array_key_exists(2,$ligne)) {
			echo '	<td>'.((strlen($ligne[2])>0)?$ligne[2]:'&nbsp;').'</td>'."\r\n";
		}
		else {
			echo '	<td>&nbsp;</td>'."\r\n";
		}
		echo '	</tr>'."\r\n";
	}
	echo '</table>'."\r\n";
	//fclose($fp);
	//$fp=fopen($appname.'.txt','r');
	rewind($fp);
	echo '<br/>Liens utiles :<br/>'."\r\n";
	while(!feof($fp)) {
		$ligne=trim(fgets($fp));
		if(strlen($ligne)==0) continue;
		if($ligne[0]=='#') continue;
		if($ligne[0]=='|') continue;
		if($ligne[0]!='@') continue;
		$ligne=explode('@',$ligne);
		foreach($ligne as $k=>$v) $ligne[$k]=trim($v);
		//var_dump($ligne);
		if(strlen($ligne[2])>0) echo '<a href="'.$ligne[2].'">'.$ligne[1].'</a><br/>'."\r\n";
		//else echo '<a href="#">'.$ligne[1].'</a><br/>'."\r\n";
		//else echo '<a href="javascript:return null;">'.$ligne[1].'</a><br/>'."\r\n";
		//else echo '<span style="text-decoration:underline;color:blue;">'.$ligne[1].'</span><br/>'."\r\n";
		else echo '<span style="color:blue;">'.$ligne[1].'</span><br/>'."\r\n";
	}
}
else {
	echo 'érreur : fichier inexistant'."\r\n";
}
include('footer.inc.php');
?>