<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Console\Processor;

use Symfony\Component\Console\Helper\Table;

/**
 * AlgorithmListProcessorInterface.
 */
interface AlgorithmListProcessorInterface
{
    /**
     * Render algorithm list as table.
     *
     * @param Table $table
     */
    public function renderAlgorithmListTable(Table $table);
}
