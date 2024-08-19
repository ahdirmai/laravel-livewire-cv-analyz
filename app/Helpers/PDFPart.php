<?php

declare(strict_types=1);

namespace App\Helpers;

use GeminiAPI\Enums\MimeType;
use GeminiAPI\Resources\Parts\PartInterface;
use JsonSerializable;

use function json_encode;

class PDFPart implements PartInterface, JsonSerializable
{
    public function __construct(
        public readonly PDFMimeType $mimeType,
        public readonly string $data,
    ) {}

    /**
     * @return array{
     *     inlineData: array{
     *         mimeType: string,
     *         data: string,
     *     },
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'inlineData' => [
                'mimeType' => $this->mimeType->value,
                'data' => $this->data,
            ],
        ];
    }

    public function __toString(): string
    {
        return json_encode($this) ?: '';
    }
}
