<!Doctype html>
<html>
<head>
    <title>Umbrella White</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <div class="conteneur">
        <div>
            
           </div>
        <nav>
            <?php
            if(internauteEstConnecteEtEstAdmin())
            {
                echo '<a class="test" style="float:right" href="gestion_membre.php" >Gestion des membres</a>';
                echo '<a class="test" style="float:right" href="gestion_commande.php">Gestion des commandes</a>';
                echo '<a class="test" style="float:right" href="gestion_boutique.php">Gestion de la boutique</a>';
                
            }
            if(internauteEstConnecte())
            {
                echo '<a class="test"  style="float:left" href="profil.php">Voir votre profil</a>';
                echo '<a class="test"  style="float:left" href="index.php">Accès à la boutique</a>';
                echo '<a class="test"  style="float:left" href="panier.php">Voir votre panier</a>';
                echo '<a class="test" style="float:right" href="connexion.php?action=deconnexion">Se déconnecter</a>';
            }
            else
            {
                echo '<a class="test"  style="float:right" href="inscription.php">Inscription</a>';
                echo '<a class="test" style="float:right" href="connexion.php">Connexion</a>';
                echo '<a class="test" style="float:left" href="index.php">Accès à la boutique</a>';
                echo '<a class="test" style="float:left" href="panier.php">Voir votre panier</a>';
            }
            
            echo '<a href="index.php"><img class=logo src=photo/BlackJap.png style="width:180px;height:99px"></a>';
            ?>
        </nav>
    </div>  
</header>
<section>
    <div class="conteneur">
