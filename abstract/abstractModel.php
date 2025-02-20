<?php
abstract class AbstractModel {
    //ATTRIBUTS
    private ?interfaceBdd $bdd;
    

    //CONSTRUCTEUR
    public function __construct(?interfaceBdd $bdd){
        $this->bdd = $bdd;
    }
    
    //GETTER ET SETTER
    public function getBdd(): ?interfaceBdd { return $this->bdd; }
    public function setBdd(?interfaceBdd $bdd): self { $this->bdd = $lbdd; return $this; }

    //METHOD
    public abstract function add():void;
    public abstract function update():void;
    public abstract function delete():void;
    public abstract function getAll():?array;
    public abstract function getById():?array;
}