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
     * @Route("/edit_task{id}", name="edit_task")
     */
    public function updateTask(Request $request, $id)
    {
        $task_name = trim($request->request->get('new_task_name'));
        if(empty($task_name))
        return $this->redirectToRoute('task_manager');
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);
        $task->setTaskName('new_task_name');
        $entityManager->flush();
        dump($task);
        return $this->redirectToRoute('task_manager');
        
    }
}