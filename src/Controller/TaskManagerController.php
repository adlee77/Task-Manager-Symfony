<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TaskManagerController extends AbstractController
{
    /**
     * @Route("/task/manager", name="task_manager")
     */
    public function index()
    {
        return $this->render('task_manager/index.html.twig', [
            'controller_name' => 'TaskManagerController',
        ]);
    }
}
