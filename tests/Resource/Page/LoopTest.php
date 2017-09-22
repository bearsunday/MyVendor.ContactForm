<?php

namespace MyVendor\ContactForm\Resource\Page;

use PHPUnit\Framework\TestCase;

class LoopTest extends TestCase
{
    const URI = 'page://self/loop';

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
        $page = $this->resource->get->uri(self::URI)->eager->request();
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
        $page = $this->resource->post->uri(self::URI)->withQuery($query)->eager->request();
        $this->assertSame(201, $page->code);
    }

    public function testOnPostValidationFailed()
    {
        $query = [
            'id' => 1,
            'comment' => ''
        ];
        $page = $this->resource->post->uri(self::URI)->withQuery($query)->eager->request();
        $this->assertSame(400, $page->code);
    }
}
