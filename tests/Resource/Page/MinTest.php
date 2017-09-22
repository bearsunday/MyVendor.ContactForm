<?php
namespace MyVendor\ContactForm\Resource\Page;

use BEAR\Package\AppInjector;
use BEAR\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;

class MinTest extends TestCase
{
    const URI = 'page://self/min';

    /**
     * @var \BEAR\Resource\ResourceInterface
     */
    private $resource;

    protected function setUp()
    {
        parent::setUp();
        $this->resource = (new AppInjector('MyVendor\ContactForm', 'html-app'))->getInstance(ResourceInterface::class);
    }

    public function testOnGet()
    {
        $query = ['name' => 'koriym'];
        $page = $this->resource->uri(self::URI)->withQuery($query)();
        $this->assertSame(200, $page->code);
        $this->assertContains('</html>', (string) $page);
        $this->assertArrayHasKey('form', $page->body);
        $form = (string) $page->body['form'];
        $this->assertContains('</form>', $form);
    }

    public function testOnPostValidationFailed()
    {
        $query = ['name' => ''];
        $page = $this->resource->post->uri(self::URI)->withQuery($query)();
        $this->assertSame(400, $page->code);
    }

    public function testOnPost()
    {
        $query = ['name' => 'koriym'];
        $page = $this->resource->post->uri(self::URI)->withQuery($query)();
        $this->assertSame(201, $page->code);
    }
}
