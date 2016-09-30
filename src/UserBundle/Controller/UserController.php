<?php

namespace UserBundle\Controller;

use AppBundle\Services\ProductService;
use JMS\Serializer\DeserializationContext;
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
use UserBundle\Dto\UserLogin;


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
     * @Route("/users")
     * @Method({"GET"})
     */
    public function getUsersAction()
    {
        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findAll();
        $users = array();
        foreach ($data as $user) {
            $tmp = new \UserBundle\Dto\User();
            $tmp->entityToDto($user);
            array_push($users, $tmp);
        }
        $json = $this->serializer->serialize($users, 'json');
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

        $user = new \UserBundle\Dto\User();
        $user->entityToDto($data);
        $json = $this->serializer->serialize($user, 'json');
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
            ->findOneBy(array('name' => $login));
        if ($data != null) {
            $user = new \UserBundle\Dto\User();
            $user->entityToDto($data);
            $json = $this->serializer->serialize($user, 'json');
            return new Response($json);
        }
        return new Response('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route("/authenticate")
     * @Method({"POST"})
     */
    public function postAuthenticateAction(Request $request) {
        $body = $request->getContent();
        $user = $this->serializer->deserialize($body, 'UserBundle\Dto\UserLogin', 'json');
        if ($user != null) {
            $pass = sha1($user->getUserPassword());
            $login = htmlspecialchars($user->getUserName());
            $data = $this->getDoctrine()
                ->getRepository('UserBundle:User')
                ->findOneBy(array('name' => $login, 'password' => $pass));
            if (count($data) > 0) {
                $now = new \DateTime();
                $diff = $now->diff($data->getTokenValidityDate());
                $hours = $diff->h;
                $hours = $hours + ($diff->days*24);

                if ($hours > 8) {
                    $token = bin2hex(openssl_random_pseudo_bytes(16));
                    $data->setToken($token);
                    $data->setTokenValidityDate(new \DateTime());
                    $this->getDoctrine()->getManager()->persist($data);
                    $this->getDoctrine()->getManager()->flush();
                    $json = $this->serializer->serialize($data->getToken(), 'json');
                } else {
                    $json = $this->serializer->serialize($data->getToken(), 'json');
                }
                return new Response($json, 200);
            }
            return new Response('', Response::HTTP_NOT_FOUND);
        }
        return new Response('', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/create/user")
     * @Method({"POST"})
     */
    public function postCreateUserAction(Request $request) {
        $body = $request->getContent();
        $user = $this->serializer->deserialize($body, 'UserBundle\Dto\UserLogin', 'json');
        if ($user != null) {
            $pass = sha1($user->getUserPassword('password'));
            $login = htmlspecialchars($user->getUserName('userName'));
            $user = new User();
            $user->setName($login);
            $user->setPassword($pass);
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            $user->setToken($token);
            $user->setDate(new \DateTime());
            $user->setTokenValidityDate(new \DateTime());
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            return new Response($this->serializer->serialize($token, 'json'), Response::HTTP_OK);
        }
        return new Response('', Response::HTTP_BAD_REQUEST);
    }

}