<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SanitizeInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        
        array_walk_recursive($input, function (&$value, $key) {
            if (is_string($value)) {
                // Remove potential XSS attacks
                $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                
                // Log suspicious input
                if ($this->containsSuspiciousContent($value)) {
                    Log::warning('Suspicious input detected', [
                        'key' => $key,
                        'value' => $value,
                        'ip' => request()->ip(),
                        'user_agent' => request()->userAgent()
                    ]);
                }
            }
        });
        
        $request->merge($input);
        
        return $next($request);
    }
    
    private function containsSuspiciousContent($value): bool
    {
        $suspiciousPatterns = [
            '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi',
            '/<iframe\b[^<]*(?:(?!<\/iframe>)<[^<]*)*<\/iframe>/mi',
            '/javascript:/i',
            '/on\w+\s*=/i',
        ];
        
        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return true;
            }
        }
        
        return false;
    }
}