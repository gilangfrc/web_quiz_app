<?php

Class Support {
    public static function getAvatar($name, $color = '007bff', $background = 'fff') {
        // $url = 'https://www.gravatar.com/avatar/';
        // $url .= md5( strtolower( trim( $username ) ) );
        // $url .= "?s=25&d=retro&r=g";
        $url = 'https://ui-avatars.com/api/?background='.$background.'&color='.$color.'&length=1&size=26&font-size=0.65&name='.$name;
        return $url;
    }

    public static function setFlash($msg, $icon, $color) {
        $_SESSION['flash'] = [
            'msg' => $msg,
            'icon' => $icon,
            'color' => $color
        ];
    }

    public static function flash() {
        if (isset($_SESSION['flash'])) {
            echo '
            <div id="alert-area">
                <div class="alert alert-'.$_SESSION['flash']['color'].' fade show rounded-0" id="alert" role="alert">
                    <p class="mb-0 text-center">'.$_SESSION['flash']['msg'].'</p>
                </div>
            </div>    
            ';

            unset($_SESSION['flash']);
        }
    }

    public static function formatRupiah($number) {
        $formatted = "Rp. " . number_format($number,0,',','.');
	    return $formatted;
    }

    public static function filterNumber($string) {
        return preg_replace('/[^0-9]/','',$string);
    }
    
    public static function filterString($string) {
        return preg_replace('/[^A-Z]/i','',$string);
    }

    public static function generateRandomString($length = 6) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public static function limited($url) {
        Support::setFlash('Access Limited', 'exclamation-circle', 'danger');
        return header('Location:'.BASEURL.$url);
    }
}