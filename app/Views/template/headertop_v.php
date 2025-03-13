<div class="header">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- Logo -->
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= base_url(); ?>">
                <!-- Logo icon -->
                <b>                    
                    <?php 
                    // $identitypicture=session()->get("identity_logo");
                    $identity_name=session()->get("identity_name");
                    $identity=$this->db->table("identity")->get()->getRow();
                    $identitypicture=$identity->identity_logo;
                    $identity_name=$identity->identity_name;
                    if($identitypicture!=""){$user_image="images/identity_logo/".$identitypicture."?".time();}else{$user_image="images/identity_logo/no_image.png";}?>
                    <img id="logotop" src="<?=base_url($user_image);?>" alt="homepage" class="dark-logo" />
                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
                <span><?=($identity_name!="")?$identity_name:"POS";?></span>
            </a>
        </div>
        <!-- End Logo -->
        <div class="navbar-collapse">
            <!-- toggle and nav items -->
            <ul class="navbar-nav mr-auto mt-md-0">
                <!-- This is  -->
                <li class="nav-item navitem"> 
                    <a class="nav-link navlink nav-toggler hidden-md-up text-muted  " href="javascript:void(0);">
                        <i class="mdi mdi-menu" onclick="bukasidebar();"></i>
                    </a> 
                </li>
                <li class="nav-item navitem m-l-10"> 
                    <a class="nav-link navlink sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0);">
                        <i class="ti-menu"></i>
                    </a> 
                </li>
                <script>
                    function bukasidebar(){
                        setTimeout(() => {
                            $(".mini-sidebar.fix-sidebar .left-sidebar").css({"position":"fixed","left":"0px"}).toggle();
                        }, 100);                        
                    }
                    $(document).ready(function(){
                        bukasidebar();
                    });
                </script>
                <!-- 
                <li class="nav-item dropdown mega-dropdown"> <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-th-large"></i></a>
                    <div class="dropdown-menu animated zoomIn">
                        <ul class="mega-dropdown-menu row">


                            <li class="col-lg-3  m-b-30">
                                <h4 class="m-b-20">CONTACT US</h4>
                                <form>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="exampleInputname1" placeholder="Enter Name">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Enter email">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Message"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-info">Submit</button>
                                </form>
                            </li>

                            <li class="col-lg-3 col-xlg-3 m-b-30">
                                <h4 class="m-b-20">List style</h4>                                
                                <ul class="list-style-none">
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                </ul>
                            </li>
                            
                        </ul>
                    </div>
                </li>
                -->
            </ul>
            <!-- User profile and search -->
            <ul class="navbar-nav my-lg-0">

                <!--
                <li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-search"></i></a>
                    <form class="app-search">
                        <input type="text" class="form-control" placeholder="Search here"> <a class="srh-btn"><i class="ti-close"></i></a>
                    </form>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-bell"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn">
                        <ul>
                            <li>
                                <div class="drop-title">Notifications</div>
                            </li>
                            <li>
                                <div class="message-center">
                                    
                                    <a href="#">
                                        <div class="btn btn-danger btn-circle m-r-10"><i class="fa fa-link"></i></div>
                                        <div class="mail-contnet">
                                            <h5>This is title</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span>
                                        </div>
                                    </a>                                    
                                </div>
                            </li>
                            <li>
                                <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
               
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted  " href="#" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-envelope"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn" aria-labelledby="2">
                        <ul>
                            <li>
                                <div class="drop-title">You have 4 new messages</div>
                            </li>
                            <li>
                                <div class="message-center">
                                    
                                    <a href="#">
                                        <div class="user-img"> <img src="images/users/5.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Michael Qin</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span>
                                        </div>
                                    </a>                                   
                                </div>
                            </li>
                            <li>
                                <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </div>
                </li>
                -->
                <!-- End Messages -->
                <!-- Profile -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="images/global/user.png" alt="user" class="profile-pic" style="height: 20px;width:auto; margin-right:5px;" />
                        <?= $this->session->get("contact_first_name"); ?> <?= $this->session->get("contact_last_name"); ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                        <ul class="dropdown-user">
                            <li><a href="<?= base_url("mpassword"); ?>"><i class="ti-user"></i> Change Password</a></li>
                            <!--<li><a href="#"><i class="ti-wallet"></i> Balance</a></li>
                            <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                            <li><a href="#"><i class="ti-settings"></i> Setting</a></li>-->
                            <li><a href="<?= base_url("logout"); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>