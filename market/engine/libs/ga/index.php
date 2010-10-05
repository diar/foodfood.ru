<html>
    <body>
        <script type="text/javascript" src="swfobject.js"></script>

        <div id="visitors_3" align="center" style="padding-bottom:30px">
            <strong>Требуется Adobe Flash Player</strong>
        </div>


        <script type="text/javascript">
            // <![CDATA[
            var so = new SWFObject("amline.swf", "amline_chart", "800", "300", "8", "#FFFFFF");
            so.addVariable("path", "./amline/");
            so.addVariable("settings_file", escape("visitors_3_settings.xml?<?php echo mktime(); ?>"));
            so.addVariable("data_file", escape("visitors_3.csv?<?php echo mktime(); ?>"));
            so.addVariable("preloader_color", "#BBBBBB");
            so.write("visitors_3");
            // ]]>
        </script>



        <div id="city" align="center" style="padding-bottom:30px; float:left;">
            <strong>Требуется Adobe Flash Player</strong>
        </div>

        <script type="text/javascript">
            // <![CDATA[
            var so = new SWFObject("ampie.swf", "ampie_chart", "800", "300", "8", "#FFFFFF");
            so.addVariable("path", "./ampie/");
            so.addVariable("settings_file", escape("country_settings.xml?<?php echo mktime(); ?>"));
            so.addVariable("data_file", escape("city.csv?<?php echo mktime(); ?>"));
            so.addVariable("preloader_color", "#BBBBBB");
            so.write("city");
            // ]]>

        </script>

    </body>
</html>

