<?php
if ( ! function_exists('alias'))
{
    function alias($str){
        $marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ",
                "è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ",
                "ì","í","ị","ỉ","ĩ",
                "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ",
                "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
                "ỳ","ý","ỵ","ỷ","ỹ",
                "đ",
                "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
                ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
                "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
                "Ì","Í","Ị","Ỉ","Ĩ",
                "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
                ,"Ờ","Ớ","Ợ","Ở","Ỡ",
                "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
                "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
                "Đ"," ","?",",","!","'",":"); 
                $marKoDau=array("a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a",
                "e","e","e","e","e","e","e","e","e","e","e",
                "i","i","i","i","i",
                "o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o",
                "u","u","u","u","u","u","u","u","u","u","u",
                "y","y","y","y","y",
                "d",
                "A","A","A","A","A","A","A","A","A","A","A","A"
                ,"A","A","A","A","A",
                "E","E","E","E","E","E","E","E","E","E","E",
                "I","I","I","I","I",
                "O","O","O","O","O","O","O","O","O","O","O","O"
                ,"O","O","O","O","O",
                "U","U","U","U","U","U","U","U","U","U","U",
                "Y","Y","Y","Y","Y",
                "D","-","","","","","");
                $str=str_replace($marTViet,$marKoDau,$str);
        return $str;
    }
}
if ( ! function_exists('loaibo_html')){
    function loaibo_html($text1){
           // $text = '<p id="content-header"><span style="font-family: arial,helvetica,sans-serif; font-size: small; color: #000000;">Trong bài van vi?t v? b? c?a mình, m?t h?c sinh l?p 3 dã tu?ng thu?t l?i câu chuy?n trong gia dình mình.</span></p>';
            $text1= strip_tags($text1);
            return $text1;
        }
}
if ( ! function_exists('loaibo_div_html')){
    function loaibo_div_html($text){
            $allow = '<p><ul><li><b><strong><hr><tbody><tr><table><td><span><em><br><a><img>';
            $txt=strip_tags($text,$allow);
            return $txt;
    }
}
if ( ! function_exists('laydiachianh')){
    function laydiachianh($image){        
            $src_start = strpos($image, 'src="') + 5;
            $src_end = strpos($image, '"', $src_start);
            $src = substr($image, $src_start, $src_end - $src_start);
            return $src;
    }
}