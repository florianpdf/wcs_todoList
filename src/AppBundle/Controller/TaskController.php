<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Task controller.
 *
 * @Route("task")
 */
class TaskController extends Controller
{
    /**
     * Lists all task entities.
     *
     * @Route("/", name="task_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tasks = $em->getRepository('AppBundle:Task')->myFindAll();

        return $this->render('task/index.html.twig', array(
            'tasks' => $tasks,
        ));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \AppBundle\Services\FileUploader          $fileUploader
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/new", name="task_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, FileUploader $fileUploader)
    {
        $task = new Task();
        $form = $this->createForm('AppBundle\Form\TaskType', $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

//            File is not mandatory in task, so we check if user upload file
            if ($task->getPicture()->getFile() != null) {
                $fileUploader->upload($task->getPicture());
            }

            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('task_show', array('id' => $task->getId()));
        }

        return $this->render('task/new.html.twig', array(
            'task' => $task,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a task entity.
     *
     * @Route("/{id}", name="task_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
//        $task = $em->getRepository(Task::class)->myFindOneById($id);

        $task = $em->getRepository(Task::class)->findOneById($id);

        $deleteForm = $this->createDeleteForm($task);

        return $this->render('task/show.html.twig', array(
            'task' => $task,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing task entity.
     *
     * @Route("/{id}/edit", name="task_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Task $task, FileUploader $fileUploader)
    {
        $deleteForm = $this->createDeleteForm($task);
        $editForm = $this->createForm('AppBundle\Form\TaskType', $task);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {

//            If user upload a new File, call service fileUploder and update picture
            if ($task->getPicture()->getFile() != null){
                $fileUploader->update($task->getPicture());
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('task_show', array('id' => $task->getId()));
        }

        return $this->render('task/edit.html.twig', array(
            'task' => $task,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a task entity.
     *
     * @Route("/{id}", name="task_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Task $task, FileUploader $fileUploader)
    {
        $form = $this->createDeleteForm($task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($task);


//            File is not mandatory in task, so we check if task is link with a picture
            if ($task->getPicture() != null){
                $fileUploader->remove($task->getPicture());
            }

            $em->flush();
        }

        return $this->redirectToRoute('task_index');
    }

    /**
     * Creates a form to delete a task entity.
     *
     * @param Task $task The task entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Task $task)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('task_delete', array('id' => $task->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
