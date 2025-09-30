import { initFederation } from '@angular-architects/module-federation';
import {environment} from './environments/environment';

async function loadPlugins() {
  const baseUrl = environment.apiUrl;
  const response = await fetch(baseUrl + '/api/manifest');
  const plugins: Record<string, string> = await response.json();
  console.log(plugins);

  await initFederation(plugins);
  await import('./bootstrap');
}

loadPlugins().catch(err => console.error('Federation init failed', err));
