<?php

namespace App\Dto;

class TransferDto implements DataDtoInterface
{
    public function __construct(
        public int     $fromUserId,
        public int     $toUserId,
        public float   $amount,
        public ?string $comment = null
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['from_user_id'],
            $data['to_user_id'],
            $data['amount'],
            $data['comment'] ?? 'Перевод выполнен'
        );
    }

}
