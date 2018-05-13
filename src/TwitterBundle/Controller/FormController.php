<?php

namespace TwitterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TwitterBundle\Entity\Message;
use TwitterBundle\Form\MessageType;

class FormController extends Controller
{
    /**
     * @Route("/create", name="create_form")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $message->setCreatedAt(new \DateTime());
            $message->setUser($request->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'The message is created with success !');
        }
        return $this->redirectToRoute('homepage');
    }
}
