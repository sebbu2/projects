<html>
<head>
<title><?php echo $appname; ?> par sebbu</title>
<style>
.line {
	margin:0px;
	margin-left:-20px;
}
.line #line_first {
	display:inline;
	margin-left:-20px;
}
.line #line_last {
	margin-right: 5px;
}
.line UL {
	height: 20px;
	width: 100px;
	margin:0px;
	padding:0px;
}
.line LI {
	display:list-item;
	height: 20px;
	margin-left:10px;
	margin-right:10px;
	float:left;
}
.line BR {
	clear:all;
}
</style>
</head>
<!--base href="http://localhost/projects/"/-->
<body>

<?php
if(strcasecmp($appname,'projet')!=0&&strcasecmp($appname,'projets')!=0&&strlen($appurl)>0) {
	echo '<h1><a href="'.$appurl.'">'.$appname.'</a></h1>'."\r\n";
}
else {
	echo '<h1>'.$appname.'</h1>'."\r\n";
}
?>
