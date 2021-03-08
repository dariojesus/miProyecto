var CACHE_NAME = 'my-site-cache-v1';
var urlsToCache = ['/index.php'];

//Despliegue del service worker
self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function (cache) {
                console.log('Opened cache');
                return cache.addAll(urlsToCache);
            })
    );
});


//Se devuelve la respuesta del service worker
self.addEventListener('fetch', function (event) {
    event.respondWith(
        caches.match(event.request)
            .then(function (response) {
                //match siempre devuelve respuesta, en caso de que sea correcta tendrá valor, sino no
                if (response) {
                    return response;
                } else {
                    return fetch(event.request).then(function (response) {
                        //Guardamos una copia de la respuesta en cache ya que la queremos usar solo 1 vez
                        let responseClone = response.clone();
                        caches.open(CACHE_NAME).then(function (cache) {
                            cache.put(event.request, responseClone);
                        });
                        return response;
                    }).catch(function () {
                        return caches.match('/index.php');
                    });
                }
            }));
});