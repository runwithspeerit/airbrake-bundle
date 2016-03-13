<?php

namespace Ami\AirbrakeBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AmiAirbrakeExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('ami_airbrake.project_id', $config['project_id']);
        $container->setParameter('ami_airbrake.project_key', $config['project_key']);
        $container->setParameter('ami_airbrake.host', $config['host']);
        $container->setParameter('ami_airbrake.ignored_exceptions', $config['ignored_exceptions']);

        // Exception Listener
        if ($config['project_key']) {
            // Airbrake notifier
            $container->setDefinition(
                'ami_airbrake.notifier',
                new Definition(
                    $container->getParameter('ami_airbrake.notifier.class'),
                    [[
                        'projectId'     => $config['project_id'],
                        'projectKey'    => $config['project_key'],
                        'host'          => $config['host'],
                        'environment'   => $container->getParameter('kernel.environment'),
                        'rootDirectory' => dirname($container->getParameter('kernel.root_dir'))
                    ]]
                )
            );

            // Exception Listener
            $container->setDefinition(
                'ami_airbrake.exception_listener',
                (new Definition(
                    $container->getParameter('ami_airbrake.exception_listener.class'),
                    [new Reference('ami_airbrake.notifier'), $config['ignored_exceptions']]
                ))->addTag(
                    'kernel.event_listener',
                    ['event' => 'kernel.exception', 'method' => 'onKernelException']
                )->addTag(
                    'kernel.event_listener',
                    ['event' => 'console.exception', 'method' => 'onKernelException']
                )
            );

            // PHP Shutdown Listener
            $container->setDefinition(
                'ami_airbrake.shutdown_listener',
                (new Definition(
                    $container->getParameter('ami_airbrake.shutdown_listener.class'),
                    [new Reference('ami_airbrake.notifier'), $config['ignored_exceptions']]
                ))->addTag(
                    'kernel.event_listener',
                    ['event' => 'kernel.controller', 'method' => 'register']
                )
            );
        }
    }
}
