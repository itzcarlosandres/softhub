<?php

namespace App\Helpers;

class ImageOptimizer
{
    /**
     * Optimizar y convertir imagen a WebP
     */
    public static function optimizeImage($sourcePath, $maxWidth = 800, $quality = 85)
    {
        if (!file_exists($sourcePath)) {
            return false;
        }
        
        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            return false;
        }
        
        $mimeType = $imageInfo['mime'];
        $width = $imageInfo[0];
        $height = $imageInfo[1];
        
        // Crear imagen desde el archivo fuente
        switch ($mimeType) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            case 'image/gif':
                $sourceImage = imagecreatefromgif($sourcePath);
                break;
            case 'image/webp':
                // Ya es WebP, solo redimensionar si es necesario
                $sourceImage = imagecreatefromwebp($sourcePath);
                break;
            default:
                return false;
        }
        
        // Calcular nuevas dimensiones manteniendo aspect ratio
        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = ($height / $width) * $maxWidth;
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }
        
        // Crear imagen redimensionada
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preservar transparencia para PNG
        imagealphablending($resizedImage, false);
        imagesavealpha($resizedImage, true);
        
        // Redimensionar
        imagecopyresampled(
            $resizedImage,
            $sourceImage,
            0, 0, 0, 0,
            $newWidth,
            $newHeight,
            $width,
            $height
        );
        
        // Generar nombre del archivo WebP
        $pathInfo = pathinfo($sourcePath);
        $webpPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';
        
        // Guardar como WebP
        imagewebp($resizedImage, $webpPath, $quality);
        
        // Liberar memoria
        imagedestroy($sourceImage);
        imagedestroy($resizedImage);
        
        return $webpPath;
    }
    
    /**
     * Optimizar imagen existente (in-place)
     */
    public static function compressImage($imagePath, $quality = 85)
    {
        if (!file_exists($imagePath)) {
            return false;
        }
        
        $imageInfo = getimagesize($imagePath);
        if (!$imageInfo) {
            return false;
        }
        
        $mimeType = $imageInfo['mime'];
        
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($imagePath);
                imagejpeg($image, $imagePath, $quality);
                imagedestroy($image);
                return true;
                
            case 'image/png':
                $image = imagecreatefrompng($imagePath);
                // PNG usa compresión 0-9 (0 = sin compresión, 9 = máxima)
                $pngQuality = floor((100 - $quality) / 11);
                imagepng($image, $imagePath, $pngQuality);
                imagedestroy($image);
                return true;
                
            case 'image/webp':
                $image = imagecreatefromwebp($imagePath);
                imagewebp($image, $imagePath, $quality);
                imagedestroy($image);
                return true;
        }
        
        return false;
    }
    
    /**
     * Crear thumbnail
     */
    public static function createThumbnail($sourcePath, $thumbWidth = 200, $thumbHeight = 200)
    {
        if (!file_exists($sourcePath)) {
            return false;
        }
        
        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            return false;
        }
        
        $mimeType = $imageInfo['mime'];
        $width = $imageInfo[0];
        $height = $imageInfo[1];
        
        // Crear imagen desde el archivo fuente
        switch ($mimeType) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            case 'image/gif':
                $sourceImage = imagecreatefromgif($sourcePath);
                break;
            case 'image/webp':
                $sourceImage = imagecreatefromwebp($sourcePath);
                break;
            default:
                return false;
        }
        
        // Crear thumbnail cuadrado (crop center)
        $thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);
        
        // Preservar transparencia
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
        
        // Calcular crop
        $sourceRatio = $width / $height;
        $thumbRatio = $thumbWidth / $thumbHeight;
        
        if ($sourceRatio > $thumbRatio) {
            // Imagen más ancha
            $newHeight = $height;
            $newWidth = $height * $thumbRatio;
            $sourceX = ($width - $newWidth) / 2;
            $sourceY = 0;
        } else {
            // Imagen más alta
            $newWidth = $width;
            $newHeight = $width / $thumbRatio;
            $sourceX = 0;
            $sourceY = ($height - $newHeight) / 2;
        }
        
        imagecopyresampled(
            $thumb,
            $sourceImage,
            0, 0,
            $sourceX, $sourceY,
            $thumbWidth, $thumbHeight,
            $newWidth, $newHeight
        );
        
        // Generar nombre del thumbnail
        $pathInfo = pathinfo($sourcePath);
        $thumbPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_thumb.webp';
        
        // Guardar thumbnail
        imagewebp($thumb, $thumbPath, 85);
        
        // Liberar memoria
        imagedestroy($sourceImage);
        imagedestroy($thumb);
        
        return $thumbPath;
    }
    
    /**
     * Obtener tamaño de imagen en bytes
     */
    public static function getImageSize($imagePath)
    {
        if (!file_exists($imagePath)) {
            return 0;
        }
        
        return filesize($imagePath);
    }
    
    /**
     * Formatear tamaño de archivo
     */
    public static function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
