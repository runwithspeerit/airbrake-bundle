<?php

namespace Ami\AirbrakeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\Reference;
use Ami\AirbrakeBundle\DependencyInjection\AmiAirbrakeExtension;

class AmiAirbrakeExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var AmiAirbrakeExtension
     */
    private $extension;

    protected function setUp()
    {
        $this->container = new ContainerBuilder(new ParameterBag([
            'kernel.root_dir'    => __DIR__,
            'kernel.bundles'     => ['AmiAirbrakeBundle' => true],
            'kernel.environment' => 'test',
        ]));
        $this->extension = new AmiAirbrakeExtension();
    }

    protected function tearDown()
    {
        unset($this->container, $this->extension);
    }

    public function testEnableAmiAirbrakeNotifier()
    {
        $config = ['ami_airbrake' => [
            'project_id' => 42,
            'project_key' => 'foo-bar',
        ]];
        $this->extension->load($config, $this->container);

        $this->assertTrue($this->container->hasDefinition('ami_airbrake.notifier'));
    }

    public function testDisableAmiAirbrakeNotifier()
    {
        $config = ['ami_airbrake' => [
            'project_id' => 42,
            'project_key' => null,
        ]];
        $this->extension->load($config, $this->container);

        $this->assertFalse($this->container->hasDefinition('ami_airbrake.notifier'));
    }
}
