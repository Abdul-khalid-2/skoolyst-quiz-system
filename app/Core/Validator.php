<?php
declare(strict_types=1);

namespace Skoolyst\Core;

class Validator {
    public static function make(array $data, array $rules): array {
        $errors = [];

        foreach ($rules as $field => $ruleString) {
            $value = $data[$field] ?? null;

            foreach (explode('|', $ruleString) as $rule) {
                $param = null;
                if (str_contains($rule, ':')) {
                    [$rule, $param] = explode(':', $rule, 2);
                }

                $error = match ($rule) {
                    'required' => (trim((string) $value) === '') ? 'This field is required.' : null,
                    'email' => ($value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL))
                        ? 'Please enter a valid email address.' : null,
                    'min' => ($value !== null && strlen((string) $value) < (int) $param)
                        ? "Must be at least {$param} characters." : null,
                    'confirmed' => ($value !== ($data[$field . '_confirmation'] ?? null))
                        ? 'The confirmation does not match.' : null,
                    default => null,
                };

                if ($error !== null) {
                    $errors[$field] = $error;
                    break;
                }
            }
        }

        return $errors;
    }
}
