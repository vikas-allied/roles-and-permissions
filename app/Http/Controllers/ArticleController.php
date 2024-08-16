<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::latest()->paginate(10); // order by created_at DESC
        return view('articles.list',[
            'articles' => $articles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|min:5',
            'author' => 'required|min:2'
        ]);
        if($validator->passes()){

            $data = $validator->validated();

            $article = new Article();

            if(!is_null($request->text))
            {
                $article->text = $request->text;
            }

            $article->title = $data['title'];
            $article->author = $data['author'];
            $article->save();

            return redirect()->route('articles.index')->with('success','Article created successfully');
        }
        else{
            return redirect()->route('articles.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::findOrFail($id);
        return view('articles.edit',[
            'article' => $article
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|min:5',
            'author' => 'required|min:2'
        ]);
        if($validator->passes()){

            $data = $validator->validated();

            $article = Article::findOrFail($id);

            if(!is_null($request->text))
            {
                $article->text = $request->text;
            }

            $article->title = $data['title'];
            $article->author = $data['author'];
            $article->save();

            return redirect()->route('articles.index')->with('success','Article updated successfully');
        }
        else{
            return redirect()->route('articles.edit', $id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::find($id);
        
        if($article == null) {
            session()->flash('error', 'Article not found');
            return response()->json([
                'status' => false
            ]);
        }

        $article->delete();
        session()->flash('success', 'Article deleted successfully');
        return response()->json([
            'status' => true
        ]);
    }
}
