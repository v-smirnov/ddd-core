<?php

namespace vsmirnov\DDDCore\Infrastructure\ObjectBuilder;

use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

final class SerializerBasedObjectBuilder implements ObjectBuilderInterface
{
    /**
     * @var SerializerInterface|DenormalizerInterface
     */
    private $serializer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param SerializerInterface $serializer
     * @param LoggerInterface $logger
     */
    public function __construct(SerializerInterface $serializer, LoggerInterface $logger)
    {
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function build(string $objectClass, array $data)
    {
        try {
            return $this->serializer->denormalize($data, $objectClass);
        } catch (Throwable $e) {
            $this->logger->critical(
                "Could not build object. The reason is - '{error}'",
                ['exception' => $e, 'error' => $e->getMessage()]
            );

            return new $objectClass;
        }
    }
}
