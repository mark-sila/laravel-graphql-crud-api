<?php

namespace App\Exceptions;

use Exception;
use GraphQL\Error\Error;
use GraphQL\Error\DebugFlag;
use GraphQL\Error\FormattedError;
use Illuminate\Support\Facades\Config;
use Rebing\GraphQL\Error\ValidationError;
use Illuminate\Validation\ValidationException;
use Rebing\GraphQL\Error\ProvidesErrorCategory;

class GraphQLException extends Exception
{
    /**
     * @return array<string,mixed>
     * @see \GraphQL\Executor\ExecutionResult::setErrorFormatter
     */
    public static function formatError(Error $e): array
    {
        $error = [
            'message' => $e->getMessage()
        ];

        $previous = $e->getPrevious();

        if ($previous) {
            if ($previous instanceof ValidationException) {
                $error['message'] = 'validationError';
                $error['fields'] = $previous->validator->errors()->getMessages();
            } elseif ($previous instanceof ValidationError) {
                $error['message'] = 'validationError';
                $error['fields'] = $previous->getValidatorMessages()->getMessages();
            } else {
                $error['locations'] = $e->getLocations();
                $error['paths'] = $e->getPath();
            }
        }
        
        return $error;
    }
}
