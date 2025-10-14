<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
class Post extends Model
{
    use Sluggable;
    protected $table="posts";
    protected $fillable=[
            "title",
            "description",
            "img",
            "content",
            "likes",
            "slug",
            "user_id",
            "category_id"
    ];

    public function sluggable(): array
    {

        return [
            'slug' => [
                'source' => 'title'
            ]
            ];

    }

    public function store(Request $request){
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        'category_id' => 'required'
    ], [
        'title.required' => 'El título es obligatorio.',
        'content.required' => 'El contenido es obligatorio.',
        'image.image' => 'Debe ser una imagen válida.',
        'category_id.required' => 'Seleccione una categoría'
    ]);

    $file = $request->file('image');
    $filename = uniqid() . '.' . $file->getClientOriginalExtension();

// debe crear la carpeta posts en public
    $file->move(public_path('posts/'), $filename);

    $post = new Post();
    $post->title = $request->title;
    $post->description = $request->description;
    $post->content = $request->content;
    $post->img = $filename;
    $post->category_id = $request->category_id;
    $post->likes = 0;
    $post->user_id = Auth::user()->id; // el que está loggeado
    $post->save();

    return redirect()
        ->back()
        ->with('success', "Post insertado correctamente");

}


}



  