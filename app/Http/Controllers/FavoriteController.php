<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\FavoriteService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function show(int $user_id)
    {
        return response()->json($this->favoriteService->renderByUser($user_id), 200);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'product_id' => 'required|integer|unique:favorites,product_id,NULL,NULL,user_id,' . $request->user_id,
        ], [
            'user_id.required' => 'user is required.',
            'user_id.integer' => 'user need be int.',
            'user_id.exists' => 'user not found.',
            'product_id.required' => 'product is required.',
            'product_id.integer' => 'user need be int.',
            'product_id.unique' => 'product already in favorites.',
        ]);

        if ($validation->fails()) {
            return response()->json([
                "errors" => $validation->errors()->all()
            ], 400);
        }

        try {
            $this->favoriteService->buildInsert($request->all());

            return response()->json([
                'status' => 'created'
            ], 201);
        } catch (\Exception $e) {
            Log::error($e->getFile() . "\n" . $e->getLine() . "\n" . $e->getMessage());
            return response()->json([
                'errors' => [
                    $e->getMessage(),
                    'Internal Server Error - Check Logs'
                ]
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
        ], [
            'user_id.required' => 'user is required.',
            'user_id.integer' => 'user need be int.',
            'product_id.required' => 'product is required.',
            'product_id.integer' => 'user need be int.',
        ]);

        if ($validation->fails()) {
            return response()->json([
                "errors" => $validation->errors()->all()
            ], 400);
        }

        try {
            $this->favoriteService->buildDelete($request->all());

            return response()->json([
                'status' => 'deleted'
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getFile() . "\n" . $e->getLine() . "\n" . $e->getMessage());
            return response()->json([
                'errors' => [
                    $e->getMessage(),
                    'Internal Server Error - Check Logs'
                ]
            ], 500);
        }
    }
}
