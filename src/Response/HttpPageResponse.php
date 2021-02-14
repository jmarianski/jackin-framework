<?php

declare (strict_types = 1);

namespace Jackin\Response;

class HttpPageReponse extends BaseResponse
{
    public function finish()
    {
        die($this->Controller->getData());
    }
}