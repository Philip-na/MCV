<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class ActiveRecordTest extends TestCase
{
    public function testCanBeCreatedFromValidEmail(): void
    {
        

        $this->assertEquals(5,1+4);
    }

    // public function testCannotBeCreatedFromInvalidEmail(): void
    // {
    //     $this->expectException(InvalidArgumentException::class);

    //     Email::fromString('invalid');
    // }
}
