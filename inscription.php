<?php
require_once("init.inc.php");
$contenu = '';

if($_POST)
{

    
        $membre = executeRequete("SELECT * FROM membre WHERE email='$_POST[email]'");
        if($membre->num_rows > 0)
        {
            $contenu .= "<div class='erreur'>Email indisponible. Veuillez en choisir un autre svp.</div>";
            echo $contenu;
        }
        else
        {
            // $_POST['mdp'] = md5($_POST['mdp']);
            foreach($_POST as $indice => $valeur)
            {
                $_POST[$indice] = htmlEntities(addSlashes($valeur));
            }
            executeRequete("INSERT INTO membre (email, nom, prenom, mdp) VALUES ('$_POST[email]', '$_POST[nom]', '$_POST[prenom]', '$_POST[mdp]')");

            header('Location: https://umbrellawhite.000webhostapp.com/connexion.php');
            $contenu .= '<div class="validation">Inscription réussie !</div>';
            echo $contenu;
        }
}

require_once("haut.inc.php");
?>

<div id="container">
    <form method="post" action="">

        <h1>Inscription</h1>

        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" placeholder="exemple@gmail.com"><br><br>

        <label for="mdp">Mot de passe</label><br>
        <input type="password" id="mdp" name="mdp" required="required"><br><br>

        <label for="nom">Nom</label><br>
        <input type="text" id="nom" name="nom" placeholder="votre nom"><br><br>

        <label for="prenom">Prénom</label><br>
        <input type="text" id="prenom" name="prenom" placeholder="votre prénom"><br><br>


        <input type="submit" name="inscription" value="S'inscrire">
    </form>
</div>

<?php require_once("bas.inc.php"); ?>
