<?php

namespace Wamania\ElasticSearch\Annotation;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 *
 * @author Guillaume Affringue
 */
final class Text
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $analyzer;

    /**
     * @var float
     */
    private $boost;

    /**
     * @var boolean
     */
    private $eagerGlobalOrdinals;

    /**
     * @var boolean
     */
    private $fielddata;

    /**
     * @var array
     */
    private $fielddataFrequencyFilter;

    /**
     * @var array
     */
    private $fields;

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
     * @var integer
     */
    private $positionIncrementGap;

    /**
     * @var boolean
     */
    private $store;

    /**
     * @var string
     */
    private $searchAnalyzer;

    /**
     * @var string
     */
    private $searchQuoteAnalyzer;

    /**
     * @var string
     */
    private $similarity;

    /**
     * @var string
     */
    private $termVector;

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
     * Get analyzer
     *
     * @return string
     */
    public function getAnalyzer()
    {
        return $this->analyzer;
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
     * Get eagerGlobalOrdinals
     *
     * @return boolean
     */
    public function getEagerGlobalOrdinals()
    {
        return $this->eagerGlobalOrdinals;
    }

    /**
     * Get fielddata
     *
     * @return boolean
     */
    public function getFielddata()
    {
        return $this->fielddata;
    }

    /**
     * Get fielddataFrequencyFilter
     *
     * @return array
     */
    public function getFielddataFrequencyFilter()
    {
        return $this->fielddataFrequencyFilter;
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
     * Get positionIncrementGap
     *
     * @return integer
     */
    public function getPositionIncrementGap()
    {
        return $this->positionIncrementGap;
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
     * Get searchAnalyzer
     *
     * @return string
     */
    public function getSearchAnalyzer()
    {
        return $this->searchAnalyzer;
    }

    /**
     * Get searchQuoteAnalyzer
     *
     * @return string
     */
    public function getSearchQuoteAnalyzer()
    {
        return $this->searchQuoteAnalyzer;
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
     * Get termVector
     *
     * @return string
     */
    public function getTermVector()
    {
        return $this->termVector;
    }
}
