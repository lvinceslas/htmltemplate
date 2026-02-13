<?php

namespace Tests\Lvinceslas\Html;

use Lvinceslas\Html\HtmlTemplate;
use PHPUnit\Framework\TestCase;
use stdClass;

class HtmlTemplateTest extends TestCase
{
    public function testCanBeCreatedFromValidHtmlTemplateFile(): void
    {
        $this->assertInstanceOf(
            HtmlTemplate::class ,
            new HtmlTemplate(__DIR__ . '/test.html')
        );
    }

    public function testCannotBeCreatedFromInvalidHtmlTemplateFile(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new HtmlTemplate('invalid');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'Hello <b>{%NAME%}</b>, you have successfully installed <em>lvinceslas/htmltemplate</em> !',
            new HtmlTemplate(__DIR__ . '/test.html')
        );
    }

    public function testGetFilepath(): void
    {
        $filepath = __DIR__ . '/test.html';
        $v = new HtmlTemplate($filepath);
        $this->assertSame($filepath, $v->getFilepath());
    }

    public function testSetFilepathWithInvalidFilepath(): void
    {
        $this->expectException(\TypeError::class);
        $v = new HtmlTemplate(__DIR__ . '/test.html');
        $v->setFilepath(new stdClass());

    }

    public function testSetFilepathWithUnfoundFilepath(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $v = new HtmlTemplate(__DIR__ . '/test.html');
        $v->setFilepath(__DIR__ . '/unfound.html');
    }

    public function testSetFilepathWithValidFilepath(): void
    {
        $v = new HtmlTemplate(__DIR__ . '/test.html');
        $this->assertSame($v, $v->setFilepath(__DIR__ . '/test.html'));
    }

    public function testSetWithInvalidName(): void
    {
        $this->expectException(\TypeError::class);
        $v = new HtmlTemplate(__DIR__ . '/test.html');
        $v->set(new stdClass());
    }

    public function testSetReplacesPlaceholderWithGivenValue(): void
    {
        $v = new HtmlTemplate(__DIR__ . '/test.html');
        $result = $v->set('NAME', 'John');

        $this->assertSame($v, $result, 'set() should return $this for method chaining');
        $this->assertSame(
            'Hello <b>John</b>, you have successfully installed <em>lvinceslas/htmltemplate</em> !',
            (string)$v
        );
    }

    public function testSetSupportsMethodChaining(): void
    {
        $v = new HtmlTemplate(__DIR__ . '/test.html');
        $result = $v->set('NAME', 'John');

        $this->assertSame($v, $result);
    }

    public function testSetWithNullValueRemovesPlaceholder(): void
    {
        $v = new HtmlTemplate(__DIR__ . '/test.html');
        $v->set('NAME');

        $this->assertSame(
            'Hello <b></b>, you have successfully installed <em>lvinceslas/htmltemplate</em> !',
            (string)$v
        );
    }

    public function testShowPrintsCurrentHtml(): void
    {
        $v = new HtmlTemplate(__DIR__ . '/test.html');
        $v->set('NAME', 'Jane');

        ob_start();
        $v->show();
        $output = ob_get_clean();

        $this->assertSame((string)$v, $output);
    }

    public function testConstructorWithUnreadableFileThrowsRuntimeException(): void
    {
        $filepath = __DIR__ . '/unreadable.html';
        file_put_contents($filepath, 'content');
        chmod($filepath, 0222); // write only, not readable

        // Si le fichier reste lisible (cas typique en root dans un conteneur),
        // on ne peut pas tester ce comportement de manière fiable.
        if (is_readable($filepath)) {
            chmod($filepath, 0644);
            unlink($filepath);
            $this->markTestSkipped('Impossible de rendre le fichier illisible sur cette plateforme (probablement exécuté en root).');
        }

        try {
            $this->expectException(\RuntimeException::class);
            new HtmlTemplate($filepath);
        }
        finally {
            // Ensure we can clean up the file whatever happens
            chmod($filepath, 0644);
            unlink($filepath);
        }
    }

    public function testSetFilepathWithUnreadableFileThrowsRuntimeException(): void
    {
        $v = new HtmlTemplate(__DIR__ . '/test.html');

        $filepath = __DIR__ . '/unreadable_set.html';
        file_put_contents($filepath, 'content');
        chmod($filepath, 0222); // write only, not readable

        // Même logique : si le fichier reste lisible, on ne peut pas tester ce cas.
        if (is_readable($filepath)) {
            chmod($filepath, 0644);
            unlink($filepath);
            $this->markTestSkipped('Impossible de rendre le fichier illisible sur cette plateforme (probablement exécuté en root).');
        }

        try {
            $this->expectException(\RuntimeException::class);
            $v->setFilepath($filepath);
        }
        finally {
            chmod($filepath, 0644);
            unlink($filepath);
        }
    }
}