<?php 
class Form_functions{
function populate_dropdown($name = '', $options = array(), $selected = array(),$class='',$id='',$msg='select'){
$CI = & get_instance();
$form = '<select name="'.$name.'" class="'.$class.'" id="'.$id.'"/>';
if($selected==''){
$form.='<option value="-1" selected="selected" >--'.$msg.'--</option></br>';
}
else{
$form.='<option value="-1"  >--'.$msg.'--</option></br>';
}
if(!empty($options)){
foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if($key==$selected){
						$sel=' selected="selected"';
						}
						else{
						$sel='';
						}

					$form .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
					
		}
}
		$form .= '</select>';

		return $form;
}

function populate_editable_dropdown($name = '', $options = array(),$class='',$tbl=''){
$CI = & get_instance();

$form = '<select name='.$name.' id="lstDropDown_A" class="'.$class.'" onKeyDown="fnKeyDownHandler_A(this, event);" onKeyUp="fnKeyUpHandler_A(this, event); return false;" onKeyPress = "return fnKeyPressHandler_A(this, event);"  onChange="fnChangeHandler_A(this);" onFocus="fnFocusHandler_A(this);" tblname="'.$tbl.'">';
$form.='<option selected="selected"></option></br>';
if(!empty($options)){
foreach ($options as $key => $val)
		{
			$key = (string) $key;

			
					$form .= '<option value="'.$key.'">'.(string) $val."</option>\n";
					
		}
		}
		
		$form .= '</select>';

		return $form;
}

function form_error_session($field = '', $container_open ='', $container_close=''){
		$CI = & get_instance();
		if(isset($field) && $field!=''){
		$form_error_session=$container_open.$CI->mysession->get($field).$container_close;
		$CI->mysession->delete($field);
		return $form_error_session;
		}else{
		return '';
		}
}
//for converting number to words(Amount)
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = '  ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' and ';
    $paise     = ' Paise ';
    $dictionary  = array(
        0                   => 'Zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
        1000000             => 'Million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . $this->convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= $this->convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

   
    if (null !== $fraction && is_numeric($fraction)) {
    	 return $string.$paise;
    }else{
    		 return $string;
    }	
}

}
?>
