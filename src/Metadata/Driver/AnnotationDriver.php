<?php

namespace Wamania\YesAnotherElasticaBundle\Metadata\Driver;

use Doctrine\Common\Annotations\Reader;
use Metadata\Driver\DriverInterface;
use Metadata\ClassMetadata;
use Wamania\ElasticSearch\Annotation\AnnotationInterface;
use Wamania\ElasticSearch\Metadata\PropertyMetadata;
use Wamania\ElasticSearch\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Wamania\ElasticSearch\Annotation\Id;
use Wamania\ElasticSearch\Exception\NoNameException;
use Wamania\ElasticSearch\Metadata\AnnotationMetadata;
use Wamania\ElasticSearch\Metadata\FieldMetadataInterface;

class AnnotationDriver implements DriverInterface
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * Constructor
     *
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Load Metadata for class
     *
     * {@inheritDoc}
     * @see \Metadata\Driver\DriverInterface::loadMetadataForClass()
     */
    public function loadMetadataForClass(\ReflectionClass $class)
    {
        $classMetadata = new ClassMetadata($class->name);
        $classMetadata->fileResources[] = $class->getFilename();

        $propertiesMetadata = array();
        $propertiesAnnotations = array();



        // Class
        foreach ($class->getProperties() as $property) {
            if ($property->class !== $class->name || (isset($property->info) && $property->info['class'] !== $class->name)) {
                continue;
            }
            $propertiesMetadata[] = new PropertyMetadata($class->name, $property->getName());
            $propertiesAnnotations[] = $this->reader->getPropertyAnnotations($property);
        }

        // methods

        // properties
        foreach ($propertiesMetadata as $propertyKey => $propertyMetadata) {

            $propertyAnnotations = $propertiesAnnotations[$propertyKey];

            foreach ($propertyAnnotations as $annotation) {
                if ($annotation instanceof AnnotationInterface) {
                    $this->propertyAnnotation($propertyMetadata, $annotation);

                } else if ($annotation instanceof Id) {
                    $propertyMetadata->isId = true;
                }
            }

            $classMetadata->addPropertyMetadata($propertyMetadata);
        }

        return $classMetadata;
    }

    /**
     * Fill propertyMetadata with annotation infos
     *
     * @param PropertyMetadata $propertyMetadata
     * @param AnnotationInterface $annotation
     * @throws NoNameException
     */
    private function propertyAnnotation(FieldMetadataInterface $propertyMetadata, AnnotationInterface $annotation)
    {
        $nameConverter = new CamelCaseToSnakeCaseNameConverter();

        $refl = new \ReflectionClass($annotation);
        $keyName = $nameConverter->normalize($refl->getShortName());

        $fieldMapping = $this->annotationToArray($annotation);

        if (empty($fieldMapping['name'])) {
            $name = $nameConverter->normalize($propertyMetadata->name);
        } else {
            $name = $fieldMapping['name'];
        }

        if ($keyName == 'nested' || $keyName == 'object') {
            $propertyMetadata->target = $fieldMapping['target'];
            unset($fieldMapping['target']);
        }

        if (!empty($fieldMapping['fields'])) {
            $fields = [];
            foreach ($fieldMapping['fields'] as $field) {
                if (empty($field->name)) {
                    throw new NoNameException('Fields has no name in '.$name);
                }
                $fieldMetadata = new AnnotationMetadata($field->name);
                $this->propertyAnnotation($fieldMetadata, $field);
                $fields[$field->name] = $fieldMetadata;
            }
            $fieldMapping['fields'] = $fields;
        }

        unset($fieldMapping['name']);

        $propertyMetadata->fieldName = $name;
        $propertyMetadata->fieldType = $keyName;
        $propertyMetadata->fieldMapping = $fieldMapping;
    }

    /**
     * Annotation to array
     *
     * @param AnnotationInterface $annotation
     * @return array
     */
    private function annotationToArray(AnnotationInterface $annotation)
    {
        return get_object_vars($annotation);
    }
}
