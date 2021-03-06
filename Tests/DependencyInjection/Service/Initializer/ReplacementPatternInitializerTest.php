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

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Service\Initializer;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\ReplacementPatternInjectionHandlerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\Handler\ReplacementPatternRegistrationHandlerInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Initializer\ReplacementPatternInitializer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ReplacementPatternInitializerTest extends TestCase
{
    /**
     * @var ReplacementPatternInitializer
     */
    private $initializer;

    /**
     * @var ReplacementPatternInjectionHandlerInterface|MockObject
     */
    private $injectionHandler;

    /**
     * @var ReplacementPatternRegistrationHandlerInterface|MockObject
     */
    private $registrationHandler;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->injectionHandler = $this->createReplacementPatternInjectionHandlerInterfaceMock();
        $this->registrationHandler = $this->createReplacementPatternRegistrationHandlerInterfaceMock();

        $this->initializer = new ReplacementPatternInitializer($this->injectionHandler, $this->registrationHandler);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->initializer = null;
        $this->registrationHandler = null;
        $this->injectionHandler = null;
    }

    public function testInitializeSuccess()
    {
        $bundleConfig = [
            'algorithms' => [],
        ];
        $container = $this->createContainerBuilderMock();

        $this->registrationHandler->expects($this->once())
            ->method('registerReplacementPatterns')
            ->with(
                $this->identicalTo($bundleConfig),
                $this->identicalTo($container)
            );

        $this->injectionHandler->expects($this->once())
            ->method('injectReplacementPatternsIntoRegistry')
            ->with(
                $this->identicalTo($bundleConfig),
                $this->identicalTo($container)
            );

        $this->initializer->initialize($bundleConfig, $container);
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
     * Create mock for ReplacementPatternInjectionHandlerInterface.
     *
     * @return ReplacementPatternInjectionHandlerInterface|MockObject
     */
    private function createReplacementPatternInjectionHandlerInterfaceMock()
    {
        return $this->getMockBuilder(ReplacementPatternInjectionHandlerInterface::class)->getMock();
    }

    /**
     * Create mock for ReplacementPatternRegistrationHandlerInterface.
     *
     * @return ReplacementPatternRegistrationHandlerInterface|MockObject
     */
    private function createReplacementPatternRegistrationHandlerInterfaceMock()
    {
        return $this->getMockBuilder(ReplacementPatternRegistrationHandlerInterface::class)->getMock();
    }
}
