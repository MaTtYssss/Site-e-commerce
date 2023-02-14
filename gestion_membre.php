<?php
require_once("init.inc.php");
$contenu = '';

echo "<table border='1' style='border-collapse: collapse' cellpadding='7'>";
echo "<tr><td colspan='5'>Membres</td></tr>";
echo "<tr><th>Identifiant commande</th><th>Identifiant membre</th><th>Montant</th><th>Date</th></tr>";


$resultat = executeRequete("SELECT * FROM membre");


while($commande = $resultat->fetch_assoc())
{
    echo '<tr>';
    echo '<td>' . $commande['id_membre'] . '</td>';
    echo '<td>' . $commande['email'] . '</td>';
    echo '<td>' . $commande['nom'] . '</td>';
    echo '<td>' . $commande['prenom'] . '</td>';
    
}
echo '</table>';


require_once("haut.inc.php");

require_once ("bas.inc.php");?>