<?php
namespace App\Validator;

use JsonSchema\Validator;
use JsonSchema\Uri\UriResolver;
use JsonSchema\RefResolver;
use JsonSchema\Uri\UriRetriever;
use JsonSchema\Constraints\Factory;

/**
 * Class ExampleValidator
 * @package App\Validator
 */
class ExampleValidator extends Validator
{
    const FILE = 'docs/json-schema/example.json';

    /**
     * @var RefResolver
     */
    private $refResolver;

    /**
     * @var UriResolver
     */
    private $uriResolver;

    /**
     * ExampleValidator constructor.
     * @param int $checkMode
     * @param UriRetriever $uriRetriever
     * @param Factory $factory
     * @param UriResolver $uriResolver
     * @param RefResolver|null $refResolver
     */
    public function __construct(
        $checkMode = Validator::CHECK_MODE_NORMAL,
        UriRetriever $uriRetriever,
        Factory $factory,
        UriResolver $uriResolver,
        RefResolver $refResolver = null
    ) {
        parent::__construct($checkMode, $uriRetriever, $factory);
        $this->uriResolver = $uriResolver;
        $this->refResolver = $refResolver ?: new RefResolver($this->getUriRetriever(), $this->uriResolver);
    }

    /**
     * @param string $contentType
     * @param string $requestBody
     * @return bool
     */
    public function validate($contentType, $requestBody)
    {
        if ($contentType != 'application/json') {
            $this->addError('', 'Content-Type must be application/json.');
            return false;
        }

        if (json_decode($requestBody) == null) {
            $this->addError('', 'request body must be json.');
            return false;
        }

        $schema = $this->refResolver->resolve('file://' . env('ROOT_DIR') . self::FILE);
        $this->check(json_decode($requestBody), $schema);
        if (!$this->isValid()) {
            return false;
        }

        return true;
    }
}