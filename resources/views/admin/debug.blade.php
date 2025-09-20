@extends('admin.base')
@section('page-title','Admin Debug')
@section('content')
<div class="card">
  <div class="card-body">
    <p>ADMIN-DEBUG-VIEW: If you can read this and the page has navbar+sidebar, the admin.base layout is applied.</p>
  </div>
  <div class="card-body">
    <ul>
      <li>App env: {{ app()->environment() }}</li>
      <li>App debug: {{ config('app.debug') ? 'true' : 'false' }}</li>
      <li>Laravel: {{ app()->version() }}</li>
    </ul>
  </div>
  <div class="card-body">
    <pre>ADMIN-BASE-LOADED should appear in page source.</pre>
  </div>
  <!-- sentinel: ADMIN-DEBUG-CONTENT -->
@endsection
