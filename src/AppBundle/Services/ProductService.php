<?php

namespace AppBundle\Services;

use AppBundle\Dto\ConstraintViolationError;
use AppBundle\Dto\Product as ProductDto;
use AppBundle\Exception\ConstraintViolationException;
use AppBundle\Exception\ProductNotFoundException;
use JMS\Serializer\Serializer;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var Serializer
     */
    protected $serializer;

    public function __construct(Logger $logger, EntityManager $entityManager, ValidatorInterface $validator, Serializer $serializer)
    {
        $this->logger = $logger;
        $this->entiryManager = $entityManager;
        $this->productRepository = $entityManager->getRepository('AppBundle:Product');
        $this->validator = $validator;
        $this->serializer = $serializer;
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
     * @throws ConstraintViolationException
     */
    public function createProduct(ProductDto $productDto) {
        $productEntity = $productDto->toEntity();

        $constraintViolationList = $this->validator->validate($productEntity);
        if ($constraintViolationList->count() > 0) {
            $constraintViolationDtoList = ConstraintViolationError::fromConstraintViolationList($constraintViolationList);
            throw ConstraintViolationException::fromConstraintViolationErrorList($constraintViolationDtoList, $this->serializer);
        }

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
     * @throws ConstraintViolationException
     */
    public function updateProduct($id, ProductDto $product) {
        $product->setId($id);
        $productEntity = $product->toEntity();

        $constraintViolationList = $this->validator->validate($productEntity);
        if ($constraintViolationList->count() > 0) {
            $constraintViolationDtoList = ConstraintViolationError::fromConstraintViolationList($constraintViolationList);
            throw ConstraintViolationException::fromConstraintViolationErrorList($constraintViolationDtoList, $this->serializer);
        }

        $this->entiryManager->merge($productEntity);
        $this->entiryManager->flush();
    }
}