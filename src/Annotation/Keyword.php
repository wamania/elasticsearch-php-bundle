<?php

namespace Wamania\ElasticSearch\Annotation;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 *
 * @author Guillaume Affringue
 */
final class Keyword
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $boost;

    /**
     * @var boolean
     */
    private $docValues;

    /**
     * @var boolean
     */
    private $eagerGlobalOrdinals;

    /**
     * @var array
     */
    private $fields;

    /**
     * @var integer
     */
    private $ignoreAbove;

    /**
     * @var boolean
     */
    private $includeInAll;

    /**
     * @var boolean
     */
    private $index;

    /**
     * @var string
     */
    private $indexOptions;

    /**
     * @var boolean
     */
    private $norms;

    /**
     * @var string
     */
    private $nullValue;

    /**
     * @var boolean
     */
    private $store;

    /**
     * @var string
     */
    private $similarity;

    /**
     * @var string
     */
    private $normalizer;

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
     * Get eagerGlobalOrdinals
     *
     * @return boolean
     */
    public function getEagerGlobalOrdinals()
    {
        return $this->eagerGlobalOrdinals;
    }

    /**
     * Get fields
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Get ignoreAbove
     *
     * @return integer
     */
    public function getIgnoreAbove()
    {
        return $this->ignoreAbove;
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
     * Get indexOptions
     *
     * @return string
     */
    public function getIndexOptions()
    {
        return $this->indexOptions;
    }

    /**
     * Get norms
     *
     * @return boolean
     */
    public function getNorms()
    {
        return $this->norms;
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

    /**
     * Get similarity
     *
     * @return string
     */
    public function getSimilarity()
    {
        return $this->similarity;
    }

    /**
     * Get normalizer
     *
     * @return string
     */
    public function getNormalizer()
    {
        return $this->normalizer;
    }
}
