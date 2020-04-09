<?php
namespace MyVendor\ContactForm\Resource\Page;

use BEAR\Package\AppInjector;
use BEAR\Resource\Exception\BadRequestException;
use BEAR\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;

class MultiTest extends TestCase
{
    const URI = 'page://self/multi';

    /**
     * @var \BEAR\Resource\ResourceInterface
     */
    private $resource;

    protected function setUp() : void
    {
        parent::setUp();
        $this->resource = (new AppInjector('MyVendor\ContactForm', 'html-app'))->getInstance(ResourceInterface::class);
    }

    public function testOnGet()
    {
        $page = $this->resource->uri(self::URI)();
        $this->assertSame(200, $page->code);
        $this->assertContains('</html>', (string) $page);
        $this->assertArrayHasKey('contact_form', $page->body);
        $this->assertArrayHasKey('login_form', $page->body);
        $this->assertContains('</form>', (string) $page->body['contact_form']);
        $this->assertContains('</form>', (string) $page->body['login_form']);
    }

    public function testOnPostContact()
    {
        $query = [
            'submit' => 'contact',
            'contact' => [
                'name' => 'bear',
                'message' => 'nice'
            ]
        ];
        $page = $this->resource->post->uri(self::URI)->withQuery($query)();
        $this->assertSame(201, $page->code);
        $this->assertSame('contact', $page['action']);
    }

    public function testOnPostContactValidationFailed()
    {
        $query = [
            'submit' => 'contact',
            'contact' => [
                'name' => '',
                'message' => '@@invalid'
            ]
        ];
        $page = $this->resource->post->uri(self::URI)->withQuery($query)();
        $this->assertSame(400, $page->code);
    }

    public function testOnPostLogin()
    {
        $query = [
            'submit' => 'login',
            'login' => [
                'user' => 'id',
                'password' => 'secret'
            ]
        ];
        $page = $this->resource->post->uri(self::URI)->withQuery($query)();
        $this->assertSame(200, $page->code);
        $this->assertSame('login', $page['action']);
    }

    public function testOnPostLoginValidationFailed()
    {
        $query = [
            'submit' => 'login',
            'login' => [
                'user' => '',
                'password' => ''
            ]
        ];
        $page = $this->resource->post->uri(self::URI)->withQuery($query)();
        $this->assertSame(400, $page->code);
    }

    public function testOnPostNoSubmit()
    {
        $this->expectException(BadRequestException::class);
        $query = [
            'login' => [
                'user' => '',
                'password' => ''
            ]
        ];
        $this->resource->post->uri(self::URI)->withQuery($query)();
    }
}
