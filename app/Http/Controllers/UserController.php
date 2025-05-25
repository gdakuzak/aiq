<?php

namespace App\Http\Controllers;

use Exception;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            $this->userService->renderList(),
            200
        );
    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'email is required.',
            'password.required' => 'password is required.',
        ]);

        if ($validation->fails()) {
            return response()->json([
                "errors" => $validation->errors()->all()
            ], 400);
        }

        try {
            if(Auth::attempt($request->only('email', 'password'))) {
                $user = $this->userService->renderEdit(Auth::user()->id);
                $token = explode('|',$user->createToken("TokenLogin")->plainTextToken);
                return response()->json([
                    'status' => 'success',
                    'token' => $token[1],
                ], 200);
            }


        } catch (\Exception $e) {
            Log::error($e->getFile() . "\n" . $e->getLine() . "\n" . $e->getMessage());
            return response()->json([
                'errors' => [
                    'Internal Server Error - Check Logs'
                ]
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'email is required.',
            'email.unique' => 'email already used.',
            'name.required' => 'name is required.',
            'password.required' => 'password is required.',
            'password.min' => 'password must be at least 8 characters.',
        ]);

        if ($validation->fails()) {
            return response()->json([
                "errors" => $validation->errors()->all()
            ], 400);
        }

        try {
            $user = $this->userService->buildInsert($request->merge([
                'password' => Hash::make($request->password),
            ])->all());

            $token = explode('|',$user->createToken("TokenCriacao")->plainTextToken);
            return response()->json([
                'status' => 'created',
                'token' => $token[1],
            ], 201);

        } catch (\Exception $e) {
            Log::error($e->getFile() . "\n" . $e->getLine() . "\n" . $e->getMessage());
            return response()->json([
                'errors' => [
                    'Internal Server Error - Check Logs'
                ]
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $this->checkIfIdIsInt($id);

            return response()->json(
                $this->userService->renderEdit($id),
                200
            );
        } catch (Exception $e) {
            return response()->json([
                'errors' => [
                    $e->getMessage()
                ]
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation =   Validator::make($request->all(), [
            'email' => 'sometimes|unique:users,email,' . $id,
            'name' => 'sometimes',
        ], [
            'email.unique' => 'email already used.',
        ]);

        if ($validation->fails()) {
            return response()->json([
                "errors" => $validation->errors()->all()
            ], 400);
        }

        try {
            $this->checkIfIdIsInt($id);

            $this->userService->buildUpdate($id, $request->all());

            return response()->json([
                'status' => 'updated'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'errors' => [
                    $e->getMessage()
                ]
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->checkIfIdIsInt($id);

            $this->userService->buildDelete($id);

            return response()->json([
                'status' => 'deleted'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'errors' => [
                    $e->getMessage()
                ]
            ], 500);
        }
    }

    private function checkIfIdIsInt($id): mixed
    {
        if ((int) $id == 0) {
            throw new Exception("id need be int", 400);
        }

        return true;
    }
}
