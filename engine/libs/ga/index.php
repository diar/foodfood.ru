<HTML>
<HEAD>
<TITLE>Google Analytics</TITLE>
</HEAD>

<BODY>
<br /><br />
<BR>
<script type="text/javascript" src="swfobject.js"></script>


	<div id="visitors" align="center" style="padding-bottom:80px">
		<strong>Для просмотра сожержимого, установите последнюю версию Adobe Flash Player</strong>
	</div>


<script type="text/javascript">
	// <![CDATA[
	var so = new SWFObject("amline.swf", "amline_chart", "630", "500", "8", "#FFFFFF");
	so.addVariable("path", "./amline/");
	so.addVariable("settings_file", escape("visitors_settings.xml?<?php echo mktime();?>"));
	so.addVariable("data_file", escape("visitors.csv?<?php echo mktime();?>"));
	so.addVariable("preloader_color", "#BBBBBB");
	so.write("visitors");
	// ]]>
</script>



	<div id="visitors_3" align="center" style="padding-bottom:80px">
		<strong>Для просмотра сожержимого, установите последнюю версию Adobe Flash Player</strong>
	</div>


<script type="text/javascript">
	// <![CDATA[
	var so = new SWFObject("amline.swf", "amline_chart", "600", "400", "8", "#FFFFFF");
	so.addVariable("path", "./amline/");
	so.addVariable("settings_file", escape("visitors_3_settings.xml?<?php echo mktime();?>"));
	so.addVariable("data_file", escape("visitors_3.csv?<?php echo mktime();?>"));
	so.addVariable("preloader_color", "#BBBBBB");
	so.write("visitors_3");
	// ]]>
</script>



	<div id="country" align="center" style="padding-bottom:80px">
		<strong>Для просмотра сожержимого, установите последнюю версию Adobe Flash Player</strong>
	</div>

<script type="text/javascript">
	// <![CDATA[
	var so = new SWFObject("ampie.swf", "ampie_chart", "550", "350", "8", "#FFFFFF");
	so.addVariable("path", "./ampie/");
	so.addVariable("settings_file", escape("country_settings.xml?<?php echo mktime();?>"));
	so.addVariable("data_file", escape("country.csv?<?php echo mktime();?>"));
	so.addVariable("preloader_color", "#BBBBBB");
	so.write("country");
	// ]]>

</script>


	<div id="city" align="center" style="padding-bottom:80px">
		<strong>Для просмотра сожержимого, установите последнюю версию Adobe Flash Player</strong>
	</div>

<script type="text/javascript">
	// <![CDATA[
	var so = new SWFObject("ampie.swf", "ampie_chart", "550", "350", "8", "#FFFFFF");
	so.addVariable("path", "./ampie/");
	so.addVariable("settings_file", escape("country_settings.xml?<?php echo mktime();?>"));
	so.addVariable("data_file", escape("city.csv?<?php echo mktime();?>"));
	so.addVariable("preloader_color", "#BBBBBB");
	so.write("city");
	// ]]>

</script>



<br /><br /><br /><br /><br />
</BODY>
</HTML>

