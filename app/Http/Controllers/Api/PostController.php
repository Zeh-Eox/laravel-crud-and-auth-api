<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Post::query();
            $perPage = 10;
            $page = $request->input('page', 1);
            $search = $request->input('search');

            if($search)
            {
                $query->whereRaw("title LIKE'%". $search ."%'");
            }

            $total = $query->count();

            $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();


            return response()->json([
                'status_code' => 200,
                'status_message' => 'Posts recupérés avec success',
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
                'items' => $result
            ]);
        } catch (Exception $e) 
        {
            return response()->json($e);
        }
    }

    public function store(CreatePostRequest $request)
    {
        try {
            $post = new Post();

            $post->title = $request->title;
            $post->description = $request->description;
            $post->user_id = auth()->user()->id;

            $post->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Post creé avec success',
                'data' => $post
            ]);
        } catch(Exception $e)
        {
            return response()->json($e);
        }
    }

    public function update(EditPostRequest $request, Post $post)
    {
        try {
            $post->title = $request->title;
            $post->description = $request->description;
    
            if($post->user_id === auth()->user()->id)
            {
                $post->save();
            } else
            {
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'Auteur du poste invalide',
                    'data' => $post
                ]);
            }
    
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Post modifié avec success',
                'data' => $post
            ]);
        } catch (Exception $e) 
        {
            return response()->json($e);
        }
    }

    public function destroy(Post $post)
    {
        try {
            if($post->user_id === auth()->user()->id)
            {
                $post->delete();
            } else 
            {
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'Auteur du poste invalide',
                    'data' => $post
                ]);
            }

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Post supprimé avec success',
                'data' => $post
            ]);
        } catch (Exception $e) 
        {
            return response()->json($e);
        }
    }
}
