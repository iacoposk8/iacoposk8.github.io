self.addEventListener('push', event => {
  const data = event.data.json(); 

  const title = data.title || 'Notifica';
  const options = {
    body: data.body || '',
    icon: '/icon.png'
  };

  event.waitUntil(
    self.registration.showNotification(title, options)
  );
});
