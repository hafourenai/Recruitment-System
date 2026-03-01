<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SanitizeInput
{
    private array $except = [
        'password',
        'password_confirmation',
        'token',
    ];

    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        
        array_walk_recursive($input, function (&$value, $key) use ($request) {
            if (is_string($value) && !$this->shouldSkip($key)) {
                $originalValue = $value;
                
                $value = $this->sanitize($value);
                
                if ($value !== $originalValue && $this->containsSuspiciousContent($originalValue)) {
                    Log::warning('Potentially malicious input sanitized', [
                        'key' => $key,
                        'ip' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'route' => $request->route()?->uri(),
                    ]);
                }
            }
        });
        
        $request->merge($input);
        
        return $next($request);
    }
    
    private function shouldSkip(string $key): bool
    {
        return in_array($key, $this->except);
    }
    
    private function sanitize(string $value): string
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        return $value;
    }
    
    private function containsSuspiciousContent(string $value): bool
    {
        $suspiciousPatterns = [
            '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi',
            '/<iframe\b[^<]*(?:(?!<\/iframe>)<[^<]*)*<\/iframe>/mi',
            '/<object\b[^<]*(?:(?!<\/object>)<[^<]*)*<\/object>/mi',
            '/<embed\b[^<]*(?:(?!<\/embed>)<[^<]*)*<\/embed>/mi',
            '/javascript:/i',
            '/on\w+\s*=/i',
            '/data:\s*text\/html/i',
            '/expression\s*\(/i',
            '/<\?php/i',
        ];
        
        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return true;
            }
        }
        
        return false;
    }
}