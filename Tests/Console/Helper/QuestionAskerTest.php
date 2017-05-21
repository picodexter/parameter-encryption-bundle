<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Helper;

use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAsker;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class QuestionAskerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSetInputSuccess()
    {
        $asker = $this->createQuestionAsker();

        $input = $this->createInputInterfaceMock();

        $this->assertNotSame($input, $asker->getInput());

        $asker->setInput($input);

        $this->assertSame($input, $asker->getInput());
    }

    public function testGetSetOutputSuccess()
    {
        $asker = $this->createQuestionAsker();

        $output = $this->createOutputInterfaceMock();

        $this->assertNotSame($output, $asker->getOutput());

        $asker->setOutput($output);

        $this->assertSame($output, $asker->getOutput());
    }

    public function testGetSetQuestionSuccess()
    {
        $asker = $this->createQuestionAsker();

        $question = $this->createQuestionMock();

        $this->assertNotSame($question, $asker->getQuestion());

        $asker->setQuestion($question);

        $this->assertSame($question, $asker->getQuestion());
    }

    public function testGetSetQuestionHelperSuccess()
    {
        $asker = $this->createQuestionAsker();

        $questionHelper = $this->createQuestionHelperMock();

        $this->assertNotSame($questionHelper, $asker->getQuestionHelper());

        $asker->setQuestionHelper($questionHelper);

        $this->assertSame($questionHelper, $asker->getQuestionHelper());
    }

    public function testAskSuccess()
    {
        $input = $this->createInputInterfaceMock();
        $output =  $this->createOutputInterfaceMock();
        $question = $this->createQuestionMock();
        $questionHelper = $this->createQuestionHelperMock();

        $asker = new QuestionAsker($input, $output, $question, $questionHelper);

        $questionHelper->expects($this->once())
            ->method('ask')
            ->with(
                $this->identicalTo($input),
                $this->identicalTo($output),
                $this->identicalTo($question)
            );

        $asker->askQuestion();
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
     * Create question asker.
     *
     * @return QuestionAsker
     */
    private function createQuestionAsker()
    {
        $input = $this->createInputInterfaceMock();
        $output = $this->createOutputInterfaceMock();
        $question = $this->createQuestionMock();
        $questionHelper = $this->createQuestionHelperMock();

        return new QuestionAsker($input, $output, $question, $questionHelper);
    }

    /**
     * Create mock for QuestionHelper.
     *
     * @return QuestionHelper|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createQuestionHelperMock()
    {
        return $this->getMockBuilder(QuestionHelper::class)->getMock();
    }

    /**
     * Create mock for Question.
     *
     * @return Question|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createQuestionMock()
    {
        return $this->getMockBuilder(Question::class)->disableOriginalConstructor()->getMock();
    }
}