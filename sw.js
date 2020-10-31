const CACHE_NAME = '7cf4f619bc27ff5fdd68d8d947b802c7';
const FILES = ['blogs/date-ing-javascript.html','blogs/distro-dilemma-of-a-linux-nerd.html','blogs/evolution-of-web-as-a-platform.html','blogs/how-is-this-monospace.html','blogs/learning-from-code-reviews.html','blogs/real-easy-way-to-transfer-files-from-linux.html','blogs/regrets-in-a-1-year-old-react-project.html','blogs/squremote.html','blogs/unit-testing-recompose-hocs.html','blogs/youtube-ad-auto-skipper.html','index.html'];

self.addEventListener('install', e => {
  e.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      const urls = FILES.map(name => `/${name}`);
      return cache.addAll(urls);
    })
  );
});

self.addEventListener('fetch', e => {
  e.respondWith(
    caches.match(e.request, { cacheName: CACHE_NAME }).then(res => {
      if (res) {
        return res;
      }

      return fetch(e.request).then(response => {
        if (!response || response.status !== 200 || response.type !== 'basic') {
          return response;
        }

        const clonedResponse = response.clone();

        caches.open(CACHE_NAME).then(cache => {
          cache.put(e.request, clonedResponse);
        });

        return response;
      });
    })
  );
});
