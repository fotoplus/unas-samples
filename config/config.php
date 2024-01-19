<?php

// PHP hibaüzenetek bekapcsolása
error_reporting(E_ALL);
ini_set("display_errors", 1); 

// A mysqli hibakijelzése
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);