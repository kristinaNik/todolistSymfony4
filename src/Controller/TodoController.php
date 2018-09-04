<?php

namespace App\Controller;

use App\Entity\Todo;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class TodoController extends Controller
{

    /**
     * @Route("/", name="todo_list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request): Response
    {
        $form =  $request->request->get('form');

        $search = $this->getDoctrine()->getRepository(Todo::class)->getSearchParams($form['number'], $form['name'], $form['category']);

        $form = $this->createFormBuilder(null)
            ->setAction($this->generateUrl('todo_list'))
            ->setMethod('POST')
            ->add('number', NumberType::class, array(
                'required'   => false,
                'attr' => array('placeholder' => 'Todo number')
            ))
            ->add('name', TextType::class, array(
                'required'   => false,
                'attr' => array('placeholder' => 'Todo name')
            ))
            ->add('category', TextType::class, array(
                'required'   => false,
                'attr' => array('placeholder' => 'Todo category')
            ))
            ->getForm();



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form['name']->getData();


            return $this->render('todo/index.html.twig', array(
                'form' => $form->createView(),
                'searches' => $search,

            ));


        }


        // replace this example code with whatever you need
        return $this->render('todo/index.html.twig', array(
            'form' => $form->createView(),
            'searches' => $search
        ));
          
    }

    /**
     * @Route("/todo/create", name="todo_create")
     */
    public function createAction(Request $request)
    {

        var_dump($request->request->get('page'));
        $todo = new Todo;

        $form = $this->createFormBuilder($todo)
                ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom: 15px')))
                ->add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom: 15px')))
                ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom: 15px')))
                ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Normal'=> 'Normal', 'High' => 'High' )), array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom: 15px')))
                ->add('due_date', DateTimeType::class, array('attr' => array('style' => 'margin-bottom: 15px')))
                ->add('save', SubmitType::class, array('label' => 'Create Todo', 'attr' => array('class' => 'btn btn-primary')))

                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $due_date = $form['due_date']->getData();

            $now = new\DateTime('now');

            $todo->setName($name);
            $todo->setCategory($category);
            $todo->setDescription($description);
            $todo->setPriority($priority);
            $todo->setDueDate($due_date);
            $todo->setCreateDate($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();

            $this->addFlash(
                'notice',
                'Todo Added'
            );
            return $this->redirectToRoute('todo_list');

        }

        // replace this example code with whatever you need
        return $this->render('todo/create.html.twig', array(
            'form' => $form->createView()
        ));
           
    }

    /**
     * @Route("/todo/edit/{id}", name="todo_edit")
     */
    public function editAction($id, Request $request)
    {
        $todo = $this->getDoctrine()
                ->getRepository('App:Todo')
                ->find($id);


        $now = new\DateTime('now');

        $todo->setName($todo->getName());
        $todo->setCategory($todo->getCategory());
        $todo->setDescription($todo->getDescription());
        $todo->setPriority($todo->getPriority());
        $todo->setDueDate($todo->getDueDate());
        $todo->setCreateDate($now);

        $form = $this->createFormBuilder($todo)
                ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom: 15px')))
                ->add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom: 15px')))
                ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom: 15px')))
                ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Normal'=> 'Normal', 'High' => 'High' )), array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom: 15px')))
                ->add('due_date', DateTimeType::class, array('attr' => array('style' => 'margin-bottom: 15px')))
                ->add('save', SubmitType::class, array('label' => 'Update Todo', 'attr' => array('class' => 'btn btn-primary')))

                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $due_date = $form['due_date']->getData();

         

            $em = $this->getDoctrine()->getManager();

            $todo = $em->getRepository('App:Todo')->find($id);

            $todo->setName($name);
            $todo->setCategory($category);
            $todo->setDescription($description);
            $todo->setPriority($priority);
            $todo->setDueDate($due_date);
            $todo->setCreateDate($now);

            $em->flush();

            $this->addFlash(
                'notice',
                'Todo Updated'
            );

            return $this->redirectToRoute('todo_list');
        }

        // replace this example code with whatever you need
        return $this->render('todo/edit.html.twig', array(
            'todo' => $todo,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/todo/details/{id}", name="todo_details")
     */
    public function detailsAction($id)
    {
        $todo = $this->getDoctrine()
                ->getRepository('App:Todo')
                ->find($id);


        // replace this example code with whatever you need
        return $this->render('todo/details.html.twig', array(
            'todo' => $todo
        ));

    }

    /**
     * @Route("/todo/delete/{id}", name="todo_delete")
     */
    public function deleteAction($id)
    {
        $todo = $this->getDoctrine()
                ->getRepository('App:Todo')
                ->find($id);

        $em = $this->getDoctrine()->getManager();
        $todo = $em->getRepository('App:Todo')->find($id);


        $em->remove($todo);
        $em->flush();

        $this->addFlash(
                'notice',
                'Todo Deleted'
            );

        return $this->redirectToRoute('todo_list');

    }


}
