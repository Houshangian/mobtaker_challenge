<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ResponderTrait
{

    public function successResponse($data,$status=Response::HTTP_OK)
    {
        return response()->json([
            'time'=>\Illuminate\Support\Carbon::now(),
            'status'=>$status,
            'response'=>$data,
        ],$status);
    }

    public function errorResponse($message,$status=Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return response()->json([
            'time'=>\Illuminate\Support\Carbon::now(),
            'status'=>$status,
            'message'=>$message,
        ],$status);
    }
}
