<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once 'C:\xampp\htdocs\CMC\SOURCE_FILE\src\interfaces/ValidationRuleInterface.php';
require_once 'C:\xampp\htdocs\CMC\SOURCE_FILE\src\Validation.php';
require_once 'C:\xampp\htdocs\CMC\SOURCE_FILE\src\validationRules/ValidateEmail.php';


final class ValidationTest extends TestCase
{
    public function testValidationEmail(): void
    {
        $validatinClass = new Validation();
        $validatinClass->addRule(new ValidateEmail());

        $this->assertTrue($validatinClass->validate('philip@gmail.com'));
    }

    // public function testCannotBeCreatedFromInvalidEmail(): void
    // {
    //     $this->expectException(InvalidArgumentException::class);

    //     Email::fromString('invalid');
    // }
}
