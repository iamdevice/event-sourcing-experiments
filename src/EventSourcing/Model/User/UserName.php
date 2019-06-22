<?php
/**
 * Created by Aleksandr Kozhevnikov <iamdevice@gmail.com>
 * Date: 2019-06-15 15:46
 */

declare(strict_types=1);

namespace App\EventSourcing\Model\User;

final class UserName
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public static function fromString(string $name): UserName
    {
        return new self($name);
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function toString(): string
    {
        return $this->__toString();
    }
}
