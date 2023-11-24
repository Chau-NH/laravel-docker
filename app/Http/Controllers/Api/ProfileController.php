<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * @OA\Get(
     *  path="/api/profile",
     *  summary="Get User Profile Details",
     *  description="Get Authorized User Details",
     *  operationId="authorizedUserDetails",
     *  tags={"Profile"},
     *  security={ {"bearer_token": {} }},
     *  @OA\Response(
     *      response=200,
     *      description="Successfully",
     *      @OA\JsonContent()
     *  ),
     *  @OA\Response(response=400, description="Bad request"),
     *  @OA\Response(response=403, description="Unauthenticated"),
     *  @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function get(Request $request)
    {
        return $request->user();
    }
}
