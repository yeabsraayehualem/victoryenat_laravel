{% extends "base.html" %} {% load static %} {% block content %}

    <div class="crumbs-area">
        <div class="container">
            <div class="crumb-content">
                <h4 class="crumb-title"><span>Contact </span>Us</h4>
            </div>
        </div>
    </div>
   
    <div class="contact-info ptb--120">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="cnt-info">
                        <h4>Contact Info</h4>
                        <p>Address</p>
                        <ul class="address">
                            <li><i class="fa fa-phone"></i>+251921139577</li>
                            <li><i class="fa fa-phone"></i>+251921139577</li>
                            <li><i class="fa fa-envelope"></i>contact@Victory.com</li>
                        </ul>
                        <ul class="social list-inline mt-5">
                             <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                          
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3940.708861364078!2d38.7841601744985!3d8.99891438946025!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x164b85e9d21532d1%3A0xaa03ce0d1a2ec63d!2zQWxlbW5lc2ggUGxhemEgfCBCb2xlIE1lZGhhbmlhbGVtIHwg4Yqg4YiI4Yid4YqQ4Yi9IOGNleGIi-GLmyB8IOGJpuGIjCDhiJ3hi7XhiJDhipLhiqDhiIjhiJ0!5e0!3m2!1sen!2set!4v1721117960443!5m2!1sen!2set" width="800" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
   
    <div class="contact-form-area pb--120">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="cnt-title">
                        <h4>Get in touch <span>with us</span></h4>
                        <p>discription </p>
                    </div>
                </div>
            </div>
            <div class="contact-form">
                <form>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="name" placeholder="Enter your name">
                        </div>
                        <div class="col-md-4">
                            <input type="email" name="email" placeholder="Your Email">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="subject" placeholder="Subject">
                        </div>
                        <div class="col-12">
                            <textarea name="msg" id="msg" placeholder="Your message here"></textarea>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit">SEND TO US</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
   {% endblock content %}