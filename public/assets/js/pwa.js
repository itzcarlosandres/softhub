// Registro del Service Worker
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/laravel/public/sw.js')
            .then(registration => {
                console.log('✅ Service Worker registrado correctamente:', registration.scope);

                // Verificar actualizaciones periódicamente
                setInterval(() => {
                    registration.update();
                }, 60000); // Cada minuto
            })
            .catch(error => {
                console.log('❌ Error al registrar Service Worker:', error);
            });
    });
}

// Detectar cuando la app está lista para instalarse
let deferredPrompt;
const installButton = document.getElementById('install-pwa-button');

window.addEventListener('beforeinstallprompt', (e) => {
    console.log('PWA: Evento beforeinstallprompt disparado');
    // Prevenir que Chrome muestre el prompt automáticamente
    e.preventDefault();
    // Guardar el evento para usarlo después
    deferredPrompt = e;

    // Mostrar botón de instalación si existe
    if (installButton) {
        installButton.style.display = 'block';

        installButton.addEventListener('click', () => {
            // Ocultar el botón
            installButton.style.display = 'none';
            // Mostrar el prompt de instalación
            deferredPrompt.prompt();
            // Esperar la respuesta del usuario
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('✅ Usuario aceptó instalar la PWA');
                } else {
                    console.log('❌ Usuario rechazó instalar la PWA');
                }
                deferredPrompt = null;
            });
        });
    }
});

// Detectar cuando la app fue instalada
window.addEventListener('appinstalled', (evt) => {
    console.log('✅ PWA instalada correctamente');
    // Ocultar botón de instalación
    if (installButton) {
        installButton.style.display = 'none';
    }

    // Mostrar mensaje de éxito
    showInstallSuccessMessage();
});

// Función para mostrar mensaje de éxito
function showInstallSuccessMessage() {
    const message = document.createElement('div');
    message.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
    message.innerHTML = `
    <div class="flex items-center gap-3">
      <i class="fas fa-check-circle text-2xl"></i>
      <div>
        <p class="font-semibold">¡App instalada!</p>
        <p class="text-sm">Ahora puedes usar SoftHub desde tu pantalla de inicio</p>
      </div>
    </div>
  `;
    document.body.appendChild(message);

    // Remover después de 5 segundos
    setTimeout(() => {
        message.remove();
    }, 5000);
}

// Detectar si la app se está ejecutando como PWA
function isPWA() {
    return window.matchMedia('(display-mode: standalone)').matches ||
        window.navigator.standalone === true;
}

// Mostrar banner si es PWA
if (isPWA()) {
    console.log('✅ Ejecutando como PWA');
    document.body.classList.add('pwa-mode');
}

// Manejo de estado online/offline
window.addEventListener('online', () => {
    console.log('✅ Conexión restaurada');
    showConnectionStatus('online');
});

window.addEventListener('offline', () => {
    console.log('⚠️ Sin conexión');
    showConnectionStatus('offline');
});

function showConnectionStatus(status) {
    const existingBanner = document.getElementById('connection-banner');
    if (existingBanner) {
        existingBanner.remove();
    }

    const banner = document.createElement('div');
    banner.id = 'connection-banner';
    banner.className = `fixed bottom-4 left-1/2 transform -translate-x-1/2 px-6 py-3 rounded-lg shadow-lg z-50 ${status === 'online' ? 'bg-green-500' : 'bg-orange-500'
        } text-white`;

    banner.innerHTML = `
    <div class="flex items-center gap-2">
      <i class="fas fa-${status === 'online' ? 'wifi' : 'wifi-slash'}"></i>
      <span>${status === 'online' ? 'Conexión restaurada' : 'Sin conexión - Modo offline'}</span>
    </div>
  `;

    document.body.appendChild(banner);

    setTimeout(() => {
        banner.remove();
    }, 3000);
}
