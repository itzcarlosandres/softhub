<?php
ob_start();
?>

<section class="min-h-screen bg-gray-50 dark:bg-gray-900 py-20 px-6 transition-colors duration-300">
    <div class="max-w-5xl mx-auto space-y-24">
        
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-4 font-outfit uppercase tracking-tighter">
                Demos de Títulos <span class="text-blue-600">Dinámicos</span>
            </h1>
            <p class="text-gray-500 dark:text-gray-400">Elige el estilo que más te guste para tu web.</p>
        </div>

        <!-- 1. TYPEWRITER EFFECT -->
        <div class="glass-panel p-12 rounded-[3rem] text-center border border-gray-100 dark:border-gray-800 bg-white/50 dark:bg-gray-800/50 backdrop-blur-xl">
            <span class="text-[10px] uppercase font-bold text-blue-500 tracking-widest mb-4 block">Opción 1: Typewriter</span>
            <h2 class="text-4xl md:text-6xl font-black text-gray-900 dark:text-white font-outfit leading-tight mb-8">
                Descubre Programas <br>
                <span id="typewriter" class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 border-r-4 border-purple-500 pr-1"></span>
            </h2>
            <div class="h-2 w-24 bg-gray-100 dark:bg-gray-700 mx-auto rounded-full"></div>
        </div>

        <!-- 2. VERTICAL SLIDE EFFECT -->
        <div class="glass-panel p-12 rounded-[3rem] text-center border border-gray-100 dark:border-gray-800 bg-white/50 dark:bg-gray-800/50 backdrop-blur-xl">
            <span class="text-[10px] uppercase font-bold text-purple-500 tracking-widest mb-4 block">Opción 2: Vertical Slide</span>
            <h2 class="text-4xl md:text-6xl font-black text-gray-900 dark:text-white font-outfit leading-tight flex flex-col items-center justify-center">
                <span>Tu sitio web para</span>
                <div class="relative h-[1.2em] w-full overflow-hidden mt-2">
                    <div id="slide-words" class="flex flex-col items-center transition-all duration-500 ease-in-out">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600 h-[1.2em]">Programas Full</span>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600 h-[1.2em]">Apps Premium</span>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600 h-[1.2em]">Juegos de PC</span>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600 h-[1.2em]">Cursos Gratis</span>
                    </div>
                </div>
            </h2>
        </div>

        <!-- 3. FADE & BLUR EFFECT -->
        <div class="glass-panel p-12 rounded-[3rem] text-center border border-gray-100 dark:border-gray-800 bg-white/50 dark:bg-gray-800/50 backdrop-blur-xl">
            <span class="text-[10px] uppercase font-bold text-green-500 tracking-widest mb-4 block">Opción 3: Fade & Blur</span>
            <h2 class="text-4xl md:text-6xl font-black text-gray-900 dark:text-white font-outfit leading-tight">
                El mejor contenido <br>
                <span id="fade-word" class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-blue-600 transition-all duration-500">Siempre Premium</span>
            </h2>
        </div>

        <!-- 4. DOTS BACKGROUND & SPOTLIGHT -->
        <div class="relative overflow-hidden rounded-[3rem] p-12 text-center group bg-black border border-white/10 demo-dots-section">
            <!-- Dotted Background Canvas -->
            <div class="absolute inset-0 z-0 opacity-40 dotted-bg"></div>
            
            <!-- Spotlight Gradient -->
            <div class="absolute inset-0 z-10 pointer-events-none spotlight-effect"></div>

            <div class="relative z-20">
                <span class="text-[10px] uppercase font-bold text-blue-400 tracking-widest mb-4 block">NUEVO: FONDO DE PUNTOS & SPOTLIGHT</span>
                <h2 class="text-4xl md:text-6xl font-black text-white font-outfit leading-tight mb-8">
                    Diseño <span class="text-blue-500">Minimalista</span> <br>
                    con Fondo de Puntos
                </h2>
                <p class="text-gray-400 max-w-xl mx-auto mb-8">
                    Este fondo utiliza una rejilla de puntos (dots) con un efecto de luz (spotlight) que sigue al ratón para un look tecnológico y moderno.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <button class="px-8 py-3 bg-blue-600 text-white rounded-full font-bold hover:bg-blue-500 transition shadow-lg shadow-blue-600/20">Probar Ahora</button>
                    <button class="px-8 py-3 bg-white/5 text-white border border-white/10 rounded-full font-bold hover:bg-white/10 transition">Más Info</button>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // --- SPOTLIGHT DOTS EFFECT ---
    const dotsSection = document.querySelector('.demo-dots-section');
    const spotlight = document.querySelector('.spotlight-effect');
    
    if (dotsSection && spotlight) {
        dotsSection.addEventListener('mousemove', (e) => {
            const rect = dotsSection.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            spotlight.style.background = `radial-gradient(600px circle at ${x}px ${y}px, rgba(59, 130, 246, 0.15), transparent 80%)`;
        });
        
        dotsSection.addEventListener('mouseleave', () => {
            spotlight.style.background = `radial-gradient(600px circle at 50% 50%, rgba(59, 130, 246, 0.05), transparent 80%)`;
        });
    }

    // --- 1. TYPEWRITER ---
    const typewriterElement = document.getElementById('typewriter');
    const typewriterWords = ["Full y Premium", "Paso a Paso", "100% Verificado", "Sin Virus"];
    let wordIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    let typeSpeed = 150;

    function type() {
        if (!typewriterElement) return;
        const currentWord = typewriterWords[wordIndex];
        if (isDeleting) {
            typewriterElement.textContent = currentWord.substring(0, charIndex - 1);
            charIndex--;
            typeSpeed = 75;
        } else {
            typewriterElement.textContent = currentWord.substring(0, charIndex + 1);
            charIndex++;
            typeSpeed = 150;
        }

        if (!isDeleting && charIndex === currentWord.length) {
            isDeleting = true;
            typeSpeed = 2000; // Wait at end
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            wordIndex = (wordIndex + 1) % typewriterWords.length;
            typeSpeed = 500;
        }

        setTimeout(type, typeSpeed);
    }
    type();

    // --- 2. VERTICAL SLIDE ---
    const slideWords = document.getElementById('slide-words');
    let slideIndex = 0;
    const totalSlides = 4;

    function slide() {
        if (!slideWords) return;
        slideIndex = (slideIndex + 1) % totalSlides;
        slideWords.style.transform = `translateY(-${slideIndex * 1.2}em)`;
        setTimeout(slide, 2500);
    }
    setTimeout(slide, 2500);

    // --- 3. FADE ---
    const fadeElement = document.getElementById('fade-word');
    const fadeWords = ["Siempre Premium", "Sin Publicidad", "Descarga Directa", "Soporte 24/7"];
    let fadeIndex = 0;

    function fade() {
        if (!fadeElement) return;
        fadeElement.style.opacity = '0';
        fadeElement.style.filter = 'blur(10px)';
        fadeElement.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            fadeIndex = (fadeIndex + 1) % fadeWords.length;
            fadeElement.textContent = fadeWords[fadeIndex];
            fadeElement.style.opacity = '1';
            fadeElement.style.filter = 'blur(0)';
            fadeElement.style.transform = 'scale(1)';
        }, 500);
        
        setTimeout(fade, 3000);
    }
    setTimeout(fade, 3000);

});
</script>

<style>
.glass-panel {
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(20px);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.glass-panel:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}
#typewriter {
    animation: blink 0.7s infinite;
}
@keyframes blink {
    50% { border-color: transparent; }
}

/* Background Dots Pattern */
.dotted-bg {
    background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
    background-size: 24px 24px;
}

/* Spotlight Effect Initial State */
.spotlight-effect {
    background: radial-gradient(600px circle at 50% 50%, rgba(59, 130, 246, 0.05), transparent 80%);
    transition: background 0.15s ease-out;
}
</style>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
