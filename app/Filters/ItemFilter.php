<?php

namespace App\Filters;

class ItemFilter extends ApiFilter
{
    protected array $safeParams = [
      'name' => ['eq'],
      'sku' => ['eq'],
      'userId' => ['eq'],
      'stock' => ['eq', 'gt', 'gte', 'lt',  'lte']
    ];

    protected array $columnMap = [
      'userId' => 'user_id'
    ];

    protected array $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];
}
