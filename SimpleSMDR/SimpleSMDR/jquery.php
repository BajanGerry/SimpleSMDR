<?php
include("config.php");
?>
<html>
<script src='https://code.jquery.com/jquery-3.3.1.js'></script>
<script type='text/javascript'>
    $(document).ready(function () {
        $("p").click(function () {
            $(this).hide();
        });
    });
</script>
<p>If you click on me, I will disappear.</p>
<p>Click me away!</p>
<p>Click me too!</p>)
</html>