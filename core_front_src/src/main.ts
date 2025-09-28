import { initFederation } from '@angular-architects/module-federation';

async function loadPlugins() {
  const response = await fetch('http://localhost:8000/api/manifest');
  const plugins: Record<string, string> = await response.json();
  console.log(plugins);

  await initFederation(plugins);
  await import('./bootstrap');
}

loadPlugins().catch(err => console.error('Federation init failed', err));
