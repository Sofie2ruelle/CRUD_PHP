<?php
/* Inclure le fichier config */
require_once "config.php";
 
/* Definir les variables */
$pseudo = $email = $content = "";
$pseudo_err = $email_err = $content_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
    /* Validate name */
    $input_name = trim($_POST["pseudo"]);
    if(empty($input_name)){
        $pseudo_err = "Veillez entrez un pseudo.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $pseudo_err = "Veillez entrez a valid name.";
    } else{
        $pseudo = $input_name;
    }
    
    /* Validate email */
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Veillez entrez une email.";     
    } else{
        $email = $input_email;
    }
    
    /* Validate content */
    $input_content = trim($_POST["content"]);
    if(empty($input_content)){
        $content_err = "Veillez entrez l'content.";     
    } elseif(!ctype_digit($input_content)){
        $content_err = "Veillez entrez une valeur positive.";
    } else{
        $content = $input_content;
    }
    
    /* verifiez les erreurs avant enregistrement */
    if(empty($pseudo_err) && empty($email_err) && empty($content_err)){
        /* Prepare an insert statement */
        $sql = "INSERT INTO article (title, content, created_at) VALUES (?, ?, ?)";
        $sdb = "INSERT INTO user (pseudo, email, pwd, created_at";

         
        if($stmt = mysqli_prepare($link, $sql, $sdb)){
            /* Bind les variables à la requette preparée */
            mysqli_stmt_bind_param($stmt, "ssd", $param_pseudo, $param_email, $param_content);
            
            /* Set parameters */
            $param_pseudo = $pseudo;
            $param_email = $email;
            $param_content = $content;
            
            
            /* executer la requette */
            if(mysqli_stmt_execute($stmt)){
                /* opération effectuée, retour */
                header("location: index.php");
                exit();
            } else{
                echo "Oops! une erreur est survenue.";
            }
        }
         
        /* Close statement */
        mysqli_stmt_close($stmt);
    }
    
    /* Close connection */
    mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .wrapper{
            width: 700px;
            margin: 0 auto;
            background-color: lightslategray;
            color: white;
            
        }

        body {
            background-color: aliceblue;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Publier un article</h2>
                    <p>Remplir le formulaire pour vous enregistrer</p>


                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Pseudo</label>
                            <input type="text" name="pseudo" class="form-control <?php echo (!empty($pseudo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pseudo; ?>">
                            <span class="invalid-feedback"><?php echo $pseudo_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Article</label>
                            <textarea name="text" class="form-control <?php echo (!empty($content_err)) ? 'is-invalid' : ''; ?>"><?php echo $content; ?></textarea>
                            <span class="invalid-feedback"><?php echo $content_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="content" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Enregistrer">
                        <a href="index.php" class="btn btn-secondary ml-2">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>