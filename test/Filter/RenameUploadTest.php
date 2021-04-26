<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-content-negotiation for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-content-negotiation/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\ContentNegotiation\Filter;

use DirectoryIterator;
use Laminas\Http\Request as HttpRequest;
use PHPUnit\Framework\TestCase;

use function file_exists;
use function file_put_contents;
use function filesize;
use function is_dir;
use function mkdir;
use function rmdir;
use function sprintf;
use function sys_get_temp_dir;
use function tempnam;
use function unlink;

use const DIRECTORY_SEPARATOR;
use const UPLOAD_ERR_OK;

class RenameUploadTest extends TestCase
{
    protected function setUp(): void
    {
        $this->tmpDir    = sys_get_temp_dir() . '/api-tools-content-negotiation-filter';
        $this->uploadDir = $this->tmpDir . '/upload';
        $this->targetDir = $this->tmpDir . '/target';
        $this->tearDown();
        mkdir($this->tmpDir);
        mkdir($this->uploadDir);
        mkdir($this->targetDir);
    }

    protected function tearDown(): void
    {
        if (! is_dir($this->tmpDir)) {
            return;
        }

        if (is_dir($this->uploadDir)) {
            $this->removeDir($this->uploadDir);
        }

        if (is_dir($this->targetDir)) {
            $this->removeDir($this->targetDir);
        }

        rmdir($this->tmpDir);
    }

    /**
     * @return array
     */
    public function createUploadFile()
    {
        $filename = tempnam($this->uploadDir, 'laminasc');
        file_put_contents($filename, sprintf('File created by %s', self::class));

        return [
            'name'     => 'test.txt',
            'type'     => 'text/plain',
            'tmp_name' => $filename,
            'size'     => filesize($filename),
            'error'    => UPLOAD_ERR_OK,
        ];
    }

    /**
     * @param string $dir
     * @return void
     */
    public function removeDir($dir)
    {
        $it = new DirectoryIterator($dir);
        foreach ($it as $file) {
            if ($file->isDot()) {
                continue;
            }
            if ($file->isDir()) {
                $this->removeDir($file->getPathname());
                continue;
            }
            unlink($file->getPathname());
        }
        unset($it);
        rmdir($dir);
    }

    /**
     * @return string[][]
     */
    public function uploadMethods()
    {
        return [
            'put'   => ['PUT'],
            'patch' => ['PATCH'],
        ];
    }

    /**
     * @param string $method
     * @dataProvider uploadMethods
     */
    public function testMoveUploadedFileSucceedsOnPutAndPatchHttpRequests($method)
    {
        $target  = $this->targetDir . DIRECTORY_SEPARATOR . 'uploaded.txt';
        $file    = $this->createUploadFile();
        $request = new HttpRequest();
        $request->setMethod($method);

        $filter = new RenameUpload($target);
        $filter->setRequest($request);

        $result = $filter->filter($file);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('tmp_name', $result);
        $this->assertEquals($target, $result['tmp_name']);

        $this->assertTrue(file_exists($target));
        $this->assertFalse(file_exists($file['tmp_name']));
    }
}
