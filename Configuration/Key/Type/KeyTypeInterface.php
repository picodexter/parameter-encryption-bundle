<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Configuration\Key\Type;

/**
 * KeyTypeInterface.
 */
interface KeyTypeInterface
{
    /**
     * Get name.
     *
     * @return string
     */
    public function getName();
}