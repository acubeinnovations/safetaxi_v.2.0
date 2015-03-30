<?php 
tcpdf();
$pdf =  new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ConnectNCabs');
$pdf->SetTitle('Trip');


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);

ob_start();
$content='<div style="border:1px solid #333;width:80%;display:inline-block;margin:20px 10% auto;">
<div style="float:left;width:100%;">
<p style="font-size:14px;">Trip Id :'.nbs(5).$trip_id.nbs(100).' Date :'.nbs(5).date('d-m-Y',strtotime($pick_up_date)).'</p>
</div>
<div style="border-top:1px solid #333;width:100%;float:left;">
<div style="width:48%;float:left;">
<table style="width:100%;">
<tr>
<td style="width:50%;" >Passenger/Customer Name<span class="float-right"> :</span></td>
<td style="width:50%;">'.$customer.'</td>
</tr>';
$content1='<tr>
<td style="width:50%;">Mobile Number<span class="float-right"> :</span></td>
<td style="width:50%;">'.$mobile.'</td>
</tr>
<tr>
<td style="width:50%;">Address<span class="float-right"> :</span></td>
<td style="width:50%;">'.$address.'</td>
</tr>
<tr>
<td style="width:50%;">Customer Type<span class="float-right"> :</span></td>
<td style="width:50%;">'.$customer_type.'</td>
</tr>
<tr>
<td style="width:50%;">Pickup date and time <span class="float-right"> :</span></td>
<td style="width:50%;">'.date('d-m-Y',strtotime($pick_up_date)).' '.$pick_up_time.'</td>
</tr>';
$content2='<tr>
<td style="width:50%;">Location from / pickup<span class="float-right"> :</span></td>
<td style="width:50%;">'.$pickuploc.'</td>
</tr>
<tr>
<td style="width:50%;">Location Via<span class="float-right"> :</span>
</td style="width:50%;"><td style="width:50%;">'.$vialoc.'</td>
</tr>
<tr>
<td style="width:50%;">Drop date and time<span class="float-right"> :</span>
</td style="width:50%;"><td style="width:50%;">'.date('d-m-Y',strtotime($drop_date)).' '.$drop_time.'</td>
</tr>
<tr>
<td style="width:50%;">Location to / drop<span class="float-right"> :</span></td>
<td style="width:50%;">'.$droploc.'</td>
</tr>
</table>
</div>';
$content3='<div style="width:48%;float:left;">
<table class="width-100-percent trip-table">
<tr>
<td>Trip / Booking Type<span class="float-right"> :</span></td>
<td>'.$trip_model.'</td>
</tr>
<tr>
<td style="width:50%;">Booking date and time<span class="float-right"> :</span></td>
<td style="width:50%;">'.date('d-m-Y',strtotime($booking_date)).' '.$booking_time.'</td>
</tr>
<tr>
<td>Booking source<span class="float-right"> :</span></td>
<td>'.$booking_source.'</td>
</tr>';
$content4='<tr><td style="width:50%;">Source Narration<span class="float-right"> :</span></td>
<td style="width:50%;">'.$source.'</td>
</tr>
<tr><td style="width:50%;">Vehicle Type<span class="float-right"> :</span></td>
<td style="width:50%;">'.$vehicle_type.'</td>
</tr>
<tr>
<td>AC / Non A/C<span class="float-right"> :</span></td>
<td>'.$vehicle_ac_type.'</td>
</tr>
<tr><td>Seating Capacity<span class="float-right"> :</span></td>
<td style="width:50%;">'.$vehicle_seating_capacity.'</td></tr>';
$content5='<tr><td>Beacon Light<span class="float-right"> :</span></td>
<td style="width:50%;">'.$vehicle_beacon_light.'</td>
</tr>
<tr>
<td style="width:50%;">Vehicle details<span class="float-right"> :</span></td>
<td style="width:50%;">'.$vehicle.' Diver :'.$driver.'</td>
</tr>
</table>
</div>
</div>';
$content5='<div>
<table style="width:100%;">
<tr>
<td style="font-size:14px;">To be filled by the Driver:</td>
<td></td>
</tr><tr>
<td>
</td>
</tr><tr>
<td style="width:50%;">Start date<span class="float-right"> :</span></td>
<td style="width:50%;">_________________________________</td>
</tr>
<tr>
<td>
</td>
</tr>
<tr>
<td style="width:50%;">Start Kilometer reading<span class="float-right"> :</span></td>
<td style="width:50%;">_________________________________</td>
</tr>
<tr>
<td>
</td>
</tr>
<tr>
<td style="width:50%;">End date<span class="float-right"> :</span></td>
<td >_________________________________</td>
</tr>
<tr>
<td>
</td>
</tr>
<tr><td>End time<span class="float-right"> :</span></td>
<td>_________________________________</td>
</tr>';
$content6='
<tr>
<td>
</td>
</tr><tr><td>End Kilometer reading<span class="float-right"> :</span></td>
<td>_________________________________</td></tr>
<tr>
<td>
</td>
</tr>
<tr>
<td>Garage closing kilometer reading<span class="float-right"> :</span></td>
<td>_________________________________</td>
</tr>
<tr>
<td>
</td>
</tr>
<tr>
<td>Garage closing time<span class="float-right"> :</span></td>
<td>_________________________________</td>
</tr>';
$content7='<tr>
<td>
</td>
</tr><tr><td>Releasing place<span class="float-right"> :</span></td>
<td>_________________________________</td></tr>
<tr>
<td>
</td>
</tr>
<tr><td>Parking <span class="float-right"> :</span></td>
<td>_________________________________</td>
</tr>';
$content8='<tr>
<td>
</td>
</tr><tr><td>Toll<span class="float-right"> :</span></td>
<td>_________________________________</td>
</tr>
<tr>
<td>
</td>
</tr>
<tr><td>State Tax <span class="float-right"> :</span>
</td>
<td>_________________________________</td>
</tr>
<tr>
<td>
</td>
</tr>
<tr>
<td>Night Halt<span class="float-right"> :</span></td>
<td>_________________________________</td>
</tr>
<tr>
<td>
</td>
</tr>
<tr><td>Fuel extra charges <span class="float-right"> :</span></td>
<td>_________________________________</td>
</tr>
</table>
</div>
</div>';

ob_end_clean();

//$pdf->writeHTML($content, true, false, false, false, '');
//$pdf->writeHTML($content1, true, false, false, false, '');

$content.=$content1;
$content.=$content2;
$content.=$content3;
$content.=$content4;
$content.=$content5;
$content.=$content6;
$content.=$content7;
$content.=$content8;
$pdf->writeHTML($content, true, false, false, false, '');
$file_name='trip-'.$trip_id.'.pdf';
$pdf->Output($file_name, 'I');



?>
