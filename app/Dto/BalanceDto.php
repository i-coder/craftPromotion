<?php

namespace App\Dto;

class BalanceDto implements DataDtoInterface
{
    public function __construct(
        public int     $userId,
        public ?string $currency = null
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['user_id'],
            $data['currency'] ?? null
        );
    }
}
