<?php

declare(strict_types = 1);

namespace Jackin\Response;

class ConsoleResponse extends BaseResponse
{
    public function finish()
    {
        $data = $this->Controller->getData();
        die(json_encode($data));
    }
}