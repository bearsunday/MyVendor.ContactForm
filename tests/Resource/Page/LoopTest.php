<?php
namespace MyVendor\ContactForm\Resource\Page;

use BEAR\Package\AppInjector;
use BEAR\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;

class LoopTest extends TestCase
{
    const URI = 'page://self/loop';

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
        $this->assertArrayHasKey('form', $page->body);
        $form = (string) $page->body['form'];
        $this->assertContains('</form>', $form);
    }

    public function testOnPost()
    {
        $query = [
            'id' => 1,
            'comment' => 'nice'
        ];
        $page = $this->resource->post->uri(self::URI)->withQuery($query)();
        $this->assertSame(201, $page->code);
    }

    public function testOnPostValidationFailed()
    {
        $query = [
            'id' => 1,
            'comment' => ''
        ];
        $page = $this->resource->post->uri(self::URI)->withQuery($query)();
        $this->assertSame(400, $page->code);
    }
}
