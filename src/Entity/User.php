<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
//use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
	const ROLE_DEFAULT = 'ROLE_USER';
	
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;
    
    
    private $newPassword;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
	 * @ORM\ManyToMany(targetEntity="Role")
	 * @ORM\JoinColumn(onDelete="CASCADE")
	 * @ORM\JoinTable(name="user_roles")
	 */
	protected $rolesAssigned;
    
    public function __construct()
    {
        $this->isActive = true;
        $this->rolesAssigned = new ArrayCollection();
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }
    
    public function __toString()
    {
    	return $this->getUsername();
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
    	$roleCollection = $this->getRolesAssigned();
    	$rArray=[];
    	foreach ($roleCollection as $AssRole)
    	{
    		$rArray[] = $AssRole->getName();
    	}
    	return $rArray;
        //return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        	$this->isActive
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
        	$this->isActive            
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * @return Collection|Role[]
     */
    public function getRolesAssigned(): Collection
    {
        return $this->rolesAssigned;
    }

    public function addRolesAssigned(Role $rolesAssigned): self
    {
        if (!$this->rolesAssigned->contains($rolesAssigned)) {
            $this->rolesAssigned[] = $rolesAssigned;
        }

        return $this;
    }

    public function removeRolesAssigned(Role $rolesAssigned): self
    {
        if ($this->rolesAssigned->contains($rolesAssigned)) {
            $this->rolesAssigned->removeElement($rolesAssigned);
        }

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
}
