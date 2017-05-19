<?php

namespace Wamania\YesAnotherElasticaBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Guillaume Affringue
 */
final class Keyword extends Annotation implements AnnotationInterface
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
    public $docValues;

    /**
     * @var boolean
     */
    public $eager_global_ordinals;

    /**
     * @var array
     */
    public $fields;

    /**
     * @var integer
     */
    public $ignore_above;

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
    public $index_options;

    /**
     * @var boolean
     */
    public $norms;

    /**
     * @var string
     */
    public $null_value;

    /**
     * @var boolean
     */
    public $store;

    /**
     * @var string
     */
    public $similarity;

    /**
     * @var string
     */
    public $normalizer;
}
