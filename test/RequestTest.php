<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-content-negotiation for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ApiTools\ContentNegotiation;

use Laminas\ApiTools\ContentNegotiation\Request;
use PHPUnit\Framework\TestCase;
use ReflectionObject;
use ReflectionProperty;

use function method_exists;
use function realpath;
use function stream_get_contents;

class RequestTest extends TestCase
{
    protected function setUp(): void
    {
        $this->request = new Request();
    }

    public function testIsAnHttpRequest()
    {
        $this->assertInstanceOf(\Laminas\Http\Request::class, $this->request);
    }

    public function testIsAPhpEnvironmentHttpRequest()
    {
        $this->assertInstanceOf(\Laminas\Http\PhpEnvironment\Request::class, $this->request);
    }

    public function testDefinesAGetContentAsStreamMethod()
    {
        $this->assertTrue(method_exists($this->request, 'getContentAsStream'));
    }

    public function testDefaultContentStreamIsPhpInputStream()
    {
        $property = $this->getContentStreamReflectionProperty();

        $this->assertSame('php://input', $property->getValue($this->request));
    }

    public function testCanSetStreamUriForContent()
    {
        $property = $this->getContentStreamReflectionProperty();

        $expected = 'file://' . realpath(__FILE__);
        $this->request->setContentStream($expected);

        $this->assertSame($expected, $property->getValue($this->request));
    }

    public function testGetContentAsStreamReturnsResource()
    {
        $this->request->setContentStream('file://' . realpath(__FILE__));
        $stream = $this->request->getContentAsStream();
        $this->assertIsResource($stream);
    }

    public function testReturnsPhpTemporaryStreamIfContentHasAlreadyBeenRetrieved()
    {
        $r = new ReflectionObject($this->request);
        $p = $r->getProperty('content');
        $p->setAccessible(true);
        $p->setValue($this->request, 'bam!');

        $stream = $this->request->getContentAsStream();
        $this->assertEquals('bam!', stream_get_contents($stream));
    }

    private function getContentStreamReflectionProperty(): ReflectionProperty
    {
        $property = new ReflectionProperty(Request::class, 'contentStream');
        $property->setAccessible(true);

        return $property;
    }
}
