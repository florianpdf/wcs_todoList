<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     */
    public function indexAction(Request $request)
    {
        // CRéation d'un formulaire de recherche non lié à une entité, ce formulaire possedera l'id task_search
        $form = $this->createFormBuilder(null, ['attr' => ['id' => 'task_search']])
            ->add('search', TextType::class, array(
                'attr' => array(
                    'data-url' => $this->generateUrl('autocomplete_task'),
                    'autocomplete' => 'off'
                )
            ))
            ->add('submit', SubmitType::class)
            ->getForm();

        // Hydratation du form
        $form->handleRequest($request);

        // Si requête Ajax
        if ($request->isXmlHttpRequest()){

            // Récupération de la saisi du formulaire envoyé via ajax
            $title = $form->getData()['search'];

            // Récupération de la base de donnée
            $em = $this->getDoctrine()->getManager();

            // Récupération de la task par son id
            $task = $em->getRepository(Task::class)->findOneByTitle($title);

            // Génération d'un templateque l'on injectera en jquery dans le dom
            $view = $this->renderView('task/task_result_search.html.twig', array(
                'task' => $task
            ));

            // Renvoie du template
            return new Response($view);
        }

        // Si pas de requête ajax, on a un process de gestion de formulaire traditionnel
        else{
            if ($form->isSubmitted()){
                $title = $form->getData()['search'];

                $em = $this->getDoctrine()->getManager();
                $task = $em->getRepository(Task::class)->findOneByTitle($title);

                return $this->render('task/show.html.twig', array(
                    'task' => $task
                ));
            }
        }

        return $this->render('default/index.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Get all task title by pattern with ajax request
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/autocompletetask", name="autocomplete_task")
     */
    public function autoCompleteTaskAction(Request $request){

        // Si on est dans une requête ajax
        if ($request->isXmlHttpRequest()){

            // Récupération du pattern saisi dans le formulaire
            $data = $request->get('term');

            // Récupération de la base de donnée
            $em = $this->getDoctrine()->getManager();

            // Réquete en base permettant de récupérer tous les titres qui possèdent le pattern
            $taskTitles = $em->getRepository(Task::class)->findAutocompleteTitle($data);

            // Retourne une réponse json avec un header adéquat
            return new JsonResponse(json_encode($taskTitles));
        }
        else{
            // Si la requête n'est pas une requête ajax, on générère une erreur
            throw new HttpException(500, 'Not an ajax call');
        }
    }
}
