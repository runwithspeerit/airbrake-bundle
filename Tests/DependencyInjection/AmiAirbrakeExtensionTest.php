<?php

namespace Speerit\AirbrakeBundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class SpeeritAirbrakeExtensionTest extends TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var SpeeritAirbrakeExtension
     */
    private $extension;

    public function testEnableSpeeritAirbrakeNotifier()
    {
        $config = [
            'speerit_airbrake' => [
                'project_id' => 42,
                'project_key' => 'foo-bar',
            ],
        ];
        $this->extension->load($config, $this->container);

        $this->assertTrue($this->container->hasDefinition('speerit_airbrake.notifier'));
    }

    public function testDisableSpeeritAirbrakeNotifier()
    {
        $config = [
            'speerit_airbrake' => [
                'project_id' => 42,
                'project_key' => null,
            ],
        ];
        $this->extension->load($config, $this->container);

        $this->assertFalse($this->container->hasDefinition('speerit_airbrake.notifier'));
    }

    protected function setUp()
    {
        $this->container = new ContainerBuilder(
            new ParameterBag(
                [
                    'kernel.root_dir' => __DIR__,
                    'kernel.bundles' => ['SpeeritAirbrakeBundle' => true],
                    'kernel.environment' => 'test',
                ]
            )
        );
        $this->extension = new SpeeritAirbrakeExtension();
    }

    protected function tearDown()
    {
        unset($this->container, $this->extension);
    }
}
