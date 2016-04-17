<?php

namespace AppBundle\Dto;

use AppBundle\Entity\Product as ProductEntity;
use JMS\Serializer\Annotation\Type;

class Product
{
    /**
     * @var integer
     * @Type("integer")
     */
    private $id;

    /**
     * @var string
     * @Type("string")
     */
    private $name;

    /**
     * @var float
     * @type("float")
     */
    private $price;

    /**
     * @param ProductEntity $entity
     * @return Product
     */
    public static function fromEntity(ProductEntity $entity) {
        $dto = new Product();
        $dto->setId($entity->getId());
        $dto->setName($entity->getName());
        $dto->setPrice($entity->getPrice());
        return $dto;
    }

    public static function fromEntitiesList(array $entities) {
        $dtoList = [];

        foreach ($entities as $entity) {
            $dtoList[] = static::fromEntity($entity);
        }

        return $dtoList;
    }

    public function toEntity() {
        $entity = new ProductEntity();
        $entity->setId($this->getId());
        $entity->setName($this->getName());
        $entity->setPrice($this->getPrice());
        return $entity;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

}