<?php

namespace App\Controller;

// *Note to self: These are similar to React imports
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Task;

class TaskManagerController extends AbstractController
{
    // These are annotations for routes in Symfony
    /**
     * @Route("/", name="task_manager")
     */
    public function index()
    {
        return $this->render('task_manager/index.html.twig', [
            'controller_name' => 'TaskManagerController',
        ]);
    }

    /**
     * @Route("/create", name="create_task", methods={"POST"})
     */
    public function create(Request $request)
    {
        $task_name = trim($request->request->get('title'));
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
}
