<?php
namespace Wamania\ElasticSearch;

use Metadata\MetadataFactory;
use Wamania\ElasticSearch\Exception\NoTargetException;

class MappingGenerator
{
    /**
     * @var MetadataFactory
     */
    private $metadataFactory;

    /**
     * Constructor
     *
     * @param MetadataFactory $factory
     */
    public function __construct(MetadataFactory $metadataFactory)
    {
        $this->metadataFactory = $metadataFactory;
    }

    /**
     * Explore
     *
     * @param string $className
     */
    public function generate($className)
    {
        $mapping = $this->map($className);

        return $mapping;
    }

    private function map($className)
    {
        $metadata = $this->metadataFactory->getMetadataForClass($className);

        $classMetadata = $metadata->getRootClassMetadata();
        $namespace = $classMetadata->reflection->getNamespaceName();

        $mapping = [];

        foreach ($classMetadata->propertyMetadata as $propertyMetadata) {

            switch($propertyMetadata->fieldType) {
                case 'nested':
                case 'object':
                    $target = $propertyMetadata->target;

                    if (null === $target) {
                        throw new NoTargetException('Field "'.$propertyMetadata->fieldName.'" with relation "'.$propertyMetadata->fieldType.'" has no target');
                    }

                    // namespace resolv
                    if (!class_exists($target)) {
                        $target = $namespace.'\\'.$target;
                    }

                    $mapping[$propertyMetadata->fieldName] = array_merge([
                        'type' => $propertyMetadata->fieldType,
                        'properties' => $this->map($target)
                    ], array_filter($propertyMetadata->fieldMapping));
                    break;

                default:

                    if (isset($propertyMetadata->fieldMapping['fields'])) {
                        $fields = [];
                        foreach ($propertyMetadata->fieldMapping['fields'] as $name => $field) {
                            $fields[$name] = array_merge(
                                ['type' => $field->fieldType],
                                array_filter($field->fieldMapping)
                            );
                        }
                        $propertyMetadata->fieldMapping['fields'] = $fields;
                    }

                    $mapping[$propertyMetadata->fieldName] = array_merge(
                        ['type' => $propertyMetadata->fieldType],
                        array_filter($propertyMetadata->fieldMapping)
                    );
                    break;
            }

        }

        return $mapping;
    }
}