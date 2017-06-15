<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Exception\Configuration;

use Throwable;

/**
 * UnknownHashAlgorithmException.
 */
class UnknownHashAlgorithmException extends InvalidKeyConfigurationException
{
    /**
     * Constructor.
     *
     * @param string         $hashAlgorithm
     * @param Throwable|null $previous
     */
    public function __construct($hashAlgorithm, Throwable $previous = null)
    {
        parent::__construct($previous);

        $this->message = sprintf('Unknown hash algorithm "%s"', $hashAlgorithm);
    }
}
