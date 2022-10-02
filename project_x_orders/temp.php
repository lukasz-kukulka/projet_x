<?php

function redirectedToRaport() {
    ?>
        <script type="text/javascript">
            window.location=/report-generate/index.php;
        </script>
    <?php
}

    echo '<input type="submit" value="Go to my link location" onclick="redirectedToRaport()" />';   


?>