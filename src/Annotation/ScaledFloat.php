<?php

namespace Wamania\ElasticSearch\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Guillaume Affringue
 */
final class ScaledFloat extends AbstractNumeric implements AnnotationInterface
{
    /**
     * @var float
     */
    public $scaling_factor;
}
