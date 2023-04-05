<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Ultainfinity\Ultainfinity;
use App\Http\Resources\ArticleResource;
use App\Http\Requests\CommentPostRequest;

class ArticleController extends Controller
{
    use Ultainfinity;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('id', 'desc')->paginate(10);
        return response()->json($articles, 200);
    }
    public function show($article_id)
    {
        $article = Article::find($article_id);
        if ($article) {
            return response()->json($article, 200);
        }
        return $this->AppResponse('failed', 'Article not found', 404);
    }
    public function like($article_id)
    {
        $article = Article::find($article_id);
        if ($article) {
            $count = $article->likes;
            $count = (int) $count + 1;
            $article->update(['likes' => $count]);
            return $this->AppResponse('success', "Like added successfully", 200);
        }
        return $this->AppResponse('failed', 'Invalid article', 404);
    }
    public function view($article_id)
    {
        $article = Article::find($article_id);
        if ($article) {
            $count = $article->views;
            $count = (int) $count + 1;
            $article->update(['views' => $count]);
            return $this->AppResponse('success', "View added successfully", 200);
        }
        return $this->AppResponse('failed', 'Invalid article', 404);
    }



    public function comment(CommentPostRequest $request, $article_id)
    {
        $article = Article::find($article_id);
        if ($article) {
            $input = $request->validated();
            $input['article_id'] = $article->id;
            // sleep (600);
            Comment::create($input);
            return $this->AppResponse('success', "Comment added successfully", 200);
        }
        return $this->AppResponse('failed', 'Invalid article', 404);
    }

}
