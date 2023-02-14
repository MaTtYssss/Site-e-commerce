<?php
require_once("init.inc.php");
if(internauteEstConnecte() || internauteEstConnecteEtEstAdmin())
{
    header('Location: https://umbrellawhite.000webhostapp.com/index.php');

}

if(isset($_GET['action']) && $_GET['action'] == "deconnexion")
{
    session_destroy();
    header('Location: https://umbrellawhite.000webhostapp.com/index.php');
}


$contenu = '';
if($_POST)
{
    // $contenu .=  "pseudo : " . $_POST['pseudo'] . "<br>mdp : " .  $_POST['mdp'] . "";
    $resultat = executeRequete("SELECT * FROM membre WHERE email='$_POST[email]'");
    if($resultat->num_rows != 0)
    {
        // $contenu .=  '<div style="background:green">pseudo connu!</div>';
        $membre = $resultat->fetch_assoc();
        if($membre['mdp'] == $_POST['mdp'])
        {
            //$contenu .= '<div class="validation">mdp connu!</div>';
            foreach($membre as $indice => $element)
            {
                if($indice != 'mdp')
                {
                    $_SESSION['membre'][$indice] = $element;
                }
            }
            header('Location: https://umbrellawhite.000webhostapp.com/profil.php');
        }
        else
        {
            $contenu .= '<div class="erreur">Erreur de MDP</div>';
            echo $contenu;
        }
    }
    else
    {
        $contenu .= '<div class="erreur">Erreur de email</div>';
        echo $contenu;
    }
}


  
 require_once("haut.inc.php"); ?>


<div id="container">
    <form method="post" action="">
        <h1>Connexion</h1>
        
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email"><br> <br>

        <label for="mdp">Mot de passe</label><br>
        <input type="password" id="mdp" name="mdp"><br><br>

        <input type="submit" value="Se connecter">
    </form>
</div>

<?php require_once("bas.inc.php"); 
 require_once("init.inc.php");?>




