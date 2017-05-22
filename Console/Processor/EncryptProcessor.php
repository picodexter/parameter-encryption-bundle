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

use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfigurationContainerInterface;
use Picodexter\ParameterEncryptionBundle\Console\Request\EncryptRequest;
use Picodexter\ParameterEncryptionBundle\Exception\Console\UnknownAlgorithmIdException;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * EncryptProcessor.
 */
class EncryptProcessor implements EncryptProcessorInterface
{
    /**
     * @var AlgorithmConfigurationContainerInterface
     */
    private $algorithmConfigContainer;

    /**
     * Constructor.
     *
     * @param AlgorithmConfigurationContainerInterface $algorithmContainer
     */
    public function __construct(AlgorithmConfigurationContainerInterface $algorithmContainer)
    {
        $this->algorithmConfigContainer = $algorithmContainer;
    }

    /**
     * Assert that algorithm ID exists.
     *
     * @param string $algorithmId
     * @throws UnknownAlgorithmIdException
     */
    private function assertKnownAlgorithmId($algorithmId)
    {
        if (!$this->algorithmConfigContainer->has($algorithmId)) {
            throw new UnknownAlgorithmIdException($algorithmId);
        }
    }

    /**
     * Get key.
     *
     * @param EncryptRequest $request
     * @param string         $configKey
     * @return string|null
     */
    private function getKey(EncryptRequest $request, $configKey)
    {
        if (!$request->isKeyProvided()) {
            $key = $configKey;
        } else {
            $key = $request->getKey();
        }

        return $key;
    }

    /**
     * Get plaintext value.
     *
     * @param EncryptRequest $request
     * @return string
     */
    private function getPlaintextValue(EncryptRequest $request)
    {
        if (!$request->getPlaintextValue()) {
            $plaintextValue = $request->getPlaintextQuestionAsker()->askQuestion();
        } else {
            $plaintextValue = $request->getPlaintextValue();
        }

        return $plaintextValue;
    }

    /**
     * @inheritDoc
     */
    public function renderEncryptOutput(EncryptRequest $request, OutputInterface $output)
    {
        $this->assertKnownAlgorithmId($request->getAlgorithmId());

        $algorithmConfig = $this->algorithmConfigContainer->get($request->getAlgorithmId());

        $plaintextValue = $this->getPlaintextValue($request);

        $key = $this->getKey($request, $algorithmConfig->getEncryptionKey());

        $encryptedValue = $algorithmConfig->getEncrypter()->encryptValue($plaintextValue, $key);

        $this->renderOutput($encryptedValue, $key, $output);
    }

    /**
     * Render output.
     *
     * @param string          $encryptedValue
     * @param string          $key
     * @param OutputInterface $output
     */
    private function renderOutput($encryptedValue, $key, OutputInterface $output)
    {
        if ($output->isQuiet()) {
            $output->writeln($encryptedValue, OutputInterface::VERBOSITY_QUIET);
        } else {
            $output->writeln('Encryption key:  "' . $key . '"');
            $output->writeln('Encrypted value: "' . $encryptedValue . '"');
        }
    }
}
