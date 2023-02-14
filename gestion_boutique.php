<?php
require_once("init.inc.php");
$contenu = '';

if(!internauteEstConnecteEtEstAdmin())
{
    header("connexion.php");
    exit();
}
//--- SUPPRESSION PRODUIT ---//
if(isset($_GET['action']) && $_GET['action'] == "suppression")
{   // $contenu .= $_GET['id_produit']
    $resultat = executeRequete("SELECT * FROM produit WHERE id_produit=$_GET[id_produit]");
    $produit_a_supprimer = $resultat->fetch_assoc();
    $chemin_photo_a_supprimer = $_SERVER['DOCUMENT_ROOT'] . $produit_a_supprimer['photo'];
    if(!empty($produit_a_supprimer['photo']) && file_exists($chemin_photo_a_supprimer)) unlink($chemin_photo_a_supprimer);
    executeRequete("DELETE FROM produit WHERE id_produit=$_GET[id_produit]");
    $contenu .= '<div class="validation">Suppression du produit : ' . $_GET['id_produit'] . '</div>';
    $_GET['action'] = 'affichage';
}

if(isset($_GET['action']) && $_GET['action'] == "restockage")
{
    executeRequete("UPDATE produit SET stock=50 WHERE id_produit=$_GET[id_produit]");
    $contenu .= '<div class="validation stock">Restockage du produit : ' . $_GET['id_produit'] . '</div>';
    $_GET['action'] = 'affichage';
}



if(!empty($_POST))
{
    $photo_bdd = "logo.png";
    executeRequete("REPLACE INTO produit (reference, titre, description, prix, stock, photo) values ('$_POST[reference]', '$_POST[titre]', '$_POST[description]', $_POST[prix], $_POST[stock], '$photo_bdd')");
    $contenu .= '<div class="validation">Le produit a été ajouté</div>';
}
$contenu .= '<a class="btn" href="?action=affichage">Affichage des produits</a><br><br><br>';
$contenu .= '<a class="btn" href="?action=ajout">Ajout d\'un produit</a><br><br><hr><br>';

if(isset($_GET['action']) && $_GET['action'] == "affichage")
{
    $resultat = executeRequete("SELECT * FROM produit");

    $contenu .= '<h2> Affichage des Produits </h2>';
    $contenu .= 'Nombre de produit(s) dans la boutique : ' . $resultat->num_rows;
    $contenu .= '<table border="1"><tr>';

    while($colonne = $resultat->fetch_field())
    {
        $contenu .= '<th>' . $colonne->name . '</th>';
    }
    //$contenu .= '<th>Modification</th>';
    $contenu .= '<th>Supression</th>';
    $contenu .= '<th>Restockage</th>';
    $contenu .= '</tr>';

    while ($ligne = $resultat->fetch_assoc())
    {
        $contenu .= '<tr>';
        foreach ($ligne as $indice => $information)
        {
            if($indice == "photo")
            {
                $contenu .= '<td><img src="photo/' . $information . '" ="50" height="50"></td>';
            }
            else
            {
                $contenu .= '<td>' . $information . '</td>';
            }
        }
        //$contenu .= '<td><a href="?action=modification&id_produit=' . $ligne['id_produit'] .'"><img class="imgBou" src="photo/84380.png"></a></td>';
        $contenu .= '<td><a href="?action=suppression&id_produit=' . $ligne['id_produit'] .'" OnClick="return(confirm(\'En êtes vous certain ?\'));"><img class="imgBou" src="photo/121113.png"></a></td>';
        $contenu .= '<td><a href="?action=restockage&id_produit=' . $ligne['id_produit'] .'"><img class="imgBou" src="photo/2952759.png"></a></td>';
        $contenu .= '</tr>';

    }
    $contenu .= '</table><br><hr><br>';
}

require_once("haut.inc.php");
echo $contenu;
if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')){

    if(isset($_GET['id_produit']))
    {
    $resultat = executeRequete("SELECT * FROM produit WHERE id_produit=$_GET[id_produit]");
    $produit_actuel = $resultat->fetch_assoc();
}
    echo '

    <h1> Formulaire Produits </h1>
    <form method="post" action="">
    
        
        <label for="reference">reference</label><br>
        <input type="text" id="reference" name="reference" placeholder="la référence de produit"><br><br>
 
        <label for="titre">titre</label><br>
        <input type="text" id="titre" name="titre" placeholder="le titre du produit"> <br><br>
 
        <label for="description">description</label><br>
        <textarea name="description" id="description" placeholder="la description du produit"></textarea><br><br>
         
        <label for="prix">prix</label><br>
        <input type="text" id="prix" name="prix" placeholder="le prix du produit"><br><br>
         
        <label for="stock">stock</label><br>
        <input type="text" id="stock" name="stock" placeholder="le stock du produit"><br><br>
         
         
        <input type="submit" value="'; echo ucfirst($_GET['action']) . ' du produit">
    </form>';
}
require_once("bas.inc.php");
?>