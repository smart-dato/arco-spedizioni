<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

final class NumeratoriBolleRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/ArNumeratoriBolles';
    }
}
