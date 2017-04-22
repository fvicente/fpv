<?
if ($_GET['type']=="v") {
    echo "
    <HTML><BODY>
	<CENTER>
	<div id='container'><a href='http://www.macromedia.com/go/getflashplayer'>Get the Flash Player</a> to see this player.</div>
	<script type='text/javascript' src='swfobject.js'></script>
	<script type='text/javascript'>
	    var s1 = new SWFObject('mediaplayer.swf','mediaplayer','640','480','8');
	    s1.addParam('allowfullscreen','true');
	    s1.addVariable('width','640');
	    s1.addVariable('height','480');
	    s1.addVariable('file','" . $_GET['file'] . "');
	    s1.write('container');
	</script>
	</CENTER>
    </BODY></HTML>
    ";
} else {
    echo "<HTML><META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . $_GET['file'] . "'></HTML>";
}

?>
