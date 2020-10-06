<?php

interface EntityInterface {

    public function getId();
    public function hydrate(array $donnees);
}