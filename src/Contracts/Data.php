<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni\Contracts;

interface Data
{
    /**
     * @return array<string, mixed>
     */
    public function build(): array;
}
