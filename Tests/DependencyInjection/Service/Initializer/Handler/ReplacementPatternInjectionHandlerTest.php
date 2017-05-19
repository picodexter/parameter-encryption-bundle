<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Service\Initializer\Handler;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\BundleConfigurationValidatorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\ReplacementPatternInjectionHandler;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ReferenceFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ServiceNameGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Picodexter\ParameterEncryptionBundle\Exception\InvalidBundleConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class ReplacementPatternInjectionHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BundleConfigurationValidatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $bundleConfigValidator;

    /**
     * @var ReplacementPatternInjectionHandler
     */
    private $handler;

    /**
     * @var ReferenceFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $referenceFactory;

    /**
     * @var ServiceNameGeneratorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $serviceNameGenerator;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->bundleConfigValidator = $this->createBundleConfigurationValidatorInterfaceMock();
        $this->referenceFactory = $this->createReferenceFactoryInterfaceMock();
        $this->serviceNameGenerator = $this->createServiceNameGeneratorInterfaceMock();

        $this->handler = new ReplacementPatternInjectionHandler(
            $this->bundleConfigValidator,
            $this->referenceFactory,
            $this->serviceNameGenerator
        );
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->handler = null;
        $this->serviceNameGenerator = null;
        $this->referenceFactory = null;
        $this->bundleConfigValidator = null;
    }

    /**
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\InvalidBundleConfigurationException
     */
    public function testInjectReplacementPatternsIntoRegistryExceptionInvalidConfig()
    {
        $bundleConfig = [];

        $container = $this->createContainerBuilderMock();

        $this->bundleConfigValidator->expects($this->once())
            ->method('assertValidBundleConfiguration')
            ->with($this->identicalTo($bundleConfig))
            ->will($this->throwException(new InvalidBundleConfigurationException()));

        $this->handler->injectReplacementPatternsIntoRegistry($bundleConfig, $container);
    }

    public function testInjectReplacementPatternsIntoRegistrySuccessEmpty()
    {
        $container = $this->createContainerBuilderMock();

        $registryDefinition = $this->createDefinitionMock();

        $container->expects($this->once())
            ->method('getDefinition')
            ->with(ServiceNames::REPLACEMENT_PATTERN_REGISTRY)
            ->will($this->returnValue($registryDefinition));

        $registryDefinition->expects($this->once())
            ->method('replaceArgument')
            ->with(
                $this->identicalTo(0),
                $this->identicalTo([])
            );

        $this->handler->injectReplacementPatternsIntoRegistry(
            [
                'algorithms' => [],
            ],
            $container
        );
    }

    public function testInjectReplacementPatternsIntoRegistrySuccessThreeReferences()
    {
        $preparedAlgorithmIds = [
            'algo_01',
            'algo_02',
            'algo_03',
        ];
        $preparedPatterns = [
            $preparedAlgorithmIds[0] => $this->createReferenceMock(),
            $preparedAlgorithmIds[1] => $this->createReferenceMock(),
            $preparedAlgorithmIds[2] => $this->createReferenceMock(),
        ];

        $container = $this->createContainerBuilderMock();

        $registryDefinition = $this->createDefinitionMock();

        $this->referenceFactory->expects($this->exactly(3))
            ->method('createReference')
            ->will($this->onConsecutiveCalls(
                $preparedPatterns[$preparedAlgorithmIds[0]],
                $preparedPatterns[$preparedAlgorithmIds[1]],
                $preparedPatterns[$preparedAlgorithmIds[2]]
            ));

        $container->expects($this->once())
            ->method('getDefinition')
            ->with(ServiceNames::REPLACEMENT_PATTERN_REGISTRY)
            ->will($this->returnValue($registryDefinition));

        $registryDefinition->expects($this->once())
            ->method('replaceArgument')
            ->with(
                $this->identicalTo(0),
                $this->identicalTo($preparedPatterns)
            );

        $this->handler->injectReplacementPatternsIntoRegistry(
            [
                'algorithms' => [
                    [
                        'id' => $preparedAlgorithmIds[0],
                    ],
                    [
                        'id' => $preparedAlgorithmIds[1],
                    ],
                    [
                        'id' => $preparedAlgorithmIds[2],
                    ],
                ],
            ],
            $container
        );
    }

    /**
     * Create mock for BundleConfigurationValidatorInterface.
     *
     * @return BundleConfigurationValidatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createBundleConfigurationValidatorInterfaceMock()
    {
        return $this->getMockBuilder(BundleConfigurationValidatorInterface::class)->getMock();
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)->getMock();
    }

    /**
     * Create mock for Definition.
     *
     * @return Definition|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createDefinitionMock()
    {
        return $this->getMockBuilder(Definition::class)->getMock();
    }

    /**
     * Create mock for ReferenceFactoryInterface.
     *
     * @return ReferenceFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createReferenceFactoryInterfaceMock()
    {
        return $this->getMockBuilder(ReferenceFactoryInterface::class)->getMock();
    }

    /**
     * Create mock for Reference.
     *
     * @return Reference|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createReferenceMock()
    {
        return $this->getMockBuilder(Reference::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * Create mock for ServiceNameGeneratorInterface.
     *
     * @return ServiceNameGeneratorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createServiceNameGeneratorInterfaceMock()
    {
        return $this->getMockBuilder(ServiceNameGeneratorInterface::class)->getMock();
    }
}
