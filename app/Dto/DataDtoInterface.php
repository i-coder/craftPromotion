<?php

namespace App\Dto;

interface DataDtoInterface
{
    public static function fromArray(array $data): self;
}
