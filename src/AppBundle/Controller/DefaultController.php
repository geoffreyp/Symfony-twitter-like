<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TwitterBundle\Entity\Message;
use TwitterBundle\Form\MessageType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $new_message = new Message();
        $message_form = $this->createForm(MessageType::class, $new_message);

        // replace this example code with whatever you need
        return $this->render('@App/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'message_form' => $message_form->createView()
        ]);
    }
}
