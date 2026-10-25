<?php
// Archivo: test_hash.php
$password = 'ClinicaVS123';
$hash_real = password_hash($password, PASSWORD_DEFAULT);

echo "<h1>Hash Real para ClinicaVS123:</h1>";
echo "<h2 style='background:yellow; padding:10px;'>" . $hash_real . "</h2>";
echo "<p>Copia ese texto amarillo y pégalo en el UPDATE de PostgreSQL.</p>";
// Hash Real para ClinicaVS123:
//$2y$10$jNEFCOm1XALb.wWjBrtYmu4DpBzSEVjFAC9OmwqSakemC0Oy8VO9m

//Copia ese texto amarillo y pégalo en el UPDATE de PostgreSQL.
?>

