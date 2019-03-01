<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PoorController extends Controller
{
	/**
	 * @Route("/")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function number()
    {
        $number = mt_rand(0, 100);
        
        $bodySt = 'Lucky number: '.$number.'';

        return $this->render('poor.html.twig', array(
			'body' => $bodySt
		));
        
        
        return new Response(
            $bodySt
        );
    }
}