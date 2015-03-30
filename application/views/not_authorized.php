<div id="body-wrap">
<section class="content">
                 <?php 

				if(($this->session->userdata('isLoggedIn')==true ) && ($this->session->userdata('type')==FRONT_DESK)){
				$login_url=base_url().'front-desk/login';

				}else if(($this->session->userdata('isLoggedIn')==true ) && ($this->session->userdata('type')==SYSTEM_ADMINISTRATOR)){
					$login_url=base_url().'syslogin';
				}else{
				$login_url=base_url().'front-desk/login';

				}
		?>
                    <div class="error-page">
                        <h2 class="headline text-info">Access Denied</h2>
                        <div class="error-content">
                            <h3><i class="fa fa-warning text-yellow"></i> Oops! You have no permission to access this page.</h3>
                            <p>
                               Please <a href="<?php echo $login_url; ?>">login</a> again.<?php echo nbs(3); ?>Thank You.
                            </p>
                            
                        </div><!-- /.error-content -->
                    </div><!-- /.error-page -->

                </section><!-- /.content -->
</div>
