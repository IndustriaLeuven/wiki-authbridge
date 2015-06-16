<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class AppController extends Controller
{
    /**
     * @Template
     */
    public function profileAction()
    {
        return array('user'=>$this->getUser());
    }

    /**
     * @Template
     */
    public function wikiNameAction(Request $request)
    {
        $user = $this->getUser();
        /* @var $user User */
        if($user->getWikiName() !== null) {
            $this->get('braincrafted_bootstrap.flash')->error('You can only set your wiki name once.');
            return $this->redirectToRoute('user_profile');
        }

        $form = $this->createForm(new UserType(), $this->getUser());

        $form->handleRequest($request);

        if($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('braincrafted_bootstrap.flash')->success('Wiki name saved.');
            return $this->redirectToRoute('user_profile');
        }

        return array(
            'form' => $form->createView()
        );
    }

    public function wikiLoginAction($wikiSecret, $wikiTarget)
    {
        $user = $this->getUser();
        /* @var $user User */
        if($user->getWikiName() === null) {
            $this->get('braincrafted_bootstrap.flash')->error('You have to set a wiki username before you can login.');
            return $this->redirectToRoute('user_wikiname');
        }

        $time = time();

        $data = 'user='.urlencode($user->getWikiName()).
            '&name='.urlencode($user->getRealname()).
            '&time='.$time;

        $signature = hash_hmac("sha256", $data, $wikiSecret);

        $link = $wikiTarget.'?'.
            $data.
            '&sign='.$signature;

        return $this->redirect($link);
    }
}