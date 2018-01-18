<?php
/**
 * Created by PhpStorm.
 * User: Florian
 * Date: 17/01/18
 * Time: 09:17
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Veille;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class VeilleController
 *
 * @package AppBundle\Controller
 * @Route("veille")
 */
class VeilleController extends Controller
{
    /**
     * return all subjects
     * @Route("/", name="veille_index")
     */
    public function indexAction(){
       $em = $this->getDoctrine()->getManager();

       $veilles = $em->getRepository('AppBundle:Veille')->findAll();

       return $this->render('veille/index.html.twig', array (
           'veilles' => $veilles
       ));

    }

    /**
     * shows one veille
     * @Route("/show/{id}", name="veille_show")
     */
    public function showOneAction(Veille $veille){

        return $this->render('veille/show.html.twig', array (
            'veille' => $veille
        ));
    }

}