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
     * @OA\Get(
     *     path="/articles",
     *     summary="Get Articles",
     *     description="Returns a paginated list of articles",
     *     @OA\Response(
     *         response=200,
     *         description="Everything OK"
     *     )
     * )
     */
    public function index()
    {
        $articles = Article::orderBy('id', 'desc')->paginate(10);
        return response()->json($articles, 200);
    }

    /**
     * @OA\Get(
     *     path="/articles/{id}",
     *     summary="Get a single Article",
     *     description="Returns a single article",
     *    @OA\Parameter(
     *         name="article_id",
     *         in="path",
     *         description="ID of article to show",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Everything OK"
     *     )
     * )
     */
    public function show($article_id)
    {
        $article = Article::find($article_id);
        if ($article) {
            return response()->json($article, 200);
        }
        return $this->AppResponse('failed', 'Article not found', 404);
    }

     /**
     * @OA\Get(
     *     path="/articles/{id}/like",
     *     summary="Like a single Article",
     *      @OA\Parameter(
     *         name="article_id",
     *         in="path",
     *         description="ID of article to like",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Everything OK"
     *     )
     * )
     */
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

      /**
     * @OA\Get(
     *     path="/articles/{id}/view",
     *     summary="Add view count to a single Article",
     *      @OA\Parameter(
     *         name="article_id",
     *         in="path",
     *         description="ID of article to add view count",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Everything OK"
     *     )
     * )
     */
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


    /**
     * @OA\Post(
     *     path="articles/{id}/comment",
     *     summary="Add a comment",
     *     operationId="addcomment",
     *     description="Send params in form-data. Add Accept:application/json in header",
     *     operationId="comment",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Parameter(
     *         name="subject",
     *         in="query",
     *         description="subject",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *    @OA\Parameter(
     *         name="body",
     *         in="query",
     *         description="body",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * )
     */
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
