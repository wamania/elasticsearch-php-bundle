<?php

namespace Wamania\ElasticSearch\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Guillaume Affringue
 */
final class Nested extends Annotation implements AnnotationInterface
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $target;

    /**
     * @var boolean
     */
    public $dynamic;

    /**
     * @var boolean
     */
    public $include_in_all;
}
