<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // Je vérifie que le formulaire est soumis, comme pour tout traitement de formulaire.
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // chemin vers un dossier sur le serveur qui va recevoir les fichiers transférés (attention ce dossier doit être accessible en écriture)
        $uploadDir = 'public/uploads/';

        // le nom de fichier sur le serveur est celui du nom d'origine du fichier sur le poste du client (mais d'autre stratégies de nommage sont possibles)
        $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);

        // on déplace le fichier temporaire vers le nouvel emplacement sur le serveur. Ça y est, le fichier est uploadé
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $uploadDir = 'public/uploads/';
        $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $authorizedExtensions = ['jpg', 'gif', 'png', 'webp'];
        $maxFileSize = 131072;
        $file_name_new = uniqid('', true) . '.' . ($_FILES['avatar']['name']);

        // Je sécurise et effectue mes tests

        /****** Si l'extension est autorisée *************/
        if ((!in_array($extension, $authorizedExtensions))) {
            $errors[] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Webpg ou Gif !';
        }

        /****** On vérifie si l'image existe et si le poids est autorisé en octets *************/
        if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
            $errors[] = "Votre fichier doit faire moins de 1M !";
        }
    }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <p> <label for="imageUpload">Envoyer votre photo de profil</label></p>
        <p> <input type="file" name="avatar" id="imageUpload"></p>
        <button type="submit">Envoyer 🚀</button>

    </form>
    <?php
    if (!empty($errors)) {
        echo '<div class="errors">';
        echo  '<ul>';
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul>';
        echo '</div>';
    }
    ?>

    <img src="public/uploads/<?php echo $_FILES['avatar']['name'] ?>" alt="Photo de profil" width=75%>


</body>

</html>