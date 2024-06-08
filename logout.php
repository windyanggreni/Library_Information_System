<?php
session_start();
//menghapus session
session_destroy();
unset($_SESSION);

header("Location: index.php");