<?php

declare(strict_types=1);

namespace Exel\ApiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

final class ExelApiBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
