<?php declare(strict_types=1);
include_once("/http_work/save_dir/functions.php");

final class emailTest
{
    public function testCanBeCreatedFromValidEmailAddress(): void
    {
		
        $this->assertInstanceOf(
            Email::class,
            Email::checkEmail('user@example.com')
        );
    }

    public function testCannotBeCreatedFromInvalidEmailAddress(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Email::checkEmail('invalid');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'user@example.com',
            Email::checkEmail('user@example.com')
        );
    }
}


