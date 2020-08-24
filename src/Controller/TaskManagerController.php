<?php

namespace App\Controller;

// *Note to self: These are similar to React imports
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Task;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskManagerController extends AbstractController
{
    // These are annotations for routes in Symfony
    /**
     * @Route("/", name="task_manager")
     */
    public function index()
    {
        $tasks = $this->getDoctrine()->getRepository(Task::class)->findBy([], ['id'=>"DESC"]);
        return $this->render('task_manager/index.html.twig', [
            'controller_name' => 'TaskManagerController',
            'tasks' => $tasks,
        ]);
    }

    /**
     * @Route("/create", name="create_task", methods={"POST"})
     */
    public function create(Request $request)
    {
        $task_name = trim($request->request->get('task_name'));
        if(empty($task_name))
        return $this->redirectToRoute('task_manager');
        $entityManager = $this->redirectToRoute('task_manager');
        $entityManager = $this->getDoctrine()->getManager();
        $task = new Task;
        $task->setTaskName($task_name);
        // persist tells Doctrine to "manage" the object
        $entityManager->persist($task);
        // flush saves to Database
        $entityManager->flush(); 
        
        return $this->redirectToRoute('task_manager');
    }
    /**
     * @Route("/delete/{id}", name="task_delete")
     */
    public function delete(Task $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($id);
        $entityManager->flush();
        return $this->redirectToRoute('task_manager');
    }
    /**
     * @Route("/edit_incomplete/{id}", name="edit_incomplete")
     */
    public function switchIncomplete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);
        $task->setIncomplete(false);
        $task->setInProgress(false);
        $task->setComplete(false);
        $entityManager->flush();
        return $this->redirectToRoute('task_manager');
    }
    /**
     * @Route("/edit_inprogress/{id}", name="edit_inprogress")
     */
    public function switchInProgress($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);
        $task->setIncomplete(true);
        $task->setInProgress(true);
        $task->setComplete(false);
        $entityManager->flush();
        return $this->redirectToRoute('task_manager');
    }
    /**
     * @Route("/edit_complete/{id}", name="edit_complete")
     */
    public function switchComplete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);
        $task->setIncomplete(true);
        $task->setInProgress(false);
        $task->setComplete(true);
        $entityManager->flush();
        return $this->redirectToRoute('task_manager');
    }
    /**
     * @Route("/edit_task/{id}", name="todo_edit")
     */
    public function editAction($id, Request $request)
    {
        //fetch the data from db
        $todo = $this->getDoctrine()
            ->getRepository(Task::class)
            ->find($id);

        //create the edit form
        $form = $this->createFormBuilder($todo)
            ->add('TaskName', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Update Todo', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);

        //when everything is ok
        if ($form->isSubmitted() && $form->isValid()) {

            //fetch the data from form
            $name = $form['TaskName']->getData();


            $em = $this->getDoctrine()->getManager();
            $todo = $em->getRepository(Task::class)->find($id);

            //set the data
            $todo->setTaskName($name);

            //save data

            $em->persist($todo);
            $em->flush();


            //redirect back to the list index
            return $this->redirectToRoute('task_manager');
        }

        return $this->render('task_manager/edit.html.twig', array('form' => $form->createView()));
    }
}