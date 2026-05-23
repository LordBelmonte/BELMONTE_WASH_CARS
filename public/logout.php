<?php

session_start();

session_destroy();

header(
    'Location: login-cadastro.php'
);

exit;