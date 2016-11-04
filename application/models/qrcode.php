<?php

class Qrcode extends CI_Model
{

    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }

    function hashEncode($hash)
    {
        return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->config->item('encryptionCode'), $hash, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
    }

    function hashDecode($hash)
    {
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->config->item('encryptionCode'), base64_decode($hash), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }

}
