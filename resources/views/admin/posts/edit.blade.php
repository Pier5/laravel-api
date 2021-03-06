@extends('layouts.admin')

@section('title', "Modifica Post")

@section('content')
<div class="container mt-3">
    <div class="row">
        <div class="col">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.posts.update', $post->slug) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Titolo</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}">
                </div>
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ $post->slug }}">
                </div>
                <div class="mb-3">
                    <select class="form-select" name="category_id" id="category">
                        <option value="" selected>Seleziona una categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @if ($category->id == old('category_id', $post->category->id)) selected @endif>
                                    {{ $category->type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <fieldset class="mb-3">
                    <legend>Tags</legend>
                    @foreach ($tags as $tag)
                        <input type="checkbox" name="tags[]" id="tag-{{ $tag->id }}" value="{{ $tag->id }}"
                            @if (in_array($tag->id, old('tags', $post->tags->pluck('id')->all()))) checked @endif>
                        <label class="me-4" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                    @endforeach
                </fieldset>
                <div class="mb-3">
                    <label for="description" class="form-label">Descrizione</label>
                    <textarea class="form-control" name="description" id="description">{{ $post->description }}</textarea>
                </div>
                <div class="mb-3 col-4">
                    <label for="post_image" class="form-label">Carica una immagine</label>
                    <input class="form-control" type="file" id="post_image" name="post_image" accept="image/*">
                </div>
                <img src="{{ asset('storage/' . $post->post_image) }}" alt="{{ $post->title }}" class="mb-3 w-25 d-block">
                <button type="submit" class="btn btn-primary">Salva</button>
            </form>
        </div>
    </div>
  </div>
@endsection