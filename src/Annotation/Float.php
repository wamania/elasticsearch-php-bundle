<?php

namespace Wamania\ElasticSearch\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Guillaume Affringue
 */
final class Float extends AbstractNumeric implements AnnotationInterface
{

}
