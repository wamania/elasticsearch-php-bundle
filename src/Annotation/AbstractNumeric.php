<?php

namespace Wamania\ElasticSearch\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Guillaume Affringue
 */
abstract class AbstractNumeric extends Annotation
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var boolean
     */
    public $coerce;

    /**
     * @var float
     */
    public $boost;

    /**
     * @var boolean
     */
    public $docValues;

    /**
     * @var boolean
     */
    public $ignore_malformed;

    /**
     * @var boolean
     */
    public $include_in_all;

    /**
     * @var boolean
     */
    public $index;

    /**
     * @var string
     */
    public $null_value;

    /**
     * @var boolean
     */
    public $store;
}
