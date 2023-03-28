<?php

namespace common\enums;
class CommentStatus extends Enum
{
    const NEW = 1;
    const APPROVED = 2;
    const REJECTED = 3;

    public static function getList(): array
    {
        return [
            self::NEW => 'New',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
        ];
    }
}