<?php
namespace Wamania\YesAnotherElasticaBundle\Metadata;

class AnnotationMetadata implements FieldMetadataInterface
{
    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $fieldName;

    /**
     * @var string
     */
    public $fieldType;

    /**
     * @var string
     */
    public $fieldMapping = null;

    /**
     * @var boolean
     */
    public $isId = false;

    /**
     * @var string
     */
    public $target;
}