<?php

namespace App\Filters\V1;

use App\Filters\APIFilter;

class BlogFilter extends APIFilter
{
    protected $allowedParams = [
        'title' => ['eq'],
        'categoryId' => ['eq'],
        'userId' => ['eq'],
    ];

    protected $columnMap = [
        'categoryId' => 'category_id',
        'userId' => 'user_id',
    ];
}