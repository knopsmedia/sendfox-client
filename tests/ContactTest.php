<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Tests;

use Knops\SendfoxClient\Models\Contact;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{
    public function testCreateContactFromArray(): void
    {
        $data = [
            'id' => 123,
            'email' => 'test@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'ip_address' => '192.168.1.1',
            'unsubscribed_at' => null,
            'created_at' => '2023-01-01T00:00:00Z',
            'updated_at' => '2023-01-01T00:00:00Z'
        ];

        $contact = Contact::fromArray($data);

        $this->assertEquals(123, $contact->id);
        $this->assertEquals('test@example.com', $contact->email);
        $this->assertEquals('John', $contact->first_name);
        $this->assertEquals('Doe', $contact->last_name);
        $this->assertEquals('192.168.1.1', $contact->ip_address);
        $this->assertNull($contact->unsubscribed_at);
        $this->assertEquals('2023-01-01T00:00:00Z', $contact->created_at);
        $this->assertEquals('2023-01-01T00:00:00Z', $contact->updated_at);
    }

    public function testIsUnsubscribedReturnsFalseWhenNull(): void
    {
        $data = [
            'id' => 123,
            'email' => 'test@example.com',
            'unsubscribed_at' => null
        ];

        $contact = Contact::fromArray($data);
        $this->assertFalse($contact->isUnsubscribed());
    }

    public function testIsUnsubscribedReturnsTrueWhenDatePresent(): void
    {
        $data = [
            'id' => 123,
            'email' => 'test@example.com',
            'unsubscribed_at' => '2023-01-01T00:00:00Z'
        ];

        $contact = Contact::fromArray($data);
        $this->assertTrue($contact->isUnsubscribed());
    }

    public function testToArrayReturnsCorrectData(): void
    {
        $data = [
            'id' => 123,
            'email' => 'test@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'ip_address' => '192.168.1.1',
            'unsubscribed_at' => null,
            'created_at' => '2023-01-01T00:00:00Z',
            'updated_at' => '2023-01-01T00:00:00Z'
        ];

        $contact = Contact::fromArray($data);
        $result = $contact->toArray();

        $this->assertEquals($data, $result);
    }
}
