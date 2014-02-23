<?php
namespace Library\WhatsApp\Connection\WhatsAPI;

class KeyStream
{
    private $rc4;
    private $key;

    public function __construct($key)
    {
        $this->rc4 = new RC4($key, 256);
        $this->key = $key;
    }

    public function encode($data, $offset, $length, $append = true)
    {
        $d = $this->rc4->cipher($data, $offset, $length);
        $h = substr(hash_hmac('sha1', $d, $this->key, true), 0, 4);
        if ($append)
            return $d . $h;
        else
            return $h . $d;
    }

    public function decode($data, $offset, $length)
    {
        /* TODO: Hash check */

        return $this->rc4->cipher($data, $offset + 4, $length - 4);
    }

}
