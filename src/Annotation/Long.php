<?php

namespace Wamania\ElasticSearch\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Guillaume Affringue
 */
final class Long extends AbstractNumeric implements AnnotationInterface
{

}
