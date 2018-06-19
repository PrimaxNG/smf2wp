     <!-- Static navbar -->
      <nav class="navbar navbar-default navbar-inverse">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="?vha=1_1#dashboard"><span class="glyphicon glyphicon-home">Dashboard</span></a></li>
			  <?php 
			  $ut=@db_value(bp_users,user_type,tipster,$_SESSION['whoId']);
			  if ($ut=="Admin")	{
			  ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">BP Ministry<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="?vha=2_1#upcomingMatches">Record Matches</a></li>
                  <li class="divider"></li>	
				  <li class="dropdown-header">ShortCode System</li>	
				  <li><a href="?vha=2_10#load_tips">Enter Surebet Tips</a></li>
				  <li><a href="?vha=2_11#tips_history">Tips History</a></li>
                  <li><a href="?vha=2_8#load_shortcode">Load Shortcode File</a></li>
                  <li><a href="?vha=2_9#shortcode_history">ShortCode Data</a></li>			
  			  	  <li class="divider"></li>				
				  <li class="dropdown-header">Surebets Payments</li>	
                  <li><a href="?vha=2_4#surebetpayment">Confirm Payments</a></li>
                  <li><a href="?vha=2_5#walletpayment">Wallet Payments</a></li>	
                  <li class="divider"></li>			
				  <li class="dropdown-header">Surebets BetSlips</li>	
                  <li><a href="?vha=2_6#surebetbetslip">Enter BetSlips</a></li>
                  <li><a href="?vha=2_7#betsliphistory">BetSlip History</a></li>			
  			  	  <li class="divider"></li>			
				  <li class="dropdown-header">Bet Ministry</li>				  
                  <li><a href="#BP_Settings">BP Settings</a></li>
                  <li><a href="#BP_Editors">BP Editors</a></li>	
				  <li><a href="?vha=2_12##Query_Manager">Query Manager</a></li>				  
                </ul>
              </li>
			  <?php } ?>			  
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account Settings <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="?vha=3_1#changepassword">Change Password</a></li>
                  <li class="divider"></li>			
				  <li class="dropdown-header">Bookmaker Data</li>				  
                  <li><a href="#">Update Bookmaker</a></li>
                  <li><a href="#">Update Accounts</a></li>				  
                </ul>
              </li>
 			<li><a href="?vha=4_1#Placebets">Record Tips</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">SureBET Subscription <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="?vha=6_1#subscribe">Subscribe</a></li>
                  <!-- <li><a href="?vha=6_2#activate">Activate Subscription</a></li> -->
                  <li><a href="?vha=6_3#viewsub">View Subscription History</a></li>	
				   <li class="divider"></li>			
				  <li class="dropdown-header">Wallet</li>					  
                   <li><a href="?vha=6_11#wallet">How to Fund Wallet</a></li>
                   <li><a href="?vha=6_15#wallet">Fund My Wallet - Epayment</a></li>			   
     			   <li class="divider"></li>			
				  <li class="dropdown-header">Surebet Data</li>				  
                  <li><a href="?vha=6_4#view_surebet">View Surebets</a></li>
                  <li><a href="?vha=6_8#betslips">Surebet Betslips</a></li>	
                  <li><a href="?vha=6_14#doItYourself">Do it Yourself Analysis</a></li>					                  <li><a href="?vha=6_9#betting_school">Betting Resources</a></li>	

				  </ul>
              </li>		
			  <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tips Stats <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="?vha=5_1#tiphistory">Tips History</a></li>
                  <li class="divider"></li>					  
                  <li><a href="?vha=5_2#allstats">Tip Statistics</a></li>
                </ul>
              </li>	
			  		
            <ul class="nav navbar-nav navbar-right">
              <!--<li class="active"><a href="./">Default <span class="sr-only">(current)</span></a></li>
              <li><a href="../navbar-static-top/">Static top</a></li>-->
              <li><a href="../logout.php">(<?=$_SESSION['whoId']?>) Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>