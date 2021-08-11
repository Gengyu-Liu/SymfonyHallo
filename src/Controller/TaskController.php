<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\TaskType;

class TaskController extends AbstractController
{
    #[Route('/task/new', name:'task_new')]
    public function new(Request $request): Response
    {
        // creates a task object and initializes some data for this example
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));

        //use the createFormBuilder() helper
        /*
        $form = $this->createFormBuilder($task)
            ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();
        */
        
        //use the createForm() helper 
        $form = $this->createForm(TaskType::class, $task);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();
            
            $this->addFlash('success_task', serialize($task));
            return $this->redirectToRoute('task_success');
        }
        
        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/task/success', name:'task_success')]
    public function success(): Response{
    $task = unserialize($this->get('session')->getFlashBag()->get('success_task')[0]);   
    return $this->render('task/success.html.twig',[
        'task' => $task->getTask(),
        'taskDate' => $task->getDueDate()->format('Y-m-d'),
    ]);
    }
}