<script type="text/javascript">
     $(document).ready(function(){

          $('#pdf').ready(function(){
               printDiv();
               function printDiv() {
                    var printContents = $(".right_content").html();
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
               }
          });
      });
</script>
<?php

$single_driver_record=$this->uri->segment(3);

?>
<!-- CSS goes in the document HEAD or added to your external stylesheet -->


<!-- Table goes in the document BODY -->


<div id="print_driver_payments">
<div class="tblgap"></div>
<table border="1px solid black" width="100%">
	<tr>
		<td align="center">
			<?php echo PRODUCT_NAME; ?><br>
		
			<?php echo SYSTEM_ADDRESS; ?><br>
			<i>Phone : <?php echo SYSTEM_PHONE_NUMBER; ?></i><br>
			<i>Email : <?php echo SYSTEM_EMAIL; ?></i>
		</td>
	</tr>
</table>
<div class="tblgap"></div>
<table cellpadding="10" border="1px solid black" width="100%">
	<tr>
		<td width="50%" align="left">
			To,<br>
		
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;Mr. <?php echo $values[0]['Driver_name']." , ".$values[0]['Driver_address']." , ".$values[0]['Driver_district']." , ".$values[0]['Driver_state'];?><br>
			
		</td>
		<td width="50%" align="left">
			<?php 
			 if($single_driver_record==""){
			 echo $date = date('d/m/Y');	
			 }else{
			$date = DateTime::createFromFormat('Y-m-d', $values[0]['Payment_date']);
			echo "Date :".$date->format('d/m/Y');
			}
			
			?><br>
			<?php if($single_driver_record!=""){?>
			Type :  <?php echo $values[0]['Voucher_type'];?> <br>
			 <?php echo $values[0]['Voucher_type'];?> No: <?php echo $values[0]['Voucher_number'];?>  <br>
			 <?php }?>
			Vehicle No: <?php echo $values[0]['Driver_vehicle_registration'];?>
		</td>
	</tr>

</table>




<div class="tblgap"></div>




<!-- Driver Details Table-->
<table class="gridtable" width="100%">
<tr>
	<th>Sl.no</th><th>Particulars</th><th>Amount</th>
</tr>
<!-- Loop Starts -->
<?php $slno=1;
$amountdr=0;
$amountcr=0;
for ($i=0; $i < count($values); $i++)   {?>

<tr>

	<td width="10%"><?php echo $slno;?></td>
	<td width="70%">
		<?php 
		$month = date("F", mktime(0, 0, 0, $values[$i]['Driver_payment_period'], 10));
		
		?>
		<?php 
		
		$msginvoice=" invoice for the month of ";
		$msgpayment=" payment towards the month ";

		?>
		<?php echo "For Mr ".$values[0]['Driver_name'];
		if($values[$i]['Voucher_type']=="Invoice"){

			echo $msginvoice;
		}elseif($values[$i]['Voucher_type']=="Payment"){
			echo $msgpayment;
		}
		echo $month."&nbsp".$values[$i]['Driver_payment_year']; ?>
	</td>
	<td width="20%">
		<?php
			if($values[$i]['Voucher_type']=="Invoice"){
				echo $amount=$values[$i]['Driver_debit']*COMMISION_PERCENTAGE/100; if($single_driver_record==""){$amountdr+=$amount; echo " Dr"; }
			}elseif($values[$i]['Voucher_type']=="Payment"){
				echo $amount=$values[$i]['Driver_credit']; if($single_driver_record==""){$amountcr+=$amount; echo " Cr"; }
			}
		?>

	</td>
</tr>
<?php $slno++;
} 
?>
<!-- Loop Ends-->
</table>
<!-- Driver Details Table-->





<div class="tblgap"></div>
<?php 
			//service tax calculation
			$servic_tax=$amount*VAT/100;
			$service_tax=floor($servic_tax * 100) / 100; //for rounding of service tax
			$total= $amount;
			$amount_payable=floor(($total/1.1236)* 100) / 100;
			$total_amount=floor($total * 100) / 100;  //for rounding of total amount
			?>
<table cellpadding="10" border="1px solid black" width="100%">
	<tr>
		<td width="50%" align="left">
			<?php if($single_driver_record!=""){?>
			<b>Rupees : <?php echo $this->form_functions->convert_number_to_words($total_amount); ?></b>
			<?php }?>
			
		</th>
		<td width="50%" align="left">
			<?php if($single_driver_record!=""){?>
			<span style="font-size: 10px !important; color: #aaaaaa;">
				Service Tax : 12% <br>
			Edu cess: 2% (2% of basic Service Tax = 0.24 )<br>
			Higher Edu.Cess-1% (1% of basic Service Tax = 0.12 )</span><br>
			<b>Service Tax      :   <?php echo $service_tax;?><i>&nbsp;&nbsp;(12.36%)</i><br><br>
				
				Amount     :   <?php echo $amount_payable; ?><br>	
				GRAND TOTAL     :   <?php echo $total_amount;?><br>	

			</b>
			<?php } else {
				$result=$amountdr-$amountcr;
				if ($result < 0){
					echo $result." Dr";
				}
				else{
					echo $result." Cr";
				}
			}?>
		</td>
	</tr>

</table>
<div class="tblgap"></div>
<table cellpadding="8" border="1px solid black" width="100%">
	<tr>
		<td width="60%" align="left">
			Registered Office : &nbsp;&nbsp; &nbsp;&nbsp;  <?php echo SYSTEM_ADDRESS; ?>
			
		</td>
		<td width="40%" align="center">
			<b>For SAFE TAXI Tours & Travels Pvt.Ltd<br>
				Authorised Signatory
			</b>
		</td>
	</tr>

</table>
</div>




