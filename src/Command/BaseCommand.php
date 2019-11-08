<?php

namespace vsmirnov\DDDCore\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;
use vsmirnov\DDDCore\Dto\DtoInterface;
use vsmirnov\DDDCore\ExecutableInterface;

class BaseCommand extends Command
{
    private $dtoFactory;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var ExecutableInterface
     */
    private $executable;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param string $commandName
     * @param string $commandDescription
     * @param $dtoFactory
     * @param ValidatorInterface $validator
     * @param ExecutableInterface $executable
     * @param LoggerInterface $logger
     */
    public function __construct(
        string $commandName,
        string $commandDescription,
        $dtoFactory,
        ValidatorInterface $validator,
        ExecutableInterface $executable,
        LoggerInterface $logger
    ) {
        parent::__construct($commandName);

        $this->setDescription($commandDescription);

        $this->dtoFactory = $dtoFactory;
        $this->validator = $validator;
        $this->executable = $executable;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->logger->info("Starting '{commandName}' command execution", ['commandName' =>$this->getName()]);

        try {
            $this->logger->info('Transforming input parameters to dto');
            $dto = $this->createDto($input);

            $this->logger->info('Validating dto');
            $errors = $this->validator->validate($dto);

            if (count($errors) > 0) {
                $this->logger->warning(
                    "Input information has error(s): '{validationErrors}'",
                    [
                        'validationErrors' => (string) $errors
                    ]
                );

                return 1;
            }

            $this->logger->info('Executing a business logic');
            $this->executable->execute($dto);
        } catch (Throwable $e) {
            $this->logger->critical(
                "An error occurred while executing '{commandName}' command",
                [
                    'commandName' =>$this->getName(),
                    'exception' => $e,
                ]
            );

            return 1;
        }

        $this->logger->info("'{commandName}' command execution finished", ['commandName' =>$this->getName()]);

        return 0;
    }

    /**
     * @param InputInterface $input
     *
     * @return DtoInterface
     */
    private function createDto(InputInterface $input): DtoInterface
    {
        return $this->dtoFactory->create(array_merge($input->getOptions(), $input->getArguments()));
    }
}