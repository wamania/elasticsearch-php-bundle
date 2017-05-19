<?php

namespace Wamania\YesAnotherElasticaBundle\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Guillaume Affringue
 */
final class Integer extends AbstractNumeric implements AnnotationInterface
{

}
