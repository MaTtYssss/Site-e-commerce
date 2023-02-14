<?php
require_once("init.inc.php");
$contenu = '';


$donnees = executeRequete("select id_produit,reference,titre, prix, photo from produit");
$contenu .= '<div class= "product-grid">';
while($produit = $donnees->fetch_assoc())
{
    $contenu .= '<div class="product">';
    $contenu .= "<h2>$produit[titre]</h2>";
    $contenu .= "<a href=\"fiche_produit.php?id_produit=$produit[id_produit]\"><img src=\"photo/$produit[photo]\" =\"200\" height=\"200\"></a>";
    $contenu .= "<p>$produit[prix] €</p>";
    $contenu .= '<a href="fiche_produit.php?id_produit=' . $produit['id_produit'] . '">Voir la fiche</a>';
    $contenu .= '</div>';
}
$contenu .= '</div>';

require_once("haut.inc.php");
echo $contenu;
require_once("bas.inc.php"); ?>