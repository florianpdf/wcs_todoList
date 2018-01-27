<?php
/**
 * Created by PhpStorm.
 * User: Florian
 * Date: 17/01/18
 * Time: 09:17
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Entity\Veille;
use AppBundle\Form\VeilleType;
use AppBundle\Services\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
            'veille' => $veille,
        ));
    }

    /**
     * create new veille
     * @Route("/new", name="veille_new")
     */
    public function newAction(Request $request, FileUploader $fileUploader){
        $veille = new Veille();
        $form = $this->createForm(VeilleType::class, $veille);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $fileUploader->upload($veille);

            $em = $this->getDoctrine()->getManager();
            $em->persist($veille);
            $em->flush();

            return $this->redirectToRoute('veille_show', array(
               'id' => $veille->getId()
            ));
        }
        return $this->render('veille/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Edit one veille
     *
     * @Route("/edit/{id}", name="veille_edit")
     */
    public function editAction(Request $request, Veille $veille){

        $form = $this->createForm(VeilleType::class, $veille);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirectToRoute('veille_show', array(
                'id' => $veille->getId()
            ));
        }

        return $this->render('veille/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Delete one
     *
     * @Route("delete/{id}", name="veille_delete")
     */
    public function deleteAction(Veille $veille){
        $em = $this->getDoctrine()->getManager();

        $em->remove($veille);
        $em->flush();

        return $this->redirectToRoute('veille_index');
    }

}