<?php

namespace App\Dto;

class TransactionDto implements DataDtoInterface
{
    public ?string $userId;
    public ?string $sortBy;
    public ?string $sortDirection;
    public ?string $dateFrom;
    public ?string $dateTo;
    public ?int $perPage;

    public function __construct(
        ?string $userId = null,
        ?string $sortBy = 'created_at',
        ?string $sortDirection = 'desc',
        ?string $dateFrom = null,
        ?string $dateTo = null,
        ?int    $perPage = 10
    )
    {
        $this->userId = $userId;
        $this->sortBy = $sortBy;
        $this->sortDirection = $sortDirection;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->perPage = $perPage;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['user_id'],
            $data['sortBy'] ?? 'created_at',
            $data['sortDirection'] ?? 'desc',
            $data['dateFrom'] ?? null,
            $data['dateTo'] ?? null,
            $data['perPage'] ?? 10
        );
    }
}
