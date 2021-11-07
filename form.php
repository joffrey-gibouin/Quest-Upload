<?php

$errors = [];
if($_SERVER["REQUEST_METHOD"] === "POST" ){
    $name = $_POST['name'];
    $firstname = $_POST['firstname'];
    $age = $_POST['age'];
    $uploadDir = 'public/uploads/';
    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $authorizedExtensions = ['jpg','png','webp'];
    $maxFileSize = 1000000;

    if( (!in_array($extension, $authorizedExtensions))){
        $errors[] = 'Veuillez sélectionner une image de type Jpg, Png ou webp !';
    }
    if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize)
    {
        $errors[] = "Votre fichier doit faire moins de 2M !";
    }
    if (count($errors) === 0) {

    move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
    }

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quest Upload</title>
</head>
<body>
    <div>
        <?php foreach ($errors as $error): ?>
            <?= $error ?>
        <?php endforeach; ?>
    </div>
    <form method="post" action="form.php" enctype="multipart/form-data">
        <label for="imageUpload">Upload an profile image</label>
        <input type="file" name="avatar" id="imageUpload" /><br>
        <input type="text" name="name" placeholder="Your name"><br>
        <input type="text" name="firstname" placeholder="Your firstname"><br>
        <input type="number" name="age" placeholder="Your age"><br>
        <button name="send">Send</button>
    </form>
   <?php if(isset($name) && isset($firstname) && isset($age)): ?>
   <div>
       <h1>Présentation</h1>
       <p>Nom: <?= $name ?></p>
       <p>Prénom: <?= $firstname ?></p>
       <p>Age: <?= $age ?></p>
       <p>Photo:</p>
       <img src="<?= $uploadFile ?>" >
   </div>
<?php endif; ?>
</body>
</html>
