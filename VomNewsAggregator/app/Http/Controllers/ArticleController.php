<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    public function getAllArticles(Request $request){
        $query = Article::query();
        if($request->has('source')){
            $query->where('source',$request->input('source'));
        }
        if ($request->has('date')) {
            $query->whereDate('published_at', $request->input('date'));
        }
        if ($request->has('category')) {
            $query->where('category', $request->input('category'));
        }

        $articles = $query->paginate(10);
        return response()->json($articles);

    }

    public function getSingleArticle($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        return response()->json($article);
    }

    public function getFeaturedArticles(){
        $articles = Article::orderBy('published_at', 'desc')->take(5)->get();
        return response()->json($articles);
    }
}
