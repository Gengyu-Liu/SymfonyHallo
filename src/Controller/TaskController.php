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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskController extends AbstractController
{
    #[Route('/task/new', name:'task_new')]
    public function new(Request $request): Response
    {
        // creates a task object and initializes some data for this example
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('now'));

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
    $url = $this->generateUrl('task_new', [], UrlGeneratorInterface::ABSOLUTE_URL);
    return $this->render('task/success.html.twig',[
        'task' => $task->getTask(),
        'taskTime' => $task->getDueDate()->format('Y-m-d H:i:s'),
        'url' => $url,
    ]);
    }
    
    #[Route('/task', name:'task')]
    public function task(ValidatorInterface $validator): Response {
        $task = new task();
        $task->setTask('Write a blog post');
//        $task->setDueDate(new \DateTime('tomorrow'));

        $errors = $validator->validate($task);

        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        return new Response('The task is valid! Yes!');
    }

}