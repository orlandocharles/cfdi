<?php

namespace Charles\CFDI;

use XmlResourceRetriever\Downloader\DownloaderInterface;
use XmlResourceRetriever\Downloader\PhpDownloader;
use XmlResourceRetriever\XsdRetriever;
use XmlResourceRetriever\XsltRetriever;

class XmlResolver
{
    /** @var string */
    private $localPath = '';

    /** @var DownloaderInterface */
    private $downloader;

    const TYPE_XSD = 'XSD';
    const TYPE_XSLT = 'XSLT';

    public function __construct(string $localPath = null, DownloaderInterface $downloader = null)
    {
        $this->setLocalPath($localPath);
        $this->setDownloader($downloader);
    }

    public static function defaultLocalPath(): string
    {
        return dirname(__DIR__, 2) . '/build/resources/';
    }

    /**
     * Set the localPath to the specified value.
     * $locapPath If null then the value od defaultLocalPath is used.
     *
     * @param string|null $localPath
     */
    public function setLocalPath(string $localPath = null)
    {
        if (null === $localPath) {
            $localPath = $this->defaultLocalPath();
        }
        $this->localPath = $localPath;
    }

    public function getLocalPath(): string
    {
        return $this->localPath;
    }

    /**
     * Return when a local path has been set.
     *
     * @return bool
     */
    public function hasLocalPath(): bool
    {
        return ('' !== $this->localPath);
    }

    /**
     * Set the downloader object.
     * If send a NULL value the object return by defaultDownloader will be set.
     *
     * @param DownloaderInterface|null $downloader
     */
    public function setDownloader(DownloaderInterface $downloader = null)
    {
        if (null === $downloader) {
            $downloader = $this->defaultDownloader();
        }
        $this->downloader = $downloader;
    }

    public static function defaultDownloader(): DownloaderInterface
    {
        return new PhpDownloader();
    }

    public function getDownloader(): DownloaderInterface
    {
        return $this->downloader;
    }

    /**
     * Resolve a resource to a local path.
     * If it does not have a localPath then it will return the exact same resource
     *
     * @param string    $resource   The url
     * @param string    $type       Allows XSD and XSLT
     * @return string
     */
    public function resolve(string $resource, string $type = ''): string
    {
        if (! $this->hasLocalPath()) {
            return $resource;
        }
        if ('' === $type) {
            $type = $this->obtainTypeFromUrl($resource);
        } else {
            $type = strtoupper($type);
        }
        if (static::TYPE_XSD === $type) {
            return $this->resolveXsd($resource);
        }
        if (static::TYPE_XSLT === $type) {
            return $this->resolveXslt($resource);
        }
        throw new \RuntimeException("Unable to handle the resource (Type: $type) $resource");
    }

    public function obtainTypeFromUrl(string $url): string
    {
        if ($this->isResourceExtension($url, 'xsd')) {
            return static::TYPE_XSD;
        }
        if ($this->isResourceExtension($url, 'xslt')) {
            return static::TYPE_XSLT;
        }
        return '';
    }

    private function resolveXsd(string $resource): string
    {
        $retriever = new XsdRetriever($this->getLocalPath(), $this->getDownloader());
        $local = $retriever->buildPath($resource);
        if (! file_exists($local)) {
            $retriever->retrieve($resource);
        }
        return $local;
    }

    private function resolveXslt(string $resource): string
    {
        $retriever = new XsltRetriever($this->getLocalPath(), $this->getDownloader());
        $local = $retriever->buildPath($resource);
        if (! file_exists($local)) {
            $retriever->retrieve($resource);
        }
        return $local;
    }

    private function isResourceExtension(string $resource, string $extension): bool
    {
        $extension = '.' . $extension;
        $length = strlen($resource);
        $extLength = strlen($extension);
        if ($extLength > $length) {
            return false;
        }
        return (0 === substr_compare(strtolower($resource), $extension, $length - $extLength, $extLength));
    }
}
