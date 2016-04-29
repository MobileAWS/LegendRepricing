<?php include_once('header.php'); ?>
<?php include_once('nav-inner.php'); ?>

   
<article>
    <div class="container">
         <h1>Contact Us</h1>
         <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="box-sendMessage"> 
                    <p>We're here to listen. We will answer your email within 24 hours</p>
                   
                   <form id="feedback_form">
                            <div class="input-group"> 
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" value="" title="Enter your full name" name="name" placeholder="Name">
                            </div>
                            <div class="input-group"> 
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <input type="tel" value="" title="Enter your contact number" name="contact_no" placeholder="Contact No."></div>
                            <div class="input-group"> 
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input id="feedback_email" type="email" value="" title="Enter your email address" class="input-user" placeholder="Email" name="email"></div>
                            <div class="input-group"> 
                                    <span class="input-group-addon" style="vertical-align:top;"><i class="fa fa-pencil"></i></span>
                                    <textarea title="Enter your message" name="message" placeholder="Message"></textarea>
                            </div>
                            <p><input type="button" id="feedback_button" class="btn" name="submit" value="Send" title="Send"></p>
                        </form>
                    </div>
                    
                 </div> 
                    </div>          
                </div> 
         </div> 
    </div>
</article>

    <?php include_once('footer.php'); ?>
