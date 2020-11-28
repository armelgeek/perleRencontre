<?php

namespace App\Entity\Autres;

class RechercheRapide{

    private $roles;
    
    public function setRoles(?string $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getRoles(): ?string
    {
        return $this->roles;
    }
}