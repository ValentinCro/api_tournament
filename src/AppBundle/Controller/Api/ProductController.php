<?php

namespace AppBundle\Controller\Api;

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

/**
 * @Route("/api/products")
 */
class ProductController extends Controller
{
    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var ProductService
     */
    protected $productService;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->serializer = $this->get('jms_serializer');
        $this->productService = $this->get('app.service.product');
    }

    /**
     * @Route("")
     * @Method({"GET"})
     * @Security("has_role('ROLE_USER')")
     * @ApiDoc(
     *     description="Get all products",
     *     statusCodes={
     *         200="Returned when successful",
     *         401="Returned when not authenticated",
     *         403="Returned when not authorized"
     *     }
     * )
     */
    public function getAllAction()
    {
        $products = $this->productService->getAllProducts();
        $json = $this->serializer->serialize($products, 'json');
        return new Response($json);
    }

    /**
     * @Route("/{id}")
     * @Method({"GET"})
     * @Security("has_role('ROLE_USER')")
     * @ApiDoc(
     *     description="Get one product",
     *     statusCodes={
     *         200="Returned when successful",
     *         401="Returned when not authenticated",
     *         404="Returned when not found",
     *         403="Returned when not authorized"
     *     }
     * )
     */
    public function getOneAction($id)
    {
        $product = $this->productService->getOneProduct($id);
        $json = $this->serializer->serialize($product, 'json');
        return new Response($json);
    }

    /**
     * @Route("")
     * @Method({"POST"})
     * @Security("has_role('ROLE_ADMIN')")
     * @ApiDoc(
     *     description="Create a product",
     *     statusCodes={
     *         201="Returned when successful",
     *         401="Returned when not authenticated",
     *         403="Returned when not authorized"
     *     }
     * )
     */
    public function createAction(Request $request)
    {
        $json = $request->getContent();
        $productDto = $this->serializer->deserialize($json, 'AppBundle\Dto\Product', 'json');
        $this->productService->createProduct($productDto);

        $json = $this->serializer->serialize($productDto, 'json');
        return new Response($json, 201);
    }

    /**
     * @Route("/{id}")
     * @Method({"DELETE"})
     * @Security("has_role('ROLE_ADMIN')")
     * @ApiDoc(
     *     description="Delete a product",
     *     statusCodes={
     *         204="Returned when successful",
     *         401="Returned when not authenticated",
     *         403="Returned when not authorized"
     *     }
     * )
     */
    public function deleteAction($id)
    {
        $this->productService->deleteProduct($id);
        return new Response('', 204);
    }

    /**
     * @Route("/{id}")
     * @Method({"POST"})
     * @Security("has_role('ROLE_ADMIN')")
     * @ApiDoc(
     *     description="Update a product",
     *     statusCodes={
     *         200="Returned when successful",
     *         401="Returned when not authenticated",
     *         403="Returned when not authorized"
     *     }
     * )
     */
    public function updateAction($id, Request $request)
    {
        $json = $request->getContent();
        $productDto = $this->serializer->deserialize($json, 'AppBundle\Dto\Product', 'json');
        $this->productService->updateProduct($id, $productDto);

        $json = $this->serializer->serialize($productDto, 'json');
        return new Response($json);
    }
}
