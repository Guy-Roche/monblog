<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //lister les articles
    public function index()
    {
        $posts = Post::orderby('id', 'asc')->paginate(10);
        return view('accueil', ['posts' =>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //créer un article
        return view('posts.back.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //recuperer les éléments du formulaire
        // afin de créer un article
        $post = Post::create($request->all());
        //on verifie si notre requete contient
        // un imput de type file dont le name est image
        if ($request->hasFile('image') ) {
            $image = $request->file('image');
            //15453005.png
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save(storage_path('app/public/images/posts/'.$filename));
            $post->image = $filename;
            $post->save();
        }
        return redirect('home')->with('status', 'Votre article a été ajouté avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' =>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
        return view('posts.back.edit', ['post' =>$post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
          //recuperer les éléments du formulaire
        // afin de créer un article
        $post->update($request->all());
        //on verifie si notre requete contient
        // un imput de type file dont le name est image
        if ($request->hasFile('image') ) {
            $image = $request->file('image');
            //15453005.png
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save(storage_path('app/public/images/posts/'.$filename));
            $post->image = $filename;
            $post->save();
        }
        return redirect('home')->with('status', 'Votre article a été modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        $post->delete();
        return redirect('home')->with('status', 'Votre article a été supprimé avec succès');
    }
}
