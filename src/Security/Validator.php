<?php

declare(strict_types=1);

namespace BrickPHP\Security;

/**
 * Input Validator
 * 
 * Validates and sanitizes user input with XSS protection.
 */
class Validator
{
    private array $data;
    private array $rules;
    private array $errors = [];
    
    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }
    
    /**
     * Validate data against rules
     */
    public function validate(): bool
    {
        foreach ($this->rules as $field => $ruleSet) {
            $rules = explode('|', $ruleSet);
            $value = $this->data[$field] ?? null;
            
            foreach ($rules as $rule) {
                $this->applyRule($field, $value, $rule);
            }
        }
        
        return empty($this->errors);
    }
    
    /**
     * Apply validation rule
     */
    private function applyRule(string $field, mixed $value, string $rule): void
    {
        if (str_starts_with($rule, 'min:')) {
            $min = (int)substr($rule, 4);
            if (is_string($value) && strlen($value) < $min) {
                $this->errors[$field][] = "Field {$field} must be at least {$min} characters";
            }
            return;
        }
        
        if (str_starts_with($rule, 'max:')) {
            $max = (int)substr($rule, 4);
            if (is_string($value) && strlen($value) > $max) {
                $this->errors[$field][] = "Field {$field} must not exceed {$max} characters";
            }
            return;
        }
        
        switch ($rule) {
            case 'required':
                if ($value === null || $value === '') {
                    $this->errors[$field][] = "Field {$field} is required";
                }
                break;
                
            case 'email':
                if ($value !== null && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field][] = "Field {$field} must be a valid email";
                }
                break;
                
            case 'numeric':
                if ($value !== null && !is_numeric($value)) {
                    $this->errors[$field][] = "Field {$field} must be numeric";
                }
                break;
                
            case 'url':
                if ($value !== null && !filter_var($value, FILTER_VALIDATE_URL)) {
                    $this->errors[$field][] = "Field {$field} must be a valid URL";
                }
                break;
                
            case 'alpha':
                if ($value !== null && !ctype_alpha((string)$value)) {
                    $this->errors[$field][] = "Field {$field} must contain only letters";
                }
                break;
                
            case 'alphanumeric':
                if ($value !== null && !ctype_alnum((string)$value)) {
                    $this->errors[$field][] = "Field {$field} must contain only letters and numbers";
                }
                break;
        }
    }
    
    /**
     * Get validation errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
    
    /**
     * Check if validation passed
     */
    public function passes(): bool
    {
        return $this->validate();
    }
    
    /**
     * Check if validation failed
     */
    public function fails(): bool
    {
        return !$this->validate();
    }
    
    /**
     * Sanitize string with XSS protection
     */
    public static function sanitize(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Clean string for database (strip tags)
     */
    public static function clean(string $value): string
    {
        return strip_tags($value);
    }
}
