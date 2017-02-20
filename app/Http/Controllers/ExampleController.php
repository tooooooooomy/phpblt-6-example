<?php
namespace App\Http\Controllers;

use App\Validator\ExampleValidator;
use Illuminate\Http\Request;

/**
 * Class ExampleController
 * @package App\Http\Controllers
 */
class ExampleController extends Controller
{
    /**
     * @var ExampleValidator
     */
    private $validator;

    public function __construct(ExampleValidator $exampleValidator)
    {
        $this->validator = $exampleValidator;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function run(Request $request)
    {
        $headers = ['Content-Type' => 'application/json'];
        try {
            if (!$this->validator->validate($request->headers->get('Content-Type'), $request->getContent())) {
                return response('validation error', 400, $headers);
            }

            //business logic...
            $req_params = json_decode($request->getContent(), true);
            if ($req_params['string'] == 'fuga') {
                throw new \RuntimeException('fugafuga');
            }

            return response([], 200, $headers);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500, $headers);
        }
    }

}