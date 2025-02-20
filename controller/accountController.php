<?php
class AccountController extends AbstractController {
    //METHOD

    function signUp(PDO $bdd):string{
        //Vérifier qu'on reçoit le formulaire
        if(isset($_POST['submitSignUp'])){
            //Vérifier les champs vide
            if(empty($_POST['lastname']) || empty($_POST['firstname']) || empty($_POST['email']) || empty($_POST['password'])){
                //Retourne le message d'erreur
                return "Veuillez remplir les champs !";
            }
    
            //Vérifier le format des données : ici l'email
            if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
                //Retourne le message d'erreur
                return "Email pas au bon format !";
            }
    
            //Nettoyer les données
            $lastname = sanitize($_POST['lastname']);
            $firstname = sanitize($_POST['firstname']);
            $email = sanitize($_POST['email']);
            $password = sanitize($_POST['password']);
    
            //Hasher le mot de passe
            $password = password_hash($password, PASSWORD_BCRYPT);
    
            //Vérifier que l'utilisateur n'existe pas déjà en bdd
            if(!empty(getAccountByEmail($bdd, $email))){
                //Retourne le message d'erreur
                return "Cet email existe déjà !";
            }
    
            //J'enregistre mon utilisateur en bdd
            $account = [$firstname, $lastname, $email, $password];
            addAccount($bdd, $account);
        
            return "$firstname $lastname a été enregistré avec succès !";
        }
        return '';
    }
    
    function displayAccounts(PDO $bdd){
        //Récupération de la liste des utilisateurs
        $data = getAllAccount($bdd);
    
        $listUsers = "";
        foreach($data as $account){
            $listUsers = $listUsers."<li><h2>".$account['firstname'] ." ". $account['lastname']."</h2>      <p>".$account['email']."</p></li>";
        }
        return $listUsers;
    }

    
    public function displayForm(?string $message='',?string $messageSignIn=''):string{
        if(!isset($_SESSION['id'])){
            return '
            <section>
                <h1>Inscription</h1>
                <form action="" method="post">
                    <input type="text" name="lastname" placeholder="Le Nom de Famille">
                    <input type="text" name="firstname" placeholder="Le Prénom">
                    <input type="text" name="email" placeholder="L\'Email">
                    <input type="password" name="password" placeholder="Le Mot de Passe">
                    <input type="submit" name="submitSignUp">
                </form>
                <p>'. $message .'</p>
            </section>
            <section>
                <h1>Connexion</h1>
                <form action="" method="post">
                    <input type="text" name="emailSignIn" placeholder="L\'Email">
                    <input type="password" name="passwordSignIn" placeholder="Le Mot de Passe">
                    <input type="submit" name="submitSignIn">
                </form>
                <p>'.$messageSignIn.'</p>
            </section>';
        }
        return '';
    }

    public function displayAccount():string{
        //Récupération de la liste des utilisateurs
        //$data = getAllAccount($bdd);
        $data = [];


        $listUsers = "";
        foreach($data as $account){
            $listUsers = $listUsers."<li><h2>".$account['firstname'] ." ". $account['lastname']."</h2>      <p>".$account['email']."</p></li>";
        }
        return $listUsers;
    }

    public function render():void{
        $this->renderHeader();
        echo $this->getListViews()['accueil']->setForm($this->displayForm())->setListUsers($this->displayAccount())->displayView();
        $this->renderFooter();
    }
}