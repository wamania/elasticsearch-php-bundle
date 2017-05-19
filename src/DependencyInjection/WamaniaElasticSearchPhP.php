<?php

namespace EuropeanSourcing\SearchEngineBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\VarDumper\VarDumper;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class EuropeanSourcingSearchEngineExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $loaderXml = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loaderXml->load('elastica.xml');

        $this->loadIndexes($config['indexes'], $config['types'], $container);

        $container->setParameter('indexes.langs', $config['indexes']);
        $container->setParameter('projects', $config['projects']);
    }

    /**
     * Loads the configured indexes.
     *
     * @param array            $indexes   An array of indexes configurations
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    private function loadIndexes(array $indexes, array $types, ContainerBuilder $container)
    {
        foreach ($indexes as $lang => $indexName) {

            foreach ($types as $typeName => $typeConfig) {

                $clientId = sprintf('es_search_engine.client');
                $clientDef = new DefinitionDecorator('fos_elastica.client.default');
                $clientDef->setClass('EuropeanSourcing\SearchEngineBundle\Elastica\Client');
                $container->setDefinition($clientId, $clientDef);

                $indexId = sprintf('es_search_engine.index.%s', $indexName);
                $indexDef = new DefinitionDecorator(sprintf('fos_elastica.index.%s', $indexName));
                $indexDef->setFactory(array(new Reference($clientId), 'getIndex'));
                $container->setDefinition($indexId, $indexDef);

                // un alias prenant directement la langue
                $typeId = sprintf('es_search_engine.index.%s.%s', $typeName, $lang);
                $typeDef = new DefinitionDecorator(sprintf('fos_elastica.index.%s.%s', $indexName, $typeName));
                $typeDef->setFactory(array(new Reference($indexId), 'getType'));
                //$typeDef->setClass('EuropeanSourcing\SearchEngineBundle\Type\ProductType');
                //$typeDef->replaceArgument(0, 'product');
                //$typeDef->setAbstract(false);
                $container->setDefinition($typeId, $typeDef);

                // le searcher
                /*$searcherId = sprintf('es_search_engine.searcher.%s.%s', $typeName, $lang);
                $searcherDef = new DefinitionDecorator(sprintf('es_search_engine.searcher'));
                $searcherDef->replaceArgument(0, new Reference($typeId));
                $container->setDefinition($searcherId, $searcherDef);*/

                // les transformers
                foreach (array('json', 'orm', 'none') as $format) {
                    $className = 'EuropeanSourcing\SearchEngineBundle\Transformer\ElasticaToProduct'.ucwords($format).'Transformer';

                    if (class_exists($className)) {
                        $abstractId = 'es_search_engine.elastica_to_product_transformer';
                        $serviceId = sprintf('es_search_engine.transformer.%s.%s.%s', $typeName, $lang, $format);
                        $serviceDef = new DefinitionDecorator($abstractId);
                        $serviceDef->replaceArgument(1, $typeConfig['model']);
                        $serviceDef->setAbstract(false);
                        $serviceDef->setClass($className);
                        //$serviceDef->addTag('fos_elastica.elastica_to_model_transformer', array('type' => $typeName, 'index' => $indexName));

                        $container->setDefinition($serviceId, $serviceDef);
                    }
                }


                /*$this->loadElasticaToModelTransformer($typeConfig, $container, $indexName, $typeName);

                $finderId = sprintf('fos_elastica.finder.%s.%s', $indexName, $typeName);
                $finderDef = new DefinitionDecorator('fos_elastica.finder');
                $finderDef->replaceArgument(0, new Reference($typeName));
                $finderDef->replaceArgument(1, new Reference($elasticaToModelId));
                $container->setDefinition($finderId, $finderDef);*/
            }

            /*$indexId = sprintf('fos_elastica.index.%s', $name);

            // transformer
            $transformerId = sprintf('es_search_engine.elastica_to_model_transformer.%s', $name);
            $transformerDef = new DefinitionDecorator('es_search_engine.elastica_to_model_transformer.collection');
            $container->setDefinition($transformerId, $transformerDef);

            // finder
            $finderId = sprintf('es_search_engine.finder.%s', $name);
            $finderDef = new DefinitionDecorator('es_search_engine.finder');
            $finderDef->replaceArgument(0, new Reference($indexId));
            $finderDef->replaceArgument(1, new Reference($transformerId));

            $container->setDefinition($finderId, $finderDef);*/

            //$this->loadTypes((array) $index['types'], $container, $this->indexConfigs[$name], $indexableCallbacks);*/
        }

        //VarDumper::dump($container->getDefinition('es_search_engine.transformer.product.fr.json')); die();
    }

    /**
     * Creates and loads an ElasticaToModelTransformer.
     *
     * @param array            $typeConfig
     * @param ContainerBuilder $container
     * @param string           $indexName
     * @param string           $typeName
     *
     * @return string
     */
    private function loadElasticaToModelTransformer(array $typeConfig, ContainerBuilder $container, $indexName, $typeName)
    {
        foreach (array('json', 'orm') as $format) {
            $className = 'EuropeanSourcing\SearchEngineBundle\Transformer\ElasticaToProduct'.ucwords($format).'Transformer';

            if (class_exists($className)) {
                $abstractId = 'es_search_engine.elastica_to_product_transformer';
                $serviceId = sprintf('es_search_engine.transformer.%s.%s', $typeName, $format);
                $serviceDef = new DefinitionDecorator($abstractId);
                $serviceDef->replaceArgument(1, $typeConfig['model']);
                $serviceDef->setClass($className);
                $serviceDef->addTag('fos_elastica.elastica_to_model_transformer', array('type' => $typeName, 'index' => $indexName));

                $container->setDefinition($serviceId, $serviceDef);
            }
        }
    }
}
