<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture implements ContainerAwareInterface
{
    /**
     *
     * @var ContainerInterface
     */
    private $container;
    
	private $encoder;
	
	
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

	public function __construct(UserPasswordEncoderInterface $encoder)
	{
		$this->encoder = $encoder;
	}

	public function load(ObjectManager $manager)
	{
		$roleUser = new Role();
		$roleUser->setName('ROLE_USER');	
		$manager->persist($roleUser);
		
		$role1 = new Role();
		$role1->setName('ROLE_CANDIDATE');	
		$manager->persist($role1);
		
		$role1 = new Role();
		$role1->setName('ROLE_EMPLOYEE');	
		$manager->persist($role1);
		
		$role1 = new Role();
		$role1->setName('ROLE_HR');	
		$manager->persist($role1);
		
		$role1 = new Role();
		$role1->setName('ROLE_MANAGER');	
		$manager->persist($role1);
		
		$roleAdmin = new Role();
		$roleAdmin->setName('ROLE_ADMIN');		
		$manager->persist($roleAdmin);
		
		$user = new User();
		$email = $plainPassword = $this->container->getParameter('app.admin_email_initial');
		$user->setEmail($email);
		$user->setUsername('admin');
		$user->addRolesAssigned($roleUser);
		$user->addRolesAssigned($roleAdmin);
		
		// $encoder = new UserPasswordEncoderInterface();
		$plainPassword = $this->container->getParameter('app.admin_pass_initial');
		$encoded = $this->encoder->encodePassword($user, $plainPassword);
		
		// $hash = $this->getContainer()->get('security.password_encoder')->encodePassword($user, 'user password');
		$user->setPassword($encoded);
		
		$manager->persist($user);
		
		
		$user = new User();
		$user->setEmail('robot@macrobond.com');
		$user->setUsername('robot');
		$user->addRolesAssigned($roleUser);
		$user->addRolesAssigned($roleAdmin);
		
		// $encoder = new UserPasswordEncoderInterface();
		$plainPassword = $this->container->getParameter('app.admin_pass_initial');
		$encoded = $this->encoder->encodePassword($user, $plainPassword);
		
		// $hash = $this->getContainer()->get('security.password_encoder')->encodePassword($user, 'user password');
		$user->setPassword($encoded);
		
		$manager->persist($user);
		
		$manager->flush();
	}
}
