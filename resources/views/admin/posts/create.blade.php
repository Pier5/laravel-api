@extends('layouts.admin')

@section('title', "Crea Post")

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
            <form method="post" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Titolo</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descrizione</label>
                    <textarea class="form-control" name="description" id="description">{{ old('description') }}</textarea>
                </div>
                <div class="mb-1">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}">                
                </div>
               <div class="col-3 mb-3">
                    <input type="button" value="Genera slug" id="btn-slugger" class="btn btn-primary">
                </div>
                <div class="mb-3">
                    <select class="form-select" name="category_id" id="category">
                        <option value="" selected>Seleziona una categoria</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->type }}</option>
                        @endforeach
                    </select>
                </div>


                <fieldset class="mb-3">
                    <legend>Tags</legend>
                    @foreach ($tags as $tag)
                        <input type="checkbox" name="tags[]" id="tag-{{ $tag->id }}" value="{{ $tag->id }}"
                            @if (in_array($tag->id, old('tags', []))) checked @endif>
                        <label class="me-4" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                    @endforeach
                </fieldset>

                <div class="mb-3 col-4">
                    <label for="post_img" class="form-label">Carica una immagine</label>
                    <input class="form-control" type="file" id="post_img" name="post_img" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary mt-4">Salva</button>
            </form>
            <a href="{{ route('admin.home') }}" class="btn btn-dark my-4">Torna alla home</a>
        </div>
    </div>
  </div>
@endsection