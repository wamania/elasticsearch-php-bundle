<?php

namespace Wamania\ElasticSearch\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Guillaume Affringue
 */
final class Byte extends AbstractNumeric implements AnnotationInterface
{

}
