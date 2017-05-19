<?php

namespace Wamania\YesAnotherElasticaBundle\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Guillaume Affringue
 */
final class Double extends AbstractNumeric implements AnnotationInterface
{

}
