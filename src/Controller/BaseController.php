<?php

namespace vsmirnov\DDDCore\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;
use vsmirnov\DDDCore\ExecutableInterface;

class BaseController extends AbstractController
{
    /**
     * @var
     */
    private $requestToDtoTransformer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var ExecutableInterface
     */
    private $executable;

    /**
     * @var
     */
    private $dtoToResponseTransformer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * BaseController constructor.
     * @param $requestToDtoTransformer
     * @param ValidatorInterface $validator
     * @param ExecutableInterface $executable
     * @param $dtoToResponseTransformer
     * @param LoggerInterface $logger
     */
    public function __construct(
        $requestToDtoTransformer,
        ValidatorInterface $validator,
        ExecutableInterface $executable,
        $dtoToResponseTransformer,
        LoggerInterface $logger
    ) {
        $this->requestToDtoTransformer = $requestToDtoTransformer;
        $this->validator = $validator;
        $this->executable = $executable;
        $this->dtoToResponseTransformer = $dtoToResponseTransformer;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function execute(Request $request): Response
    {
        $this->logger->debug('Transforming http request to dto');
        $requestDto = $this->requestToDtoTransformer->transform($request);

        $this->logger->debug('Validating dto');
        $validationErrors = $this->validator->validate($requestDto);
        if (count($validationErrors) > 0) {
            return 'Some response with validation errors';
        }

        $this->logger->debug('Executing a business logic');
        try {
            $responseDto = $this->executable->execute($requestDto);
        } catch (Throwable $e) {
            return 'Some exceptional response';
        }

        $this->logger->debug('Transforming response dto to http response');
        return $this->dtoToResponseTransformer->transform($responseDto);
    }
}