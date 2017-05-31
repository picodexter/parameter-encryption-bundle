Configuration
=============

This bundle uses semantic configuration that can be used with either YAML, XML
or PHP.

Every single directive has a description which can be shown by using the
``config:dump`` command:

.. code-block:: terminal

    $ php bin/console config:dump pcdx_parameter_encryption

Example Configuration
---------------------

.. configuration-block::

    .. code-block:: yaml

        # app/config/config.yml
        pcdx_parameter_encryption:
            algorithms:
                -   id: 'caesar_rot13'
                    pattern:
                        type: 'value_prefix'
                        arguments:
                            -   '=#!PPE!c:r13!#='
                    encryption:
                        service: 'pcdx_parameter_encryption.encryption.encrypter.caesar.rot13'
                        key: '%parameter_encryption.caesar.rot13.key%'
                    decryption:
                        service: 'pcdx_parameter_encryption.encryption.decrypter.caesar.rot13'
                        key: '%parameter_encryption.caesar.rot13.key%'
                -   id: 'algorithm_with_minimum_options'
                    pattern:
                        type: 'pattern_type'
                    encryption:
                        service: 'some_encrypter_service'
                    decryption:
                        service: 'some_decrypter_service'
                -   id: 'algorithm_with_all_options'
                    pattern:
                        type: 'pattern_type'
                        arguments:
                            -   'pattern_type_argument_1'
                            -   'pattern_type_argument_2'
                            -   '...'
                    encryption:
                        service: 'some_encrypter_service'
                        key: 'encryption_key'
                    decryption:
                        service: 'some_decrypter_service'
                        key: 'decryption_key'
                # additional algorithms ...

    .. code-block:: xml

        <!-- app/config/config.xml -->
        <?xml version="1.0" encoding="UTF-8" ?>
        <container xmlns="http://symfony.com/schema/dic/services"
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xmlns:ppe="https://picodexter.io/schema/dic/pcdx_parameter_encryption"
            xsi:schemaLocation="https://picodexter.io/schema/dic/pcdx_parameter_encryption
                https://picodexter.io/schema/dic/pcdx_parameter_encryption/pcdx_parameter_encryption-1.0.xsd">

            <ppe:config>
                <ppe:algorithm id="caesar_rot13">
                    <ppe:pattern type="value_prefix">
                        <ppe:argument>=#!PPE!c:r13!#=</ppe:argument>
                    </ppe:pattern>
                    <ppe:encryption service="pcdx_parameter_encryption.encryption.encrypter.caesar.rot13"
                        key="%parameter_encryption.caesar.rot13.key%" />
                    <ppe:decryption service="pcdx_parameter_encryption.encryption.decrypter.caesar.rot13"
                        key="%parameter_encryption.caesar.rot13.key%" />
                </ppe:algorithm>
                <ppe:algorithm id="algorithm_with_minimum_options">
                    <ppe:pattern type="pattern_type" />
                    <ppe:encryption service="some_encrypter_service" />
                    <ppe:decryption service="some_decrypter_service" />
                </ppe:algorithm>
                <ppe:algorithm id="algorithm_with_all_options">
                    <ppe:pattern type="pattern_type">
                        <ppe:argument>pattern_type_argument_1</ppe:argument>
                        <ppe:argument>pattern_type_argument_2</ppe:argument>
                        <ppe:argument>...</ppe:argument>
                    </ppe:pattern>
                    <ppe:encryption service="some_encrypter_service"
                        key="encryption_key" />
                    <ppe:decryption service="some_decrypter_service"
                        key="decryption_key" />
                </ppe:algorithm>
                <!-- additional algorithms ... -->
            </ppe:config>
        </container>

    .. code-block:: php

        // app/config/config.php
        $container->loadFromExtension(
            'pcdx_parameter_encryption',
            [
                'algorithms' => [
                    [
                        'id' => 'caesar_rot13',
                        'pattern' => [
                            'type' => 'value_prefix'
                            'arguments' => ['=#!PPE!c:r13!#='],
                        ],
                        'encryption' => [
                            'service' => 'pcdx_parameter_encryption.encryption.encrypter.caesar.rot13',
                            'key' => '%parameter_encryption.caesar.rot13.key%',
                        ],
                        'decryption' => [
                            'service' => 'pcdx_parameter_encryption.encryption.decrypter.caesar.rot13',
                            'key' => '%parameter_encryption.caesar.rot13.key%',
                        ],
                    ],
                    [
                        'id' => 'algorithm_with_minimum_options',
                        'pattern' => [
                            'type' => 'pattern_type',
                        ],
                        'encryption' => [
                            'service' => 'some_encrypter_service',
                        ],
                        'decryption' => [
                            'service' => 'some_decrypter_service',
                        ],
                    ],
                    [
                        'id' => 'algorithm_with_all_options',
                        'pattern' => [
                            'type' => 'pattern_type',
                            'arguments' => [
                                'pattern_type_argument_1',
                                'pattern_type_argument_2',
                                '...',
                            ],
                        ],
                        'encryption' => [
                            'service' => 'some_encrypter_service',
                            'key' => 'encryption_key',
                        ],
                        'decryption' => [
                            'service' => 'some_decrypter_service',
                            'key' => 'decryption_key',
                        ],
                    ],
                    // additional algorithms ...
                ],
            ]
        );

Directive Overview
------------------

+---------------------------------+------------------------------------------------------------------------------------+
| Directive Name                  | Description                                                                        |
+=================================+====================================================================================+
| algorithms                      | Contains configuration about the enabled algorithms that can be used by this       |
|                                 | bundle.                                                                            |
+---------------------------------+------------------------------------------------------------------------------------+
| algorithms.#.id                 | Algorithm ID. Used as the primary identifier for algorithms, e.g. for the encrypt  |
|                                 | and decrypt console commands.                                                      |
|                                 |                                                                                    |
|                                 | Unique.                                                                            |
+---------------------------------+------------------------------------------------------------------------------------+
| algorithms.#.pattern            | Contains configuration about the replacement pattern that is used to detect if a   |
|                                 | parameter is encrypted and which part of the parameter belongs to the encrypted    |
|                                 | value.                                                                             |
+---------------------------------+------------------------------------------------------------------------------------+
| algorithms.#.pattern.type       | The replacement pattern type to use. Registered via the service                    |
|                                 | ``pcdx_parameter_encryption.replacement.pattern.type_registry``.                   |
+---------------------------------+------------------------------------------------------------------------------------+
| algorithms.#.pattern.arguments  | Constructor arguments for the replacement pattern type.                            |
|                                 |                                                                                    |
|                                 | Optional depending on the replacement pattern type.                                |
+---------------------------------+------------------------------------------------------------------------------------+
| algorithms.#.encryption         | Contains configuration about the encrypter.                                        |
+---------------------------------+------------------------------------------------------------------------------------+
| algorithms.#.encryption.service | Encrypter service name.                                                            |
+---------------------------------+------------------------------------------------------------------------------------+
| algorithms.#.encryption.key     | Encryption key.                                                                    |
|                                 |                                                                                    |
|                                 | **Recommendation:** Do not hard-code this value and use a parameter instead. This  |
|                                 | parameter could be defined in the unversioned ``parameters.yml`` file or via       |
|                                 | environment variable.                                                              |
+---------------------------------+------------------------------------------------------------------------------------+
| algorithms.#.decryption         | Contains configuration about the decrypter.                                        |
+---------------------------------+------------------------------------------------------------------------------------+
| algorithms.#.decryption.service | Decrypter service name.                                                            |
+---------------------------------+------------------------------------------------------------------------------------+
| algorithms.#.decryption.key     | Decryption key.                                                                    |
|                                 |                                                                                    |
|                                 | **Recommendation:** Do not hard-code this value and use a parameter instead. This  |
|                                 | parameter could be defined in the unversioned ``parameters.yml`` file or via       |
|                                 | environment variable.                                                              |
+---------------------------------+------------------------------------------------------------------------------------+

Replacement Pattern Types
-------------------------

Replacement patterns are used to identify a parameter that is encrypted and to
extract the data that is the actual encrypted information.

The types of replacement patterns are registered with the service
``pcdx_parameter_encryption.replacement.pattern.type_registry``. This is a list
of replacement pattern types that are available by default:

+-------------------+--------------------------------------------------------------------------+-----------------------+
| Pattern Type Name | Description                                                              | Constructor Arguments |
+===================+==========================================================================+=======================+
| value_prefix      | Identifies a parameter by a prefix in the value.                         | * the prefix          |
|                   |                                                                          |                       |
|                   | Example for a correctly detected parameter:                              |                       |
|                   |                                                                          |                       |
|                   | * prefix = ``=#!ENCRYPTED!#=``                                           |                       |
|                   | * parameter value = ``=#!ENCRYPTED!#=testvalue``                         |                       |
|                   | * detected encrypted value = ``testvalue``                               |                       |
+-------------------+--------------------------------------------------------------------------+-----------------------+

You can add your own replacement patterns by implementing the
:class:`Picodexter\ParameterEncryptionBundle\Replacement\Pattern\ReplacementPatternInterface`
interface, overriding the service definition for
``pcdx_parameter_encryption.replacement.pattern.type_registry``
and injecting your own class information into the registry.