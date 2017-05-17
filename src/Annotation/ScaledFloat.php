<?php

namespace Wamania\ElasticSearch\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 *
 * @author Guillaume Affringue
 */
final class ScaledFloat extends AbstractNumeric
{
    /**
     * @var float
     */
    protected $scalingFactor;

    /**
     * Get scalingFactor
     *
     * @return float
     */
    public function getScalingFactor()
    {
        return $this->scalingFactor;
    }
}
