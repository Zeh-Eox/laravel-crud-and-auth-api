<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {       
        try {
            $query = User::query();
            $perPage = 10;
            $page = $request->input('page', 1);
            $search = $request->input('search');

            if($search)
            {
                $query->whereRaw("name LIKE'%". $search ."%'");
            }

            $total = $query->count();

            $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();


            return response()->json([
                'status_code' => 200,
                'status_message' => 'Utilisateurs recupérés avec success',
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
                'items' => $result
            ]);
        } catch (Exception $e) 
        {
            return response()->json($e);
        }
    }

    public function register(RegisterUserRequest $request)
    {
        try {
            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password, [
                'round' => 12
            ]);

            $user->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Utilisateurs inscrit avec success',
                'data' => $user
            ]);
        } catch(Exception $e)
        {
            return response()->json($e);
        }
    }

    public function login(LogUserRequest $request) 
    {
        try {
            if (auth()->attempt($request->only(['email', 'password']))) 
            {
                $user = auth()->user();
                $_token = $user
                            ->createToken('my_secret_token_only_visible_in_the_backend')
                            ->plainTextToken;
                
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Utilisateur Connecté',
                    'data' => $user,
                    'token' => $_token
                ]);
            } else 
            {
                return response()->json([
                    'status_code' => 403,
                    'status_message' => 'Informations invalides',
                ]);
            }
        } catch (Exception $e) 
        {
            
        }
    }
}
