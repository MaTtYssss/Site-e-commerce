<?php
session_start();
if(isset($_POST['username']) && isset($_POST['password']))
{

    $db_username = 'root';
    $db_password = '';
    $db_name = 'infoclient';
    $db_host = 'localhost';
    $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
    or die('could not connect to database');


    $username = mysqli_real_escape_string($db,htmlspecialchars($_POST['username']));
    $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));

    if($username !== "" && $password !== "")
    {
        $requete = "SELECT count(*) FROM clients where 
 Email = '".$username."' and MotDePasse = '".$password."' ";
        $exec_requete = mysqli_query($db,$requete);
        $reponse = mysqli_fetch_array($exec_requete);
        $count = $reponse['count(*)'];
        if($count!=0)
        {
            $_SESSION['username'] = $username;
            header('Location: principale.php');
        }
        else
        {
            header('Location: login.php?erreur=1');
        }
    }
    else
    {
        header('Location: login.php?erreur=2');
    }
}
else
{
    header('Location: login.php');
}
mysqli_close($db);
?>