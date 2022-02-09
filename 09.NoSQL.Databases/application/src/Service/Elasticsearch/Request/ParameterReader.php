<?php

declare(strict_types=1);

namespace App\Service\Elasticsearch\Request;

use App\Exception\ValidationException;

final class ParameterReader
{
    private const SEARCH_PARAMETER = 'q';

    /**
     * @param array $parameters
     *
     * @return string
     */
    public function getParameterName(array $parameters): string
    {
        $parameter = '';
        foreach ($parameters as $parameterName) {
            if ($parameterName === self::SEARCH_PARAMETER) {
                $parameter = $parameterName;
                break;
            }
        }

        if (empty($parameter)) {
            throw new ValidationException('Please check your query', [
                "The request parameter is empty or not allowed"
            ]);
        }

        return $parameter;
    }
}
