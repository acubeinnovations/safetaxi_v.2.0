
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title;?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../../css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!-- user updation style.css -->
        <link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            <?php echo form_open(base_url().'front-desk/login','class=form_login');?>
                <div class="body bg-gray">
                    <div class="form-group">
						<?php echo '<p class="text-red">'.$this->mysession->get('user_status_error').'</p>'; ?>
						<?php echo '<p class="text-red">'.$this->mysession->get('user_type_error').'</p>'; ?>
						<?php echo form_input(array('name' => 'username','class'=>'username form-control','placeholder'=>'User ID')); ?>
						<?php echo form_error('username','<p class="text-red">', '</p>'); ?>	
                    </div>
                    <div class="form-group">
						<?php echo form_password(array('name'=>'password','class'=>'pass form-control','placeholder'=>'Password')); ?>
						<?php echo form_error('password','<p class="text-red">', '</p>'); ?>
						<?php echo '<p class="text-red">'.$this->mysession->get('password_error').'</p>'; ?>	
                    </div>   
					<?php  if( $this->session->userdata('isloginAttemptexceeded')==true){  ?>     
                   	<div class="form-group">
						<div name="captcha_div" id="captcha_div"><?php echo form_input(array('name' => 'captcha','class'=>'captcha form-control','placeholder'=>'Captcha')).nbs(3); ?><img id="captcha_id" src="<?php echo base_url().'captcha';?>"/></div>
					<?php echo form_error('captcha','<p class="text-red">', '</p>'); ?>	
                </div>
				<?php } ?>
                <div class="footer">  
					<?php echo form_submit("","Login","class='btn bg-olive btn-block'"); 
						 $this->mysession->delete('user_status_error');
					   $this->mysession->delete('password_error');  
						 $this->mysession->delete('user_type_error');
					    ?>                                                       
                             
                 </div>
        	 <?php echo form_close(); ?>

            <div class="margin text-center">
                

            </div>
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../../js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>

 
