<?php

namespace App\Traits;

trait ApiResponser
{
	private function successResponse($data, $code)
	{
		return response()->json(['data' => $data , 'code' => $code], $code);
	}

	protected function errorResponse($message, $code)
	{
		return response()->json(['error' => $message, 'code' => $code], $code);
	}

}
