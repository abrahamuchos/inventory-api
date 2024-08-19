<?php

namespace App\Exceptions;

use Exception;

class QtyInvalidException extends Exception
{
    protected $code = 10001;

    public function render()
    {
        return response()->json([
            'error' => true,
            ''
        ]);
    }
}
