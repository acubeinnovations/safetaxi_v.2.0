     
            <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <?php if($this->session->userdata('isLoggedIn')==null || $this->session->userdata('isLoggedIn')!=true) {?>
                        <li class="active">
                            <a href="<?php echo base_url();?>">
                                <i class="fa fa-home"></i> <span> Home </span>
                            </a>
                        </li>
                        <?php } else if($this->session->userdata('isLoggedIn')==true && $this->session->userdata('type')==SYSTEM_ADMINISTRATOR){ ?>
                        <li>
                            <a href="<?php echo base_url().'admin';?>">
                                <i class="fa fa-home"></i> <span> Dashboard </span>
                            </a>
                        </li>
                        
                       	<li class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span>Users</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url().'admin/front_desk/new';?>"><i class="fa fa-user"></i> Add  Users</a></li>
                                <li><a href="<?php echo base_url().'admin/front_desk/list';?>"><i class="fa fa-users"></i> List Users</a></li>
                                
                            </ul>
                        </li>
                        <?php }else if($this->session->userdata('isLoggedIn')==true && $this->session->userdata('type')==FRONT_DESK ){ ?>
                        <li>
                            <a href="<?php echo base_url().'front-desk';?>">
                                <i class="fa fa-home"></i> <span> Dashboard </span>
                            </a>
                        </li>
                        
		
		

			<li class="treeview">
                            <a href="#">
                                <i class="fa fa-user-md"></i>
                                <span>Driver</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                               
                                <li><a href=" <?php echo base_url().'front-desk/list-driver';?>"><i class="fa fa-angle-double-right"></i>Manage Drivers</a></li>
                                 <li><a href="<?php echo base_url().'front-desk/drivers-payments';?>"><i class="fa fa-angle-double-right"></i>Driver Payment</a></li>
                            </ul>
                        </li>
						
						<li class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span>Customer</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                            <li><a href="<?php echo base_url().'front-desk/customers';?>"><i class="fa fa-angle-double-right"></i>Manage Customers</a></li> 
                                
                            </ul>
                        </li>
						
						<li class="treeview">
                            <a href="#">
                                <i class="fa fa-exchange"></i>
                                <span>Trip</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url().'front-desk/trip-booking';?>"><i class="fa fa-angle-double-right"></i>New Trip</a></li>
						<li><a href="<?php echo base_url().'front-desk/trips';?>"><i class="fa fa-angle-double-right"></i>Trip Bookings</a></li>
                         <li><a href="<?php echo base_url().'front-desk/find-distance';?>"><i class="fa fa-angle-double-right"></i>Find Distance</a></li>
                                
                            </ul>
                        </li>
						
			
                        
			<li class="treeview">
                            <a href="#">
                                <i class="fa fa-wrench"></i>
                                <span> Settings</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url().'front-desk/settings';?>"><i class="fa fa-angle-double-right"></i>General Settings</a></li>
                                <li class="treeview">
		                    <a href="#">
		                        <i class="fa fa-wrench"></i>
		                        <span>Tariff Settings</span>
		                        <i class="fa fa-angle-left pull-right"></i>
		                    </a>
		                    <ul class="treeview-menu">
		                       
		                        <li><a href="<?php echo base_url().'front-desk/tariff';?>"><i class="fa fa-angle-double-right"></i>Tariffs</a></li>
		                        
		                    </ul>
                        	</li>
							 
                        </li>

                        <?php } ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
        	<aside class="right-side">
