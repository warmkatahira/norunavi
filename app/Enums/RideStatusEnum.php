<?php

namespace App\Enums;

enum RideStatusEnum:int
{
    case DRAFT          = 1; // 下書き
    case RECRUITING     = 2; // 募集中
    case CLOSED         = 3; // 締め切り
    case CANCELLED      = 4; // 中止

    public function label(): string
    {
        return match($this) {
            self::DRAFT      => '下書き',
            self::RECRUITING => '募集中',
            self::CLOSED     => '締め切り',
            self::CANCELLED  => '中止',
        };
    }
}