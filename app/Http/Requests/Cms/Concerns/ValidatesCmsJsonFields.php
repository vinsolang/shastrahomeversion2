<?php

declare(strict_types=1);

namespace App\Http\Requests\Cms\Concerns;

trait ValidatesCmsJsonFields
{
    protected function validateDecodedJson($validator, array $definitions): void
    {
        foreach ($definitions as $definition) {
            $key = $definition['key'] ?? null;
            $type = $definition['type'] ?? null;

            if (! is_string($key) || $type !== 'json') {
                continue;
            }

            $raw = $this->input("sections.{$key}");

            if (! is_string($raw) || trim($raw) === '') {
                $validator->errors()->add(
                    "sections.{$key}",
                    'This section is required.',
                );

                continue;
            }

            try {
                $decoded = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException) {
                $decoded = null;
            }

            if (! is_array($decoded)) {
                $validator->errors()->add(
                    "sections.{$key}",
                    'This section must decode to a JSON object or array.',
                );
            }
        }
    }
}
