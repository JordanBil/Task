<?php
session_start();

include './env.php';
include './utils/utils.php';
include './abstract/abstractModel.php';
include './abstract/abstractController.php';
include './interface/interfaceView.php';
include './interface/interfaceBdd.php';
include './utils/mySQLBDD.php';
include './vue/viewHeader.php';
include './vue/viewFooter.php';
include './vue/viewAccount.php';
include './vue/viewMyAccount.php';
include './model/account.php';
include './controller/accountController.php';
include './controller/myAccountController.php';
include './controller/deconnexionController.php';

$url = parse_url($_SERVER['REQUEST_URI']);

$path = isset($url['path']) ? $url['path'] : '/Task/';

switch($path){
    case '/Task/' :
        $home = new AccountController();
        $home->setListModels(['accountModel'=> new AccountModel()])->setListViews(['header'=>new ViewHeader(),'footer'=> new ViewFooter(), 'accueil' => new ViewAccount()]);
        $home->render();
        break;
    
    case '/Task/moncompte' :
        $myAccount = new MyAccountController();
        $myAccount->setListModels(null)->setListViews(['header'=>new ViewHeader(),'footer'=> new ViewFooter(), 'myAccount' => new ViewMyAccount()]);
        $myAccount->render();
        break ;

    case '/Task/deconnexion' :
        $deconnexion = new DecoController();
        $deconnexion->deconnexion();
        break;
}