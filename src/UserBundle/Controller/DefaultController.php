<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="user_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('@User/Default/index.html.twig');
    }

    /**
     * @Route("/create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $user = new User();

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user);
        $formBuilder
            ->add('pseudo',      TextType::class)
            ->add('password',    PasswordType::class)
            ->add('save',      SubmitType::class)
        ;

        $form = $formBuilder->getForm();

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Votre compte est correctement créé');

                return $this->redirectToRoute('user_index', array('id' => $user->getId()));
            }
        }

        return $this->render('@User/Default/inscription.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

