<?php

namespace App\Filters\V1;

use App\Filters\APIFilter;

class CategoryFilter extends APIFilter
{
    protected $allowedParams = [
        'name' => ['eq'],
    ];

    protected $columnMap = [];
}