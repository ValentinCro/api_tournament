<?php

namespace UserBundle\Controller;

use AppBundle\Services\ProductService;
use JMS\Serializer\Serializer;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;


class UserController extends Controller
{
    /**
     * @var Serializer
     */
    protected $serializer;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->serializer = $this->get('jms_serializer');
    }

    /**
     * @Route("/user")
     * @Method({"GET"})
     */
    public function getUsersAction()
    {
        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findAll();
        $json = $this->serializer->serialize($data, 'json');
        return new Response($json);
    }


    /**
     * @Route("/user/{id}/id")
     * @Method({"GET"})
     */
    public function getUsersIdAction($id)
    {
        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('id' => $id));

        $json = $this->serializer->serialize($data, 'json');
        return new Response($json);
    }



    /**
     * @Route("/user/{login}/login")
     * @Method({"GET"})
     */
    public function getUsersLoginAction($login)
    {
        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('login' => $login));

        $json = $this->serializer->serialize($data, 'json');
        return new Response($json);
    }

    /**
     * @Route("/authenticate")
     * @Method({"POST"})
     */
    public function postAuthenticateAction(Request $request) {
        if ($request->get('password') != null && $request->get('userName')) {
            $pass = sha1($request->get('password'));
            $login = htmlspecialchars($request->get('userName'));
            $data = $this->getDoctrine()
                ->getRepository('UserBundle:User')
                ->findOneBy(array('userName' => $login, 'userPassword' => $pass));
            if (count($data) > 0) {
                $json = $this->serializer->serialize($data->getUserToken(), 'json');
                return new Response($json, 200);
            }
        }
        return new Response('', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/create/user")
     * @Method({"POST"})
     */
    public function postCreateUserAction(Request $request) {
        if ($request->get('password') != null && $request->get('userName')) {
            $pass = sha1($request->get('password'));
            $login = htmlspecialchars($request->get('userName'));
            $user = new User();
            $user->setUserName($login);
            $user->setUserPassword($pass);
            $user->setUserToken("");
            $user->setUserDate(new \DateTime());
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            return new Response('', Response::HTTP_OK);
        }
        return new Response('', Response::HTTP_BAD_REQUEST);
    }

}