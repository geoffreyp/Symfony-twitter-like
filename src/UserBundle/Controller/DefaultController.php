<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * @Route("/add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        // Reste de la méthode qu'on avait déjà écrit
        if ($request->isMethod('POST')) {
            $pseudo = $request->query->get("pseudo");
            $mdp = $request->query->get("password");
            $user = new User();
            $user->setPseudo($pseudo);
            $user->setPassword(md5($mdp));

            // TODO WIP 

            $request->getSession()->getFlashBag()->add('notice', 'Votre compte est correctement créé');

            // Puis on redirige vers la page de visualisation de cettte annonce
            return $this->redirectToRoute('user_index', array('id' => $user->getId()));
        }


        return $this->render('@User/Default/inscription.html.twig');
    }
}

