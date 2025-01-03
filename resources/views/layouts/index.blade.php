@extends('layouts.base')
@section('content')

<div class="offset-search">
    <form action="#">
      <input type="text" name="search" placeholder="Search here..." />
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
  <div class="body_overlay"></div>
  <div class="slider-area owl-carousel has-color">
    <div class="slider_item" style="
        background: url(/images/bg/slider-bg1.png) center/cover
          no-repeat;">
      <div class="container">
        <div class="row">
          <div class="col-lg-7 col-md-9">
            <div class="slider-content">
              <h3>Take Exams</h3>
              <h1>
                <span class="primary-color">Your bright future</span> is Our
                Mission
              </h1>
              <p>
                there will be a discription here that will be providede buy
                victory
              </p>
              <a class="btn btn-primary btn-round btn-lg mt-5" href="#">Start Now</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="slider_item" style="
        background: url(/images/bg/slider-bg2.png) center/cover
          no-repeat;">
      <div class="container">
        <div class="row">
          <div class="col-lg-7 col-md-9">
            <div class="slider-content">
              <h3>Take Exams</h3>
              <h1>
                <span class="primary-color">Your bright future</span> is Our
                Mission
              </h1>
              <p>
                there will be a discription here that will be providede buy
                victory
              </p>
              <a class="btn btn-primary btn-round btn-lg mt-5" href="#">Start Learning Now</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="slider_item" style="
        background: url(/images/bg/slider-bg3.jpg) center/cover no-repeat;">
      <div class="container">
        <div class="row">
          <div class="col-lg-7 col-md-9">
            <div class="slider-content">
              <h3>Take Exams</h3>
              <h1>
                <span class="primary-color">Your bright future</span> is Our
                Mission
              </h1>
              <p>
                there will be a discription here that will be providede buy
                victory
              </p>
              <a class="btn btn-primary btn-round btn-lg mt-5" href="#">Start Learning Now</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="about-area ptb--120">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="about-left-content">
            <div class="section-title">
              <span class="text-uppercase">about us</span>
              <h2>Welcome to</h2>
              <h2>
                <span>Our </span> <span class="primary-color">Platform</span>
              </h2>
            </div>
            <p>
              there will be a discription here that will be providede buy victory
            </p>
            <a class="btn btn-primary btn-round" href="#">Read more</a>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="abt-right-thumb">
            <div class="abt-rt-inner">
              <a class="expand-video" href="https://www.youtube.com/watch?v=PdAu-FI-Q5M"><i class="fa fa-play"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="course-area pt--120 pb--70">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="section-title">
            <span class="text-uppercase">Train for your Upcoming Exam</span>
            <h2>Featured Exams</h2>
          </div>
        </div>
      </div>

      <div class="commn-carousel owl-carousel card-deck">
        <div class="card mb-5">
          <div class="course-thumb">
            <img src="/images/course/Chemistry.jpg" alt="image" />
            <span class="cs-price primary-bg">ETB 150</span>
          </div>
          <div class="card-body p-25">
            <div class="course-meta-title mb-4">
              <div class="course-meta-text">
                <h4><a href="course-details.html">Chemistry</a></h4>
                <ul class="course-meta-stats">
                  <li>
                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                      class="fa fa-star"></i><i class="fa fa-star-half"></i>
                  </li>
                  <li>36 <i class="fa fa-comment"></i></li>
                  <li>85 <i class="fa fa-heart"></i></li>
                </ul>
              </div>
              <a href="course-details.html"><img class="course-meta-thumbnail rounded-circle"
                  src="" alt="image" />
              </a>
            </div>
            <p>
              there will be a discription here that will be providede buy victory
            </p>
            <ul class="course-meta-details list-inline w-100">
              <li>
                <p>School</p>
                <span>this School</span>
              </li>
              <li>
                <p>Questions</p>
                <span>180</span>
              </li>
              <li>
                <p>Duration</p>
                <span>1 hour</span>
              </li>
            </ul>
          </div>
        </div>

        <div class="card mb-5">
          <div class="course-thumb">
            <img src="/images/course/Chemistry.jpg" alt="image" />
            <span class="cs-price primary-bg">ETB 150</span>
          </div>
          <div class="card-body p-25">
            <div class="course-meta-title mb-4">
              <div class="course-meta-text">
                <h4><a href="course-details.html">Chemistry</a></h4>
                <ul class="course-meta-stats">
                  <li>
                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                      class="fa fa-star"></i><i class="fa fa-star-half"></i>
                  </li>
                  <li>36 <i class="fa fa-comment"></i></li>
                  <li>85 <i class="fa fa-heart"></i></li>
                </ul>
              </div>
              <a href="course-details.html"><img class="course-meta-thumbnail rounded-circle"
                  src="" alt="image" />
              </a>
            </div>
            <p>
              there will be a discription here that will be providede buy victory
            </p>
            <ul class="course-meta-details list-inline w-100">
              <li>
                <p>School</p>
                <span>this School</span>
              </li>
              <li>
                <p>Questions</p>
                <span>180</span>
              </li>
              <li>
                <p>Duration</p>
                <span>1 hour</span>
              </li>
            </ul>
          </div>
        </div>
        <div class="card mb-5">
          <div class="course-thumb">
            <img src="/images/course/Chemistry.jpg" alt="image" />
            <span class="cs-price primary-bg">ETB 150</span>
          </div>
          <div class="card-body p-25">
            <div class="course-meta-title mb-4">
              <div class="course-meta-text">
                <h4><a href="course-details.html">Chemistry</a></h4>
                <ul class="course-meta-stats">
                  <li>
                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                      class="fa fa-star"></i><i class="fa fa-star-half"></i>
                  </li>
                  <li>36 <i class="fa fa-comment"></i></li>
                  <li>85 <i class="fa fa-heart"></i></li>
                </ul>
              </div>
              <a href="course-details.html"><img class="course-meta-thumbnail rounded-circle"
                  src="" alt="image" />
              </a>
            </div>
            <p>
              there will be a discription here that will be providede buy victory
            </p>
            <ul class="course-meta-details list-inline w-100">
              <li>
                <p>School</p>
                <span>this School</span>
              </li>
              <li>
                <p>Questions</p>
                <span>180</span>
              </li>
              <li>
                <p>Duration</p>
                <span>1 hour</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="take-toure-area ptb--120">
    <div class="container">
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div class="section-title sec-style-two">
            <img class="title-top-shape" src="/images/icon/title-top-shape.png" alt="image" />
            <span class="text-uppercase">Take A Tour</span>
            <h2>Video tour on Victory</h2>
          </div>
        </div>
      </div>
      <div class="video-area">
        <a class="expand-video" href="https://www.youtube.com/watch?v=PdAu-FI-Q5M"><i class="fa fa-play"></i></a>
      </div>
    </div>
  </div>

  <div class="teacher-area pb--70">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 col-md-6">
          <div class="section-title">
            <span class="text-uppercase">Questions from best</span>
            <h2>Schools</h2>
          </div>
        </div>
      </div>
      <div class="commn-carousel owl-carousel card-deck">
        <div class="card mb-5">
          <img src="/images/teacher/school.png" alt="image" />
          <div class="card-body teacher-content p-25">
            <h4 class="card-title mb-4">
              <a href="teacher-details.html">Adama School</a>
            </h4>
            <span class="primary-color font-italic d-block mb-3">Public</span>
            <p class="card-text">
              there will be a discription here that will be providede buy victory
            </p>

            <ul class="list-inline">
              <li>
                <a href="#"><i class="fa fa-facebook"></i></a>
              </li>
              <li>
                <a href="#"><i class="fa fa-twitter"></i></a>
              </li>
            </ul>
          </div>
        </div>

        <div class="card mb-5">
          <img src="/images/teacher/school.png" alt="image" />
          <div class="card-body teacher-content p-25">
            <h4 class="card-title mb-4">
              <a href="teacher-details.html">Adama School</a>
            </h4>
            <span class="primary-color font-italic d-block mb-3">Public</span>
            <p class="card-text">
              there will be a discription here that will be providede buy victory
            </p>

            <ul class="list-inline">
              <li>
                <a href="#"><i class="fa fa-facebook"></i></a>
              </li>
              <li>
                <a href="#"><i class="fa fa-twitter"></i></a>
              </li>
            </ul>
          </div>
        </div>

        <div class="card mb-5">
          <img src="/images/teacher/school.png" alt="image" />
          <div class="card-body teacher-content p-25">
            <h4 class="card-title mb-4">
              <a href="teacher-details.html">Adama School</a>
            </h4>
            <span class="primary-color font-italic d-block mb-3">Public</span>
            <p class="card-text">
              there will be a discription here that will be providede buy victory
            </p>

            <ul class="list-inline">
              <li>
                <a href="#"><i class="fa fa-facebook"></i></a>
              </li>
              <li>
                <a href="#"><i class="fa fa-twitter"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card mb-5">
          <img src="/images/teacher/school.png" alt="image" />
          <div class="card-body teacher-content p-25">
            <h4 class="card-title mb-4">
              <a href="teacher-details.html">Adama School</a>
            </h4>
            <span class="primary-color font-italic d-block mb-3">Public</span>
            <p class="card-text">
              there will be a discription here that will be providede buy victory
            </p>

            <ul class="list-inline">
              <li>
                <a href="#"><i class="fa fa-facebook"></i></a>
              </li>
              <li>
                <a href="#"><i class="fa fa-twitter"></i></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="event-area pt--120 pb--80">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="section-title">
            <span class="text-uppercase">Join with us</span>
            <h2>Upcoming Tests to</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="media align-items-center mb-5">
            <div class="media-head primary-bg">
              <span><sub>MAR</sub>25</span>
              <p>2024</p>
            </div>
            <div class="media-body">
              <h4><a href="#">Biology</a></h4>
              <p><i class="fa fa-clock-o"></i>05:23 AM - 09:23 AM</p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="media align-items-center mb-5">
            <div class="media-head primary-bg">
              <span><sub>MAR</sub>25</span>
              <p>2024</p>
            </div>
            <div class="media-body">
              <h4><a href="#">Biology</a></h4>
              <p><i class="fa fa-clock-o"></i>05:23 AM - 09:23 AM</p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="media align-items-center mb-5">
            <div class="media-head primary-bg">
              <span><sub>MAR</sub>25</span>
              <p>2024</p>
            </div>
            <div class="media-body">
              <h4><a href="#">Biology</a></h4>
              <p><i class="fa fa-clock-o"></i>05:23 AM - 09:23 AM</p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="media align-items-center mb-5">
            <div class="media-head primary-bg">
              <span><sub>MAR</sub>25</span>
              <p>2024</p>
            </div>
            <div class="media-body">
              <h4><a href="#">Biology</a></h4>
              <p><i class="fa fa-clock-o"></i>05:23 AM - 09:23 AM</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="testimonial-area ptb--120">
    <img class="tst-bg" src="/images/bg/tst-bg-shape.png" alt="image" />
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3 text-center">
          <div class="tst-carousel owl-carousel">
            <div class="testimonial-content pb--40">
              <div class="section-title sec-style-two">
                <span class="text-uppercase primary-color mb-0">happy students</span>
                <h2>Testimonial</h2>
              </div>
              <h3>
                there will be a discription here that will be providede buy
                victory
              </h3>
              <h4>Samson</h4>
              <span>school adama</span>
            </div>
            <div class="testimonial-content pb--40">
              <div class="section-title sec-style-two">
                <span class="text-uppercase primary-color mb-0">happy students</span>
                <h2>Testimonial</h2>
              </div>
              <h3>
                there will be a discription here that will be providede buy
                victory
              </h3>
              <h4>Samson</h4>
              <span>school adama</span>
            </div>
            <div class="testimonial-content pb--40">
              <div class="section-title sec-style-two">
                <span class="text-uppercase primary-color mb-0">happy students</span>
                <h2>Testimonial</h2>
              </div>
              <h3>
                there will be a discription here that will be providede buy
                victory
              </h3>
              <h4>Samson</h4>
              <span>school adama</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="feature-blog pt--120 pb--70">
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
          <div class="card mb-5">
            <img class="card-img-top" src="/images/blog/572.png" alt="image" />
            <div class="card-body p-25">
              <ul class="list-inline primary-color mb-3">
                <li><i class="fa fa-clock-o"></i> AUGUST 6, 2024</li>
                <li><i class="fa fa-comments"></i> 3 Comments</li>
              </ul>
              <h4 class="card-title mb-4">
                <a href="blog-details.html">How are schools</a>
              </h4>
              <p class="card-text">
                there will be a discription here that will be providede buy
                victory
              </p>
              <a class="btn btn-primary btn-round btn-sm" href="blog-details.html">
                Read More
              </a>
            </div>
          </div>
          <div class="card mb-5">
            <img class="card-img-top" src="/images/blog/572.png" alt="image" />
            <div class="card-body p-25">
              <ul class="list-inline primary-color mb-3">
                <li><i class="fa fa-clock-o"></i> AUGUST 6, 2024</li>
                <li><i class="fa fa-comments"></i> 3 Comments</li>
              </ul>
              <h4 class="card-title mb-4">
                <a href="blog-details.html">How are schools</a>
              </h4>
              <p class="card-text">
                there will be a discription here that will be providede buy
                victory
              </p>
              <a class="btn btn-primary btn-round btn-sm" href="blog-details.html">
                Read More
              </a>
            </div>
          </div>

          <div class="card mb-5">
            <img class="card-img-top" src="/images/blog/572.png" alt="image" />
            <div class="card-body p-25">
              <ul class="list-inline primary-color mb-3">
                <li><i class="fa fa-clock-o"></i> AUGUST 6, 2024</li>
                <li><i class="fa fa-comments"></i> 3 Comments</li>
              </ul>
              <h4 class="card-title mb-4">
                <a href="blog-details.html">How are schools</a>
              </h4>
              <p class="card-text">
                there will be a discription here that will be providede buy
                victory
              </p>
              <a class="btn btn-primary btn-round btn-sm" href="blog-details.html">
                Read More
              </a>
            </div>
          </div>
          <div class="card mb-5">
            <img class="card-img-top" src="/images/blog/572.png" alt="image" />
            <div class="card-body p-25">
              <ul class="list-inline primary-color mb-3">
                <li><i class="fa fa-clock-o"></i> AUGUST 6, 2024</li>
                <li><i class="fa fa-comments"></i> 3 Comments</li>
              </ul>
              <h4 class="card-title mb-4">
                <a href="blog-details.html">How are schools</a>
              </h4>
              <p class="card-text">
                there will be a discription here that will be providede buy
                victory
              </p>
              <a class="btn btn-primary btn-round btn-sm" href="blog-details.html">
                Read More
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="cta-area primary-bg has-color ptb--50">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-9">
          <div class="cta-content">
            <p class="mb-2">Click to Join the Advance Learning</p>
            <h2>Training in advance Learning</h2>
          </div>
        </div>
        <div class="col-md-3">
          <div class="cta-btn">
            <a class="btn btn-light btn-round" href="#">Join Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
