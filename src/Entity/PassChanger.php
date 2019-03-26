<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;



class PassChanger
{

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;
    
    private $newPassword;

    private $newPassword2;


    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getNewPassword2(): ?string
    {
        return $this->newPassword2;
    }

    public function setNewPassword2(string $newPassword): self
    {
        $this->newPassword2 = $newPassword;

        return $this;
    }
}
