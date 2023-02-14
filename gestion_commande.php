<?php
require_once("init.inc.php");
$contenu = '';

echo "<table border='1' style='border-collapse: collapse' cellpadding='7'>";
echo "<tr><td colspan='5'>Commandes</td></tr>";
echo "<tr><th>Identifiant commande</th><th>Identifiant membre</th><th>Montant</th><th>Date</th></tr>";


$resultat = executeRequete("SELECT * FROM commande");
/*
echo '<tr>';
echo '<th>N° Commande</th>';
echo '<th>Identifiant membre</th>';
echo '<th>Montant</th>';
echo '<th>Date</th>';
echo '</tr>';*/
while($commande = $resultat->fetch_assoc())
{
    echo '<tr>';
    echo '<td>' . $commande['id_commande'] . '</td>';
    echo '<td>' . $commande['id_membre'] . '</td>';
    echo '<td>' . $commande['montant'] . '</td>';
    echo '<td>' . $commande['date_enregistrement'] . '</td>';
    echo '</tr>';
}
echo '</table>';


require_once("haut.inc.php");

require_once ("bas.inc.php");?>