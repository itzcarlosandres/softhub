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
        
        if (!file_exists($envFile)) {
            // Si no existe .env, intentar con .env.example
            $envFile = $path . '/.env.example';
            if (!file_exists($envFile)) {
                throw new Exception('.env file not found');
            }
        }
        
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
        
        self::$loaded = true;
    }
    
    public static function get($key, $default = null)
    {
        return $_ENV[$key] ?? getenv($key) ?: $default;
    }
}

// Función helper para acceder fácilmente a las variables
function env($key, $default = null)
{
    return EnvLoader::get($key, $default);
}
