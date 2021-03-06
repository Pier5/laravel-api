<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Post;
use App\User;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    private function getValidators($model) {
        return [
            'title'     => 'required|max:100',
            'slug'      => [
                'required',
                Rule::unique('posts')->ignore($model),
                'max:100'
            ],
            'category_id'   => 'required|exists:App\Category,id',
            'description'   => 'required',
            'tags'          => 'required|exists:App\Tag,id',
            'post_image'    => 'nullable|image'
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::where('id', '>', 0);

        if ($request->s) {
            $posts->where('title', 'LIKE', "%$request->s%");
        }

        if ($request->category) {
            $posts->where('category_id', $request->category);
        }

        if ($request->author) {
            $posts->where('user_id', $request->author);
        }

        $posts = $posts->paginate(20);
        $queries = $request->query();
        unset($queries['page']);
        $posts->withPath('?' . http_build_query($queries, '', '&'));

        $categories = Category::all();
        $users = User::all();

        return view('admin.posts.index', [
            'posts'         => $posts,
            'categories'    => $categories,
            'users'         => $users,
            'request'       => $request
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', [
            'categories'    => $categories,
            'tags'          => $tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate($this->validationRules);
        $request->validate($this->getValidators(null));

        $data = $request->all();

        $img_path = Storage::put('uploads', $data['post_image']);

        $formData = [
            'user_id'       => Auth::user()->id,
            'post_image'    => $img_path
        ] + $data;


        // creare nuovi tag nel campo descrizione del create con la #
        
        /*
         preg_match_all('/#(\S*)\b/', $formData['description'], $tags_from_content);
         $tagIds = [];
         foreach($tags_from_content[1] as $tag) {
             $newTag = Tag::create([
                 'name'  => $tag,
                 'slug'  => $tag
             ]);

             $tagIds[] = $newTag->id;
         }
         $formData['tags'] = $tagIds;
        */
        
        $post = Post::create($formData);
        $post->tags()->attach($formData['tags']);

        return redirect()->route('admin.posts.show', $post->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (Auth::user()->id !== $post->user_id) abort(403);
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', [
            'post'          => $post,
            'categories'    => $categories,
            'tags'          => $tags
        ]); 
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
        if (Auth::user()->id !== $post->user_id) abort(403);
        // $request->validate($this->validationRules);
    
        $request->validate($this->getValidators($post));
        $formData = $request->all();

        if (array_key_exists('post_image', $formData)) {
            Storage::delete($post->post_image);
            $img_path = Storage::put('uploads', $formData['post_image']);
            $formData = [
                'post_image'    => $img_path
            ] + $formData;
        }

        $post->update($formData);
        if (array_key_exists('tags', $formData)) $post->tags()->sync($formData['tags']);
        $post->tags()->sync($formData['tags']);

        return redirect()->route('admin.posts.show', $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
