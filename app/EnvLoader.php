<?php

/**
 * Cargador de Variables de Entorno (.env)
 * Lee el archivo .env y carga las variables en $_ENV
 */
class EnvLoader
{
    protected static $loaded = false;
    
    public static function load($path)
    {
        if (self::$loaded) {
            return;
        }
        
        $envFile = $path . '/.env';
        
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            foreach ($lines as $line) {
                // Ignorar comentarios
                if (strpos(trim($line), '#') === 0) {
                    continue;
                }
                
                // Parsear línea
                if (strpos($line, '=') !== false) {
                    list($name, $value) = explode('=', $line, 2);
                    $name = trim($name);
                    $value = trim($value);
                    
                    // Remover comillas si existen
                    $value = trim($value, '"\'');
                    
                    // Guardar en $_ENV y putenv
                    $_ENV[$name] = $value;
                    putenv("$name=$value");
                }
            }
        }
        
        self::$loaded = true;
    }
    
    public static function get($key, $default = null)
    {
        // Priorizar getenv() que es el estándar de Docker/EasyPanel
        $val = getenv($key);
        if ($val !== false) {
            return $val;
        }
        
        return $_ENV[$key] ?? $default;
    }
}

// Función helper para acceder fácilmente a las variables
function env($key, $default = null)
{
    return EnvLoader::get($key, $default);
}
