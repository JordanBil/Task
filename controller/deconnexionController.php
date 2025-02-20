<?php

class DecoController extends AbstractController {

    public function deconnexion():void {
        session_start();
        session_destroy();
        header('location:/Task/');
        exit;
    }
    
    public function render():void{}
}