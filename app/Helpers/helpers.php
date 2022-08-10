<?php

/*
**	Get Word Function 	[ This Function Accept Parameters ]	v1.0
**	Function To Get Number Of Words From String
**	$string = The String To Get Slice From
**	$str_max = The Max Words The Would Return
**	$str_append = To Append String In case of success
*/

function getWord($string, $str_max = 2, $str_append = "...") {

    $sliceString = explode(" ", $string);

    if (count($sliceString) <= $str_max) {
        return $string;
    }

    $sliceString = array_slice($sliceString, 0, $str_max);

    $sliceString = implode(" ", $sliceString);

    return $sliceString . $str_append;

}

/*
**	Arabic Numbers Function 	[ This Function Accept Parameters ]	v1.0
**	Function To Change English Number To Arabic Numbers
**	$str = The String
*/

function arabicNumbers($str) {

    $western_arabic = array('0','1','2','3','4','5','6','7','8','9');

    $eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');

    return $str = str_replace($western_arabic, $eastern_arabic, $str);

}

/*
**	Arabic Date Function 	[ This Function Accept Parameters ]	v1.0
**	Function To Change English Date To Arabic Date
**	$str = The String
*/

function arabicDate($str) {

    $western_arabic = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "am", "pm");

    $eastern_arabic = array("يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر", "السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "ص", "م");

    return $str = str_replace($western_arabic, $eastern_arabic, $str);

}
