<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helpers\ApiFormatter;
use Illuminate\Http\Request;
use App\Models\Articles;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Articles::all();
        if ($articles) {
            return ApiFormatter::createApi(200, 'Success', $articles);
        } else {
            return ApiFormatter::createApi(404, 'Not Found', null);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'content' => 'required',
                'author' => 'required',
            ]);

            $article = new Articles;
            $article->title = $request->title;
            $article->slug = $request->slug;
            $article->content = $request->content;
            $article->image = $request->image;
            $article->author = $request->author;
            $article->is_deleted = 0;
            $article->save(); 

            return ApiFormatter::createApi(200, 'Success', $article);
        } catch (Exception $e) {
            return ApiFormatter::createApi(500, 'Internal Server Error', null);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $article = Articles::findorfail($id);
            return ApiFormatter::createApi(200, 'Success', $article);
        } catch (Exception $e) {
            return ApiFormatter::createApi(500, 'Internal Server Error', null);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'content' => 'required',
                'author' => 'required',
            ]);

            $article = Articles::findorfail($id);
            $article->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'image' => $request->image,
                'author' => $request->author,
                'is_deleted' => 0,
            ]);

            return ApiFormatter::createApi(200, 'Success', $article);
        } catch (Exception $e) {
            return ApiFormatter::createApi(500, 'Internal Server Error', null);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $article = Articles::findorfail($id);
            $data = $article->delete();
            return ApiFormatter::createApi(200, 'Success');
        } catch (Exception $e) {
            return ApiFormatter::createApi(500, 'Internal Server Error', null);
        }
    }
}
