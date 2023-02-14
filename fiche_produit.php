<?php
require_once("init.inc.php");
$contenu = '';
if(isset($_GET['id_produit']))  { $resultat = executeRequete("SELECT * FROM produit WHERE id_produit = '$_GET[id_produit]'"); }
if($resultat->num_rows <= 0) { header("index.php"); exit(); }

$produit = $resultat->fetch_assoc();
$contenu .= "<h2>Titre : $produit[titre]</h2><hr><br>";
$contenu .= "<img class='img' src='photo/$produit[photo]' ='400' height='400'>";
$contenu .= "<p><i>Description: $produit[description]</i></p><br>";
$contenu .= "<p>Prix : $produit[prix] €</p><br>";

if($produit['stock'] > 0)
{
    $contenu .= "<i>Nombre d'produit(s) disponible : $produit[stock] </i><br><br>";
    $contenu .= '<form method="post" action="panier.php">';
    $contenu .= "<input type='hidden' name='id_produit' value='$produit[id_produit]'>";
    $contenu .= '<label for="quantite">Quantité : </label>';
    $contenu .= '<select id="quantite" name="quantite">';
    for($i = 1; $i <= $produit['stock']; $i++)
    {
        $contenu .= "<option>$i</option>";
    }
    $contenu .= '</select>';
    $contenu .= '<input type="submit" name="ajout_panier" value="ajout au panier">';
    $contenu .= '</form>';
}
else
{
    $contenu .= 'Rupture de stock !';
}
$contenu .= "<br><a href='index.php'>Retour vers la boutique</a>";
require_once("haut.inc.php");
echo $contenu;
require_once("bas.inc.php"); ?>