<?php

namespace Wamania\ElasticSearch\Annotation;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 *
 * @author Guillaume Affringue
 */
final class Ip
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var float
     */
    protected $boost;

    /**
     * @var boolean
     */
    protected $docValues;

    /**
     * @var boolean
     */
    protected $includeInAll;

    /**
     * @var boolean
     */
    protected $index;

    /**
     * @var string
     */
    protected $nullValue;

    /**
     * @var boolean
     */
    protected $store;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $converter = new CamelCaseToSnakeCaseNameConverter();

        foreach ($options as $key => $value) {
            $property = $converter->normalize($key);
            if (!property_exists($this, $property)) {
                throw new \InvalidArgumentException(sprintf('Property "%s" does not exist', $property));
            }

            $this->$property = $value;
        }
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get boost
     *
     * @return float
     */
    public function getBoost()
    {
        return $this->boost;
    }

    /**
     * Get docValues
     *
     * @return boolean
     */
    public function getDocValues()
    {
        return $this->docValues;
    }

    /**
     * Get includeInAll
     *
     * @return boolean
     */
    public function getIncludeInAll()
    {
        return $this->includeInAll;
    }

    /**
     * Get index
     *
     * @return boolean
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Get nullValue
     *
     * @return string
     */
    public function getNullValue()
    {
        return $this->nullValue;
    }

    /**
     * Get store
     *
     * @return boolean
     */
    public function getStore()
    {
        return $this->store;
    }
}
