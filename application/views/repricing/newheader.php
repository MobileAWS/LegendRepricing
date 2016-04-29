<div id="header">
                <div id="regularBanner">
  
                    <nav id="banner" class="navbar navbar-default" role="navigation">

                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#jsNavbarCollapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="logoLink navbar-brand" id="logo" href="/"></a>
                        </div>
    
                        <div class="collapse navbar-collapse" id="jsNavbarCollapse">                                       
                            <div id="menuControl1_MenuPanel">
    
    <ul class="nav navbar-nav">  
      <li id="menuControl1_menuDashboard"><a href="dashboard.aspx">dashboard</a></li>
        <li id="menuControl1_menuListings" class="active"><a href="listings.aspx">listings</a></li>
      
        <li id="menuControl1_menuInsight"><a href="activity.aspx">insight</a></li>
        <li id="menuControl1_menuSettings"><a href="strategies.aspx">manage</a></li>
    </ul>

  </div>                                                  
                            

<ul id="navDropdown" class="nav navbar-nav navbar-right">       
    <li>
        <div id="search-container" class="right-menu">
          <div id="menu-search-textbox-constraint" class="input-group">
            <input name="ctl00$headerMenuControl$menuSearchTextBox" id="headerMenuControl_menuSearchTextBox" class="menu-search-textbox form-control" type="text" value="search your listings" defaultvalue="search your listings" style="color:#cccccc;">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" onclick="DoSearch();"><i class="fa fa-search"></i></button>
                </span> 
          </div>
            <div class="search-textbox-validation">You must enter at least 3 characters</div>
            <script type="text/javascript">
                $('.menu-search-textbox').keypress(function (e) {
                    $('.search-textbox-validation').removeClass('invalid'); 
                    if (e.keyCode == 13) {
                        DoSearch(); return false;
                    }
                })
                function DoSearch() {
                    if ($('.menu-search-textbox').val().length > 2) {
                        __doPostBack('search', 0);
                    } else {
                        $('.search-textbox-validation').addClass('invalid');
                    }                    
                }
            </script>

            <!-- <a class="" data-toggle="collapse" data-target="#jsNavbarCollapse">↑</a> -->
        </div>
    </li>

    <li id="inboxDropdown" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-inbox fa-lg fa-inverse fa-fw"></i>
            <b class="caret"></b>
            <div class="inbox-count" style="display:none;">0</div>
        </a>
        <ul class="dropdown-menu inbox-message-container">
          <li>
          <a href="#" class="inbox-message inbox-info" id="no-notifications">
            <div class="inbox-title">No new notifications</div>
            <div class="inbox-body">You have no new notifications</div> 
          </a>
          </li>
        </ul>
    </li>

    <li id="userDropdown" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-user fa-lg fa-inverse fa-fw"></i>
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a href="profile.aspx">Profile</a></li>
            <li><a href="subscription.aspx">Subscription</a></li>
            <li><a href="addons.aspx">Add-Ons</a></li>
            <!--<li><a href="invoices.aspx">Invoices</a></li>-->
            <li role="presentation" class="divider"></li>            
          <li><a href="logout.aspx" class="logout-link">Logout</a></li>
        </ul>
    </li>
</ul>

                        </div>

                    </nav>
                
</div>

          

            </div>
