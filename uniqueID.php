<?php

class uniqueID {
    
    const ALPHABET = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
    const BASE = 64;
    const MAX_ID_LENGTH = "18446744073709551615"; // Stored as a string because of PHP's limitations
    const MIN_ID_LENGTH = 1;
    const SALT = "yzNjIBEdyww"; // Change this string to something random
    
    private function bigRand($min, $max){
        $difference   = bcadd(bcsub($max,$min),1);
        $rand_percent = bcdiv(mt_rand(), mt_getrandmax(), 8);
        return bcadd($min, bcmul($difference, $rand_percent, 8), 0);
    }
    
    private function bcfloor($x){
        $result = bcmul($x, '1', 0);
        if( (bccomp($result, '0', 0) == -1) && bccomp($x, $result, 1) ){
            $result = bcsub($result, 1, 0);
        }
        return $result;
    }
    
    private function saltShaker($salt = ""){
        $alphabet = self::ALPHABET;
        $salt_length = strlen($salt);
        if (!$salt_length) {
            return $alphabet;
        }
        for ($i = strlen($alphabet) - 1, $v = 0, $p = 0; $i > 0; $i--, $v++) {
            $v %= $salt_length;
            $p += $int = ord($salt[$v]);
            $j = ($int + $v + $p) % $i;
            $temp = $alphabet[$j];
            $alphabet[$j] = $alphabet[$i];
            $alphabet[$i] = $temp;
        }
        return $alphabet;
    }

    public function generate($min = self::MIN_ID_LENGTH, $max = self::MAX_ID_LENGTH){
        return $this->bigRand($min, $max);
    }
    
    public function expand($value, $salt = self::SALT){
        $alphabet = $this->saltShaker($salt);
        $base = self::BASE;
        
        $limit = strlen($value);
        $result = strpos($alphabet, $value[0]);

        for($i = 1; $i < $limit; $i++){
            $result = bcadd(bcmul($base,$result), strpos($alphabet, $value[$i]));
        }
        return $result;
    }
    
    public function shorten($value, $salt = self::SALT){
        $alphabet = $this->saltShaker($salt);
        $base = self::BASE;
        
        $r = bcmod($value, $base);
        $result = $alphabet[$r];
        $q = $this->bcfloor(bcdiv($value, $base));

        while ($q){
            $r = bcmod($q, $base);
            $q = $this->bcfloor(bcdiv($q, $base));
            $result = $alphabet[$r].$result;
        }
        return $result;
    }
}
    
?>
