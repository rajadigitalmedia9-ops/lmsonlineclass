const CACHE_NAME = "artin-lms-v2";
const urlsToCache = [
  "/",
  "/student/dashboard"
];

self.addEventListener("install", event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(urlsToCache);
      })
  );
  self.skipWaiting();
});

self.addEventListener("activate", event => {
  event.waitUntil(self.clients.claim());
});

self.addEventListener("fetch", event => {
  // Bypass Service Worker for cross-origin requests (like Cloudflare R2 videos)
  // and bypass for any video/audio range requests to prevent breaking the player.
  if (!event.request.url.startsWith(self.location.origin) || 
      event.request.headers.has('range') ||
      event.request.url.match(/\.(mp4|webm|ogg)$/i)) {
    return; // Let the browser handle the request natively
  }

  event.respondWith(
    caches.match(event.request)
      .then(response => {
        if (response) {
          return response;
        }
        return fetch(event.request);
      })
  );
});
