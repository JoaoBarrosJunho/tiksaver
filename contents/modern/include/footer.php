<?php

use App\classes\cookie_alert;



?>
<script src="<?= THEME_URI?>/assets/js/app.js"></script>
<script src="<?= THEME_URI?>/assets/js/init-alpine.js"></script>
<script src="<?= THEME_URI?>/assets/js/focus-trap.js"></script>

<?= getOption('footer')?>
<?=cookie_alert::check()?>
</body>
</html>