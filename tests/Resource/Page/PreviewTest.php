<?php

namespace MyVendor\ContactForm\Resource\Page;

use BEAR\Resource\Exception\BadRequestException;
use PHPUnit\Framework\TestCase;

class PreviewTest extends TestCase
{
    const URI = 'page://self/preview';

    /**
     * @var \BEAR\Resource\ResourceInterface
     */
    private $resource;

    protected function setUp()
    {
        parent::setUp();
        $this->resource = $GLOBALS['RESOURCE'];
    }

    public function testOnGet()
    {
        $page = $this->resource->get->uri(self::URI)->withQuery([])->eager->request();
        $this->assertSame(200, $page->code);
        $this->assertContains('</html>',  (string) $page);
        $this->assertArrayHasKey('form', $page->body);
        $this->assertContains('</form>', (string) $page->body['form']);
    }

    public function testOnPostPreview()
    {
        $query = [
            'is_preview' => '1',
            'name' => 'bear',
            'number' => '20'
        ];
        $page = $this->resource->post->uri(self::URI)->withQuery($query)->eager->request();
        $this->assertSame(100, $page->code);
        $this->assertArrayHasKey('form', $page->body);
        $formHtml = $page->body['form'];
        $this->assertContains('<input type="hidden" name="number" value="20" />', $formHtml);
    }

    public function testOnPost()
    {
        $query = [
            'is_preview' => '0',
            'name' => 'bear',
            'number' => '20'
        ];
        $page = $this->resource->post->uri(self::URI)->withQuery($query)->eager->request();
        $this->assertSame(201, $page->code);
    }
}
