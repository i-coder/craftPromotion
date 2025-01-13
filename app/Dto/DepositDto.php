<?php

namespace App\Dto;

class DepositDto implements DataDtoInterface
{
    public function __construct(
        public int     $userId,
        public float   $amount,
        public ?string $comment = null
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['user_id'],
            $data['amount'],
            $data['comment'] ?? 'Средства зачислены'
        );
    }
}
