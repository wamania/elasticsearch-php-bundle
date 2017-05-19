<?php

namespace Wamania\ElasticSearch\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Guillaume Affringue
 */
final class Date extends Annotation implements AnnotationInterface
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var float
     */
    public $boost;

    /**
     * @var boolean
     */
    public $doc_values;

    /**
     * @var string
     */
    public $format;

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
