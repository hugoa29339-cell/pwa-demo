if ("serviceWorker" in navigator) {
    console.log("Navegador admite Service worker.");
    if (navigator.serviceWorker.controller) {
        console.log("El service worker ya existe, no se necesita registralo de nuevo");
    } else {
        // Registra el service worker y lo deja ejecutandose en segundo plano (otro hilo)
        console.log("Registrar Service worker.");
        navigator.serviceWorker.register("pwa_sw.js", {
                scope: "./"
        }).then(function (reg) {
            console.log("Service worker ha sido registrado para: " + reg.scope);
        }).catch(function(err) {
        // registration failed :(
        console.log('NO se ha podido registrar el ServiceWorker: ', err);
        });
    }
}