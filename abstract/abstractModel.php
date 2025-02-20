

<?php

abstract class AbstractModel {

    private ?interfaceBdd $bdd;

    public function getBdd():?interfaceBdd{
        return $this->bdd;
    }

    public function setBdd(?interfaceBdd $bdd):self{
        $this->bdd = $bdd;
        return $this;
    }

    public abstract function add():void;
    public abstract function update():void;
    public abstract function delete():void;
    public abstract function getAll():?array;
    public abstract function getById():?array;
}