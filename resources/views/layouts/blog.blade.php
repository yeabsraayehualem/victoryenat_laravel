@extends('layouts.base')
@section('content')

<div class="body_overlay"></div>

    <div class="crumbs-area">
        <div class="container">
            <div class="crumb-content">
                <h4 class="crumb-title"><span>Blog</span> & News</h4>
            </div>
        </div>
    </div>
    <div class="feature-blog  pt--120 pb--70">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="section-title">
                        <span class="text-uppercase">Top stories</span>
                        <h2>Blog & Events</h2>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="blog-carousel owl-carousel card-deck">
                  {{-- {% for blog in blogs %} --}}
                  <div class="card mb-5">
                      <img class="card-img-top" src="" alt="">
                      <div class="card-body p-25">
                          <ul class="list-inline primary-color mb-3">
                              <li><i class="fa fa-clock-o"></i></li>
                          </ul>
                          <h4 class="card-title mb-4"><a href="">title</a></h4>
                          <p class="card-text">content</p>
                          <a class="btn btn-primary btn-round btn-sm" href=""> Read More </a>
                      </div>
                  </div>
                  {{-- {% empty %} --}}
                  <p>No blog posts available.</p>
                  {{-- {% endfor %} --}}
              </div>
          </div>
        </div>
    </div>

    @endsection
