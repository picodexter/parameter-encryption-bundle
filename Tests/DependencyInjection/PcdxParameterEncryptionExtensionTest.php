<?php

declare(strict_types=1);

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\PcdxParameterEncryptionExtension;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ServiceDefinitionInitializationManagerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PcdxParameterEncryptionExtensionTest extends TestCase
{
    /**
     * @var PcdxParameterEncryptionExtension
     */
    private $extension;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->extension = new PcdxParameterEncryptionExtension();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->extension = null;
    }

    public function testGetNamespaceSuccess()
    {
        $namespace = $this->extension->getNamespace();

        $this->assertSame(PcdxParameterEncryptionExtension::XML_NAMESPACE, $namespace);
    }

    public function testGetXsdValidationBasePathSuccess()
    {
        $basePath = $this->extension->getXsdValidationBasePath();

        $this->assertSame(PcdxParameterEncryptionExtension::XSD_VALIDATION_BASE_PATH, $basePath);
    }

    public function testLoadInternalSuccess()
    {
        $mergedConfig = [
            'some_config' => 'random data',
        ];

        $container = $this->createContainerBuilderMock();
        $initManager = $this->createServiceDefinitionInitializationManagerInterfaceMock();

        $container->expects($this->once())
            ->method('get')
            ->with($this->identicalTo(ServiceNames::SERVICE_DEFINITION_INITIALIZATION_MANAGER))
            ->will($this->returnValue($initManager));

        $initManager->expects($this->once())
            ->method('initializeServiceDefinitions')
            ->with(
                $this->identicalTo($mergedConfig),
                $this->identicalTo($container)
            );

        $this->extension->loadInternal($mergedConfig, $container);
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['get'])
            ->getMock();
    }

    /**
     * Create mock for ServiceDefinitionInitializationManagerInterface.
     *
     * @return ServiceDefinitionInitializationManagerInterface|MockObject
     */
    private function createServiceDefinitionInitializationManagerInterfaceMock()
    {
        return $this->getMockBuilder(ServiceDefinitionInitializationManagerInterface::class)->getMock();
    }
}
