<?php

namespace Wamania\YesAnotherElasticaBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Guillaume Affringue
 */
final class Object extends Annotation implements AnnotationInterface
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
    public $enabled;

    /**
     * @var boolean
     */
    public $include_in_all;
}
