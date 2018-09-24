<?php

namespace App\Controller;

use App\Entity\Meetings;
use App\Entity\User;
use App\Form\MeetingType;
use App\Entity\Users;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Created by PhpStorm.
 * User: kristina
 * Date: 9/24/18
 * Time: 4:22 PM
 */



class MeetingsController extends Controller {

    /**
     * @param Request $request
     * @return Response
     */
    public function createMeetings(Request $request): Response {

        $meetings = new Meetings();

        $form = $this->createForm(MeetingType::class, $meetings);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $meetings = $form->getData();

             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($meetings);
             $entityManager->flush();

             return $this->redirectToRoute('todo_list');

        }

        return $this->render('todo/meetings.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function viewMeetings(Request $request): Response {

//        $meeting = new Meetings();
//        $meeting->getUsers();




      $meeting = $this->getDoctrine()->getRepository(Meetings::class)->findAll();


        return $this->render('todo/view_meetings.html.twig', [
            'meeting' => $meeting,

        ]);


    }

}