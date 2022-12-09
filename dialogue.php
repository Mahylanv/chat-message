<?php 

//-------------------------------
// 01 -  Création de la BDD
    // bdd = dialogue
    // table = commentaire
        // id_commentaire INT(3) PK AI
        // pseudo VARCHAR (200)
        // message TEXT
        // date_enregistrement DATETIME
// 02 - Créer une connexion à la BDD
// 03 - Faire un formulaire avec les champs suivants :
    // pseudo input type="text"
    // message textarea
    // bouton de validation
// 04 - Récupération des données du form + contrôles
// 05 - Déclenchement d'une requete permettant d'enregistrer le message dans la BDD
// 06 - Déclenchement d'une requete de récupération pour récupérer tous les messages en BDD

// 07 - Affichage des commentaires dans la page
// 08 - Affichage en haut des messages du nombre de messages
// 09 - Affichage de la date_enregistrement en fr
// 10 - Amélioration de la mise en forme

$erreur = '';
$host = 'mysql:host=localhost;dbname=dialogue'; // serveur et nom bdd
        $login = 'root'; // login de connexion au serveur de bdd
        $password = ''; // le mdp, rien sur xampp et wamp, sur mamp il faut mettre root
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // pour la gestion des erreurs (pour voir les erreurs mysql)
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // pour forcer l'utf-8 
        );
        $pdo = new PDO($host, $login, $password, $options);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .conteneur { max-width: 1000px; margin: 30px auto; padding: 20px; border: 1px solid; }
        header { padding: 100px; background-color: mediumaquamarine; color: white; text-align: center; }
        form { margin: 50px auto; width: 35%; padding: 20px; border: 1px solid; }
        input { width: 100%; height: 35px;  }
        textarea { width: 100%; height: 60px;  }
        #valider { color: white; background-color: mediumaquamarine; border: 0; }
        #valider:hover {background-color: mediumturquoise;}
        table {width: 100%; border-collapse: collapse;}
        td,th {padding: 10px; border: 1px solid;}
        th {background-color: mediumaquamarine;}
        td {background-color: #B1FFEA;}
    </style>
</head>
<body>
<header><h1>Dialogue</h1></header>
    <div class="conteneur">


        <form method="post" action="" enctype="multipart/form-data">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo"><br><br>
            <label for="message">Message</label>
            <textarea name="text" id="Message" cols="30" rows="10"></textarea><br><br>
            <input type="submit" name="valider" id="valider" value="Valider">
        </form>
    </div>
    <?php
    
    if(isset($_POST['pseudo']) && isset($_POST['text'])) {
        $pseudo = trim($_POST['pseudo']);
        $text = trim($_POST['text']);
        $text = addslashes(($text)); //pour faire des antislash automatique
        $erreur = false;

        if(empty($pseudo)) {
            echo '<p class="erreur">Remplir ce champ</p>';
            $erreur = true;
        }
        
        if(empty($text)) {
            echo '<p class="erreur">Remplir ce champ</p>';
            $erreur = true;
        }

        if($erreur == false) {
        $pdo->query("INSERT INTO commentaire (id_commentaire, pseudo, message, date_enregistrement) VALUES (NULL, '$pseudo', '$text', NOW())");
        ?>

        
     <table>
        <?php 
        $resultat = $pdo->query("SELECT id_commentaire, pseudo, message, DATE_FORMAT(date_enregistrement, '%d/%m/%Y %H:%i:%s') AS date_fr FROM commentaire ORDER BY date_enregistrement DESC");
        ?>
            <tr>
                <th>ID</th>
                <th>Pseudo</th>
                <th>Message<?php echo ' ' . $resultat->rowCount() ?></th>
                <th>Date</th>
            </tr>
        
        <?php 
            
        
            while($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                foreach($ligne AS $valeur) {
                    echo '<td>' . $valeur . '</td>';
                }
                echo '</tr>';
            }
        ?>
        </table><?php
    }
    }
    ?>
    
     

</body>
</html>