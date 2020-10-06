<?php

abstract class Entity implements EntityInterface
{
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.implode('', array_map(function($item) {
                            return ucfirst($item);
                        }, explode('_', $key)
                    )
                );

            // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
                // On appelle le setter.
                $this->$method($value);
            }
        }
    }
}