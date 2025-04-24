<?php

namespace Database\Fakers\Images;

use Alirezasedghi\LaravelImageFaker\Base;

class ThisPersonDoesNotExist extends Base
{
    /**
     * Service base url
     */
    public string $base_url = 'https://thispersondoesnotexist.com';

    /**
     * SSL verification of service
     */
    public bool $SSL_verify_peer = false;

    protected function makeUrl(int $width = 640, int $height = 480, array $imageOptions = []): string
    {
        return $this->base_url;
    }
}
