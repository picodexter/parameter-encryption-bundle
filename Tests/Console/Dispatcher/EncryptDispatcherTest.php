<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Dispatcher;

use Picodexter\ParameterEncryptionBundle\Console\Dispatcher\EncryptDispatcher;
use Picodexter\ParameterEncryptionBundle\Console\Helper\HiddenInputQuestionAskerGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerInterface;
use Picodexter\ParameterEncryptionBundle\Console\Processor\EncryptProcessorInterface;
use Picodexter\ParameterEncryptionBundle\Console\Request\EncryptRequest;
use Picodexter\ParameterEncryptionBundle\Console\Request\EncryptRequestFactoryInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EncryptDispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EncryptDispatcher
     */
    private $dispatcher;

    /**
     * @var EncryptProcessorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $processor;

    /**
     * @var HiddenInputQuestionAskerGeneratorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $questionAskerGenerator;

    /**
     * @var EncryptRequestFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $requestFactory;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->processor = $this->createEncryptProcessorInterfaceMock();
        $this->questionAskerGenerator = $this->createHiddenInputQuestionAskerGeneratorInterfaceMock();
        $this->requestFactory = $this->createEncryptRequestFactoryInterfaceMock();

        $this->dispatcher = new EncryptDispatcher(
            $this->requestFactory,
            $this->processor,
            $this->questionAskerGenerator
        );
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->dispatcher = null;
        $this->requestFactory = null;
        $this->questionAskerGenerator = null;
        $this->processor = null;
    }

    public function testDispatchToProcessorSuccess()
    {
        $input = $this->createInputInterfaceMock();
        $output = $this->createOutputInterfaceMock();
        $request = $this->createEncryptRequestMock();
        $questionAsker = $this->createQuestionAskerInterfaceMock();

        $this->requestFactory->expects($this->once())
            ->method('createEncryptRequest')
            ->will($this->returnValue($request));

        $this->questionAskerGenerator->expects($this->once())
            ->method('generateHiddenInputQuestionAsker')
            ->will($this->returnValue($questionAsker));

        $this->processor->expects($this->once())
            ->method('renderEncryptOutput')
            ->with(
                $this->identicalTo($request),
                $this->identicalTo($output)
            );

        $this->dispatcher->dispatchToProcessor($input, $output);
    }

    /**
     * Create mock for EncryptProcessorInterface.
     *
     * @return EncryptProcessorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createEncryptProcessorInterfaceMock()
    {
        return $this->getMockBuilder(EncryptProcessorInterface::class)->getMock();
    }

    /**
     * Create mock for EncryptRequestFactoryInterface.
     *
     * @return EncryptRequestFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createEncryptRequestFactoryInterfaceMock()
    {
        return $this->getMockBuilder(EncryptRequestFactoryInterface::class)->getMock();
    }

    /**
     * Create mock for EncryptRequest.
     *
     * @return EncryptRequest|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createEncryptRequestMock()
    {
        return $this->getMockBuilder(EncryptRequest::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * Create mock for HiddenInputQuestionAskerGeneratorInterface.
     *
     * @return HiddenInputQuestionAskerGeneratorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createHiddenInputQuestionAskerGeneratorInterfaceMock()
    {
        return $this->getMockBuilder(HiddenInputQuestionAskerGeneratorInterface::class)->getMock();
    }

    /**
     * Create mock for InputInterface.
     *
     * @return InputInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createInputInterfaceMock()
    {
        return $this->getMockBuilder(InputInterface::class)->getMock();
    }

    /**
     * Create mock for OutputInterface.
     *
     * @return OutputInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createOutputInterfaceMock()
    {
        return $this->getMockBuilder(OutputInterface::class)->getMock();
    }

    /**
     * Create mock for QuestionAskerInterface.
     *
     * @return QuestionAskerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createQuestionAskerInterfaceMock()
    {
        return $this->getMockBuilder(QuestionAskerInterface::class)->getMock();
    }
}
