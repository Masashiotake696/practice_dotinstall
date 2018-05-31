@extends('layouts.default')

{{--
@section('title')
Blog Posts
@endsection
--}}

@section('title', 'Blog Posts')

@section('content')
<h1>
  <a href="{{ url('/posts/create') }}" class="header-menu">New Post</a>
  Blog Posts
</h1>
<ul>
  @forelse ($posts as $post)
  <li>
    <a href="{{ action('PostsController@show', $post)}}">{{ $post->title }}</a>
    <a href="{{ action('PostsController@edit', $post)}}" class="edit">[Edit]</a>
    <a href="#" class="delete" data-id="{{ $post->id }}">[×]</a>
    <form method="post" action="{{ url('/posts', $post )}}" id="form_{{ $post->id }}">
      {{ csrf_field() }}
      {{ method_field('delete') }}
    </form>
  </li>
  @empty
  <li>No Posts yet</li>
  @endforelse
</ul>
<script src="/js/main.js"></script>
@endsection
