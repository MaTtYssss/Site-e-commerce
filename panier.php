<?php
require_once("init.inc.php");
$mysqli = new mysqli("localhost", "id20173262_mmy", "3vf)#qHCkW-*hWEA", "id20173262_umbrellawhiteproject");
if ($mysqli->connect_error) die('Un problème est survenu lors de la tentative de connexion à la BDD : ' . $mysqli->connect_error);

$contenu = '';

if(isset($_POST['ajout_panier']))
{   // debug($_POST);
    $resultat = executeRequete("SELECT * FROM produit WHERE id_produit='$_POST[id_produit]'");
    $produit = $resultat->fetch_assoc();
    ajouterProduitDansPanier($produit['titre'],$_POST['id_produit'],$_POST['quantite'],$produit['prix']);

}

if(isset($_GET['action']) && $_GET['action'] == "vider")
{
    unset($_SESSION['panier']);
}

if(isset($_POST['payer']))
{
    for($i=0 ;$i < count($_SESSION['panier']['id_produit']) ; $i++)
    {
        $resultat = executeRequete("SELECT * FROM produit WHERE id_produit=" . $_SESSION['panier']['id_produit'][$i]);
        $produit = $resultat->fetch_assoc();
        if($produit['stock'] < $_SESSION['panier']['quantite'][$i])
        {
            $contenu .= '<hr><div class="erreur">Stock Restant: ' . $produit['stock'] . '</div>';
            $contenu .= '<div class="erreur">Quantité demandée: ' . $_SESSION['panier']['quantite'][$i] . '</div>';
            if($produit['stock'] > 0)
            {
                $contenu .= '<div class="erreur">la quantité de l\'produit ' . $_SESSION['panier']['id_produit'][$i] . ' à été réduite car notre stock était insuffisant, veuillez vérifier vos achats.</div>';
                $_SESSION['panier']['quantite'][$i] = $produit['stock'];
            }
            else
            {
                $contenu .= '<div class="erreur">l\'produit ' . $_SESSION['panier']['id_produit'][$i] . ' à été retiré de votre panier car nous sommes en rupture de stock, veuillez vérifier vos achats.</div>';
                retirerProduitDuPanier($_SESSION['panier']['id_produit'][$i]);
                $i--;
            }
            $erreur = true;
        }
    }
    if(!isset($erreur))
    {
        executeRequete("INSERT INTO commande ( id_membre, montant, date_enregistrement) VALUES (" . $_SESSION['membre']['id_membre'] . "," . montantTotal() . ", NOW())");
        $id_commande = $mysqli->insert_id;
        echo $id_commande;
        print_r($_SESSION['panier']['id_produit']);
        echo implode(",",$_SESSION['panier']['id_produit']);

        //print_r('membre et idmembre'.$_SESSION['membre']['id_membre']);
        for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
        {
            echo 'pannier idproduit' .$_SESSION['panier']['id_produit'][$i];
            echo 'panier quantite'.$_SESSION['panier']['quantite'][$i];
            echo 'panier prix'.$_SESSION['panier']['prix'][$i];
            echo "id commande : ".$id_commande;
            executeRequete("INSERT INTO details_commande (id_commande, id_membre, id_produit, quantite, prix) VALUES ($id_commande," . $_SESSION['membre']['id_membre'] . " , " . $_SESSION['panier']['id_produit'][$i] . "," . $_SESSION['panier']['quantite'][$i] . "," . $_SESSION['panier']['prix'][$i] . ")");
            executeRequete("UPDATE produit SET stock=stock-1 WHERE id_produit = ".$_SESSION['panier']['id_produit'][$i]);
        }
        unset($_SESSION['panier']);
        mail($_SESSION['membre']['email'], "confirmation de la commande", "Merci votre n° de suivi est le $id_commande");
        //, "From:vendeur@dp_site.com"
        $contenu .= "<div class='validation'>Merci pour votre commande. votre n° de suivi est le $id_commande</div>";
    }
}
include("haut.inc.php");
echo $contenu;

echo "<table border='1' style='border-collapse: collapse' cellpadding='7'>";
echo "<tr><td colspan='5'>Panier</td></tr>";
echo "<tr><th>Titre</th><th>Produit</th><th>Quantité</th><th>Prix Unitaire</th></tr>";
if(empty($_SESSION['panier']['id_produit']) && (!internauteEstConnecte())) // panier vide
{
    echo 'Veuillez vous <a href="inscription.php">inscrire</a> ou vous <a href="connexion.php">connecter</a> afin de pouvoir consulter votre panier.';
}
elseif (empty($_SESSION['panier']['id_produit'])){
    echo "<tr><td colspan='5'>Votre panier est vide</td></tr>";
}

else
{
    for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
    {
        echo "<tr>";
        echo "<td>" . $_SESSION['panier']['titre'][$i] . "</td>";
        echo "<td>" . $_SESSION['panier']['id_produit'][$i] . "</td>";
        echo "<td>" . $_SESSION['panier']['quantite'][$i] . "</td>";
        echo "<td>" . $_SESSION['panier']['prix'][$i] . "</td>";
        echo "</tr>";
    }
    echo "<tr><th colspan='3'>Total</th><td colspan='2'>" . montantTotal() . " euros</td></tr>";
    if(internauteEstConnecte())
    {
        echo '<form method="post" action="">';
        echo '<tr><td colspan="5"><input type="submit" name="payer" value="Valider et déclarer le paiement"></td></tr>';
        echo '</form>';
    }
    else
    {
        $contenu .= 'Veuillez vous <a href="inscription.php">inscrire</a> ou vous <a href="connexion.php">connecter</a> afin de pouvoir consulter votre panier.';
        echo $contenu;
    }
    echo "<tr><td colspan='5'><a href='?action=vider'>Vider mon panier</a></td></tr>";
}
echo "</table><br>";
$contenu .= "<br><a class='btn' href='index.php'>Retour vers la boutique</a>";
echo $contenu;
include("bas.inc.php");
?>