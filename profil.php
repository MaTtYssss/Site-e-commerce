<?php
require_once("init.inc.php");

$contenu = '';
if(!internauteEstConnecte()) header("location:connexion.php");
// debug($_SESSION);
$contenu .= '<p class="centre">Bonjour <strong>' . $_SESSION['membre']['prenom'] . '</strong></p>';
$contenu .= '<div class="cadre"><h2> Voici vos informations </h2>';
$contenu .= '<p> votre email est: ' . $_SESSION['membre']['email'] . '<br>';


include("haut.inc.php");
echo $contenu;

echo "<table border='1' style='border-collapse: collapse' cellpadding='7'>";
echo "<tr><td colspan='5'>Vos commandes</td></tr>";
echo "<tr><th>Numéro de suivi</th><th>Montant</th><th>Date</th></tr>";

$id_membre = $_SESSION['membre']['id_membre'];

$resultat = executeRequete("SELECT * FROM commande WHERE id_membre = $id_membre" );
if ($resultat->num_rows > 0) {
    for ($i = 0; $i < $resultat->num_rows; $i++) {
        $ligne = $resultat->fetch_assoc();
        echo '<tr>';
        echo '<td>' . $ligne['id_commande'] . '</td>';
        echo '<td>' . $ligne['montant'] . '</td>';
        echo '<td>' . $ligne['date_enregistrement'] . '</td>';
        echo '</tr>';
    }
} else {
    echo "Aucune commande trouvée pour ce client.";
}

echo "</table><br>";
include("bas.inc.php");
?>