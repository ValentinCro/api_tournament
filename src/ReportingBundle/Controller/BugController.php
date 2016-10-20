<?php

namespace ReportingBundle\Controller;

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
use ReportingBundle\Entity\Bug;

class BugController extends Controller
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
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('ReportingBundle:Default:index.html.twig');
    }



    /**
     * @Route("/bug/send")
     * @Method({"POST", "OPTIONS"})
     */
    public function sendBugAction(Request $request)
    {
        $token = $request->headers->get("Authorization");

        /*Check token validity*/
        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }

        $body = $request->getContent();
        $bugDto = $this->serializer->deserialize($body, 'ReportingBundle\Dto\Bug', 'json');
        if ($bugDto != null) {

            $bug = new Bug();
            $bug->setAuthor($bugDto->getAuthor());
            $bug->setDate(new \DateTime());
            $bug->setDescription(htmlspecialchars($bugDto->getDescription()));
            $bug->setSubject(htmlspecialchars($bugDto->getSubject()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($bug);
            $em->flush();

            $json = $this->serializer->serialize($bug, 'json');
            return new Response($json);
        }
        return new Response('', Response::HTTP_BAD_REQUEST);
    }
}
