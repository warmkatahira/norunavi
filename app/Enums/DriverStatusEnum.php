<?php

namespace App\Enums;

enum DriverStatusEnum
{
    // ドライバーステータス
    const PENNDING  = 1;    // 手上げ中
    const CONFIRMED = 2;    // 確定
    const REJECTED  = 3;    // 管理者却下
    const WITHDRAWN = 4;    // 本人辞退
}