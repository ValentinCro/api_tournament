<?php

namespace AppBundle\Services;

use AppBundle\Dto\Product as ProductDto;
use AppBundle\Exception\ProductNotFoundException;
use Symfony\Bridge\Monolog\Logger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class ProductService
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var EntityManager
     */
    protected $entiryManager;

    /**
     * @var EntityRepository
     */
    protected $productRepository;

    public function __construct(Logger $logger, EntityManager $entityManager)
    {
        $this->logger = $logger;
        $this->entiryManager = $entityManager;
        $this->productRepository = $entityManager->getRepository('AppBundle:Product');
    }

    /**
     * @return array<ProductDto>
     */
    public function getAllProducts() {
        $allProductEntities = $this->productRepository->findAll();
        return ProductDto::fromEntitiesList($allProductEntities);
    }

    /**
     * @param $id
     * @return ProductDto
     */
    public function getOneProduct($id) {
        $productEntity = $this->productRepository->find($id);
        if ($productEntity === null) {
            throw new ProductNotFoundException();
        }
        return ProductDto::fromEntity($productEntity);
    }

    /**
     * @param ProductDto $productDto
     */
    public function createProduct(ProductDto $productDto) {
        $productEntity = $productDto->toEntity();
        $this->entiryManager->persist($productEntity);
        $this->entiryManager->flush();
        $productDto->setId($productEntity->getId());
    }

    /**
     * @param $id
     * @throws \Doctrine\ORM\ORMException
     */
    public function deleteProduct($id) {
        $productReference = $this->entiryManager->getReference('AppBundle:Product', $id);
        $this->entiryManager->remove($productReference);
        $this->entiryManager->flush();
    }

    /**
     * @param $id
     * @param ProductDto $product
     */
    public function updateProduct($id, ProductDto $product) {
        $product->setId($id);
        $productEntity = $product->toEntity();
        $this->entiryManager->merge($productEntity);
        $this->entiryManager->flush();
    }
}