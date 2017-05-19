<?php
namespace Wamania\YesAnotherElasticaBundle\Metadata;

use Metadata\PropertyMetadata as BasePropertyMetadata;

class PropertyMetadata extends BasePropertyMetadata implements FieldMetadataInterface
{
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