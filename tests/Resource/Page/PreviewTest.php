<?php
namespace MyVendor\ContactForm\Resource\Page;

use BEAR\Package\AppInjector;
use BEAR\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;

class PreviewTest extends TestCase
{
    const URI = 'page://self/preview';

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
        $page = $this->resource->uri(self::URI)->withQuery([])();
        $this->assertSame(200, $page->code);
        $this->assertContains('</html>', (string) $page);
        $this->assertArrayHasKey('form', $page->body);
        $this->assertContains('</form>', (string) $page->body['form']);
    }

    public function testOnPostPreview()
    {
        $query = [
            'is_preview' => '1',
            'name' => 'bear',
            'number' => '20',
            'interests' => ['art']
        ];
        $page = $this->resource->post->uri(self::URI)->withQuery($query)();
        $this->assertSame(200, $page->code);
        $this->assertSame(1, $page->body['is_preview']);
        $this->assertArrayHasKey('form', $page->body);
        $formHtml = $page->body['form'];
        $this->assertContains('<input type="hidden" name="number" value="20" />', $formHtml);
    }

    public function testOnPost()
    {
        $query = [
            'is_preview' => '0',
            'name' => 'bear',
            'number' => '20',
            'interests' => ['art']
        ];
        $page = $this->resource->post->uri(self::URI)->withQuery($query)();
        $this->assertSame(201, $page->code);
    }
}
