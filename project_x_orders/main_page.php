<?php

if ( ! is_user_logged_in() ) {
    ?>
        <script type="text/javascript">
            location.href="wp-login.php";
        </script>
    <?php
} else {
    ?>
        <script type="text/javascript">
            location.href="panel-trenera.php";
        </script>
    <?php
}

?>
