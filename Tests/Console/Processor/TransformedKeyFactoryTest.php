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

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Processor;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Console\Processor\TransformedKey;
use Picodexter\ParameterEncryptionBundle\Console\Processor\TransformedKeyFactory;
use Picodexter\ParameterEncryptionBundle\Encryption\Value\Encoding\Base64EncoderInterface;

class TransformedKeyFactoryTest extends TestCase
{
    /**
     * @var Base64EncoderInterface|MockObject
     */
    private $encoder;

    /**
     * @var TransformedKeyFactory
     */
    private $factory;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->encoder = $this->createBase64EncoderInterfaceMock();

        $this->factory = new TransformedKeyFactory($this->encoder);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->factory = null;
        $this->encoder = null;
    }

    public function testCreateTransformedKeySuccess()
    {
        $originalKey = 'some original key';
        $finalKey = 'some final key';
        $finalKeyEncoded = 'some encoded final key';

        $this->encoder->expects($this->once())
            ->method('encode')
            ->with($this->identicalTo($finalKey))
            ->will($this->returnValue($finalKeyEncoded));

        $transformedKey = $this->factory->createTransformedKey($originalKey, $finalKey);

        $this->assertInstanceOf(TransformedKey::class, $transformedKey);
        $this->assertSame($finalKey, $transformedKey->getFinalKey());
        $this->assertSame($finalKeyEncoded, $transformedKey->getFinalKeyEncoded());
        $this->assertSame($originalKey, $transformedKey->getOriginalKey());
    }

    /**
     * Create mock for Base64EncoderInterface.
     *
     * @return Base64EncoderInterface|MockObject
     */
    private function createBase64EncoderInterfaceMock()
    {
        return $this->getMockBuilder(Base64EncoderInterface::class)->getMock();
    }
}
