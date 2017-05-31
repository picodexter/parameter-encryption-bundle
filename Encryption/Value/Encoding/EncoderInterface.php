<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Encryption\Value\Encoding;

/**
 * EncoderInterface.
 */
interface EncoderInterface
{
    /**
     * Encode value in Base64.
     *
     * @param string $plainValue
     *
     * @return string
     */
    public function encode($plainValue);
}