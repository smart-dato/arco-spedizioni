<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use SmartDato\ArcoSpedizioni\Data\ShipmentData;

final class InstradamentoRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly ShipmentData $route,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/api/ArBolleSpes/GetInstradamento';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->route->build();
    }
}
