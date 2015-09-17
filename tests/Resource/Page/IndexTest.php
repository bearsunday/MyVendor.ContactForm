<?php

namespace MyVendor\ContactForm\Resource\Page;

class IndexTest extends \PHPUnit_Framework_TestCase
{
    const URI = 'page://self/index';

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
        $query = ['name' => 'koriym'];
        $page = $this->resource->get->uri(self::URI)->withQuery($query)->eager->request();
        $this->assertSame(200, $page->code);
        $this->assertContains('</html>', (string) $page);
        $this->assertArrayHasKey('form', $page->body);
        $form = (string) $page->body['form'];
        $this->assertContains('</form>', $form);
    }

    public function testOnPostValidationFailed()
    {
        $query = ['name' => ''];
        $page = $this->resource->post->uri(self::URI)->withQuery($query)->eager->request();
        $this->assertSame(400, $page->code);
    }

    public function testOnPost()
    {
        $query = ['name' => 'koriym'];
        $page = $this->resource->post->uri(self::URI)->withQuery($query)->eager->request();
        $this->assertSame(201, $page->code);
    }
}
