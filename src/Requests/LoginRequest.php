<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\SoloRequest;
use Saloon\Traits\Body\HasJsonBody;

final class LoginRequest extends SoloRequest implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly ?string $username = null,
        private readonly ?string $password = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'https://webservices.arcospedizioni.it/api/login';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            //            'Accept' => 'application/json',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [
            'username' => $this->username ?? config('arco-spedizioni-sdk.username'),
            'password' => $this->password ?? config('arco-spedizioni-sdk.password'),
        ];
    }
}
