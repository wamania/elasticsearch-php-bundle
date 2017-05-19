<?php
namespace Wamania\ElasticSearch\Metadata;

use Metadata\PropertyMetadata as BasePropertyMetadata;

class PropertyMetadata extends BasePropertyMetadata
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