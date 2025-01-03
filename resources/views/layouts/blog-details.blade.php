{% extends "base.html" %} {% load static%}  {% block content%}

    <div class="body_overlay"></div>
 
    <div class="crumbs-area">
        <div class="container">
            <div class="crumb-content">
                <h4 class="crumb-title"><span>Single</span> Blog Deatils</h4>
            </div>
        </div>
    </div>
   
    <div class="blog-details-area ptb--120">
        <div class="container">
            <div class="row">
                <!-- course details start -->
                <div class="col-lg-8 col-md-8">
                    <div class="course-details">
                        <div class="cs-thumb mb-5">
                            <img src="assets/images/blog/" alt="image">
                        </div>
                        <div class="cs-content">
                            <div class="blog-top-meta">
                                <ul>
                                    <li><i class="fa fa-user"></i>By <span>admin</span></li>
                                    <li><i class="fa fa-tag"></i> tag</li>
                                 
                                </ul>
                            </div> 
                            <h3 class="mb-4"><a href="#">title </a></h3>
                                
                            <p>discription.</p>
                            <p>discription</p>
                            <div class="cs-post-share">
                                <div class="row align-items-center">
                                    <div class="col-lg-5 col-md-12 col-sm-8">
                                        <div class="tags">
                                            <h4> <strong>TAG</strong></h4>
                                            <ul class="list-inline">
                                                <li><a href="#">catagory</a></li>
                                                
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-12 col-sm-4">
                                        <div class="cs-share-right">
                                            <ul class="cs-social">
                                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- comments area end -->
                   
                    

                </div>
              
                <div class="col-lg-4 col-md-4">
                    <div class="sidebar">
                       
                        <div class="widget widget-search">
                            <h4 class="widget-title">Search</h4>
                            <form>
                                <input type="text" name="search" placeholder="Search...">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        
                        <div class="widget widget-category">
                            <h4 class="widget-title">Categories</h4>
                            <ul class="list">
                                <li><a href="#">GMAT</a></li>
                                <li><a href="#">BUSINESS</a></li>
                                <li><a href="#">CSE</a></li>
                                <li><a href="#">PYTHON</a></li>
                                <li><a href="#">EDEDE</a></li>
                            </ul>
                        </div>
                       
                    </div>
                </div>
               
            </div>
        </div>
    </div>
  

{% endblock content %}