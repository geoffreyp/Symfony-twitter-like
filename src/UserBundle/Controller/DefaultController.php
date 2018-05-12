<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Form\UserType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="user_index")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction()
    {
        return $this->render('@User/Default/index.html.twig');
    }

    /**
     * @Route("/create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function addAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $user->setSalt(date("Y-m-d_H:i:s"));
            $user->setRoles(array('ROLE_USER'));
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Votre compte est correctement créé');

            return $this->redirectToRoute('user_index', array('id' => $user->getId()));

        }

        return $this->render('@User/Default/inscription.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

