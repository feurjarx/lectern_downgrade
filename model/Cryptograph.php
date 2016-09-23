<?php

class Cryptograph
{
    /** @var string  */
    private $iv;
    
    public function __construct($_64iv = null)
    {
        if ($_64iv) {
            
            $this->iv = base64_decode($_64iv);
            
        } else {

            $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            $this->iv = mcrypt_create_iv($ivSize, MCRYPT_DEV_URANDOM);
        }
    }

    /**
     * @return string
     */
    public function getIvToBase64()
    {
        return base64_encode($this->iv);
    }

    /**
     * @param string $_64iv
     */
    public function setIvFromBase64($_64iv)
    {
        $this->iv = base64_decode($_64iv);
    }
    
    /**
     * @param $text
     * @param $secret
     * @return string
     */
    public function encrypt($text, $secret)
    {
        $key = pack('H*', md5($secret));
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $text, MCRYPT_MODE_CBC, $this->iv));
    }

    /**
     * @param $crypt
     * @param $secret
     * @return string
     */
    public function decrypt($crypt, $secret)
    {
        $key = pack('H*', md5($secret));
        return mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($crypt), MCRYPT_MODE_CBC, $this->iv);
    }
}