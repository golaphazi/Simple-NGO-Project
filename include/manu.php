 <div class="navbar navbar-inverse set-radius-zero">
     <div class="container ">
            <div class="col-md-2 navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand1" href="login.php">
					<img src="<?= host().'/'.comapny_info('COMPANY_IMAGE');?>" />
                </a>

            </div>

            <div class="col-md-6 pull-left">
                <h2 style="color:#fff;"> <?= comapny_info('COMPANY_NAME');?> </h2>
                <h5 style="color:#000;"> <?= comapny_info('COMPANY_SORT');?> </h5>
				
			</div>
			
			<div class="col-md-4 pull-right header_profile">
                <?php $name 	= $_SESSION['USER_NAME'];?>
				<span style="color:#fff;margin-right:20px;"><span class="glyphicon glyphicon-user"></span> <?= ucfirst($name);?> </span>
				<span ><a href="logout.php" style="color:#eeeeee;"> <span class="glyphicon glyphicon-log-out"></span> Logout</a></span>
			</div>
    </div>
</div>
 <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a  href="<?= host().'/' ; ?>login.php">Dashboard</a></li>
                            <li><a href="<?= host().'/' ; ?>add_member.php">Add Member</a></li>
                            <li><a href="<?= host().'/' ; ?>add_saving.php">Add Saving</a></li>
                            <li><a href="<?= host().'/' ; ?>saving_history.php">Saving History</a></li>
                            <li><a href="<?= host().'/' ; ?>add_loan.php">Add Loan</a></li>
                            <li><a href="<?= host().'/' ; ?>recevie_loan.php">Recevie Loan</a></li>
                            <li><a href="<?= host().'/' ; ?>loan-history.php">Loan History</a></li>
                            <!--<li><a href="other_pay.php">Other Pay</a></li>-->
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>