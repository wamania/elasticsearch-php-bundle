<?php

namespace Wamania\ElasticSearch\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Guillaume Affringue
 */
final class Text extends Annotation implements AnnotationInterface
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $analyzer;

    /**
     * @var float
     */
    public $boost;

    /**
     * @var boolean
     */
    public $eager_global_ordinals;

    /**
     * @var boolean
     */
    public $fielddata;

    /**
     * @var array
     */
    public $fielddata_frequency_filter;

    /**
     * @var array
     */
    public $fields;

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
     * @var integer
     */
    public $position_increment_gap;

    /**
     * @var boolean
     */
    public $store;

    /**
     * @var string
     */
    public $search_analyzer;

    /**
     * @var string
     */
    public $search_quote_analyzer;

    /**
     * @var string
     */
    public $similarity;

    /**
     * @var string
     */
    public $termVector;
}
