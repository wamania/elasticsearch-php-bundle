<?php

namespace Wamania\ElasticSearch\Metadata\Driver;

use Doctrine\Common\Annotations\Reader;
use Metadata\Driver\DriverInterface;
use Metadata\ClassMetadata;
use Wamania\ElasticSearch\Annotation\AnnotationInterface;
use Wamania\ElasticSearch\Metadata\PropertyMetadata;
use Wamania\ElasticSearch\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Wamania\ElasticSearch\Annotation\Id;

class AnnotationDriver implements DriverInterface
{
    private $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function loadMetadataForClass(\ReflectionClass $class)
    {
        $classMetadata = new ClassMetadata($class->name);
        $classMetadata->fileResources[] = $class->getFilename();

        $propertiesMetadata = array();
        $propertiesAnnotations = array();

        $nameConverter = new CamelCaseToSnakeCaseNameConverter();

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
                    $refl = new \ReflectionClass($annotation);
                    $keyName = $nameConverter->normalize($refl->getShortName());

                    $fieldMapping = get_object_vars($annotation);

                    if (empty($fieldMapping['name'])) {
                        $name = $nameConverter->normalize($propertyMetadata->name);
                    } else {
                        $name = $fieldMapping['name'];
                    }

                    if ($keyName == 'nested' || $keyName == 'object') {
                        $propertyMetadata->target = $fieldMapping['target'];
                        unset($fieldMapping['target']);
                    }

                    unset($fieldMapping['name']);

                    $propertyMetadata->fieldName = $name;
                    $propertyMetadata->fieldType = $keyName;
                    $propertyMetadata->fieldMapping = $fieldMapping;

                } else if ($annotation instanceof Id) {
                    $propertyMetadata->isId = true;
                }
            }

            $classMetadata->addPropertyMetadata($propertyMetadata);
        }


        return $classMetadata;
    }
}
