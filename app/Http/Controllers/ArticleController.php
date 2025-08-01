<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
 use ApiResponseTrait;
//    public function __construct()
//    {
//        $this->middleware('permission:view-published')->only('index', 'show');
//        $this->middleware('permission:create-article')->only('store');
//        $this->middleware('permission:edit-own-article')->only('update');
//        $this->middleware('permission:delete-article')->only('destroy');
//        $this->middleware('permission:publish-article')->only('publish');
//    }


    public function index()
    {
        $articles = Article::where('status', 1)->get();
        return $this->successResponse($articles,200);
    }

    public function mine()
    {
        $user = Auth::user();
        $articles = Article::where('user_id', $user->id)->get();
        return response()->json($articles);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Failed', 422, $validator->errors());
        }
        $user = Auth::user();

        $article = Article::create([
            'title'    => $request->title,
            'slug'     => Str::slug($request->title),
            'body'     => $request->body,
            'status'   => 2,
            'user_id'   => $user->id,
        ]);
        return $this->successResponse($article,200);
    }

    public function update(Request $request, Article $article)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Failed', 422, $validator->errors());
        }

        $article->update([
            'title' => $request->title,
            'slug'  => Str::slug($request->title),
            'body'  => $request->body,
        ]);
        return $this->successResponse($article,200);
    }

    public function destroy(Article $article)
    {

        $article->delete();
        return response()->json(['message' => 'Article deleted.']);
    }

    public function publish(Article $article)
    {

        $article->update(['status' => 1]);

        return response()->json(['message' => 'Article published.']);
    }
}
