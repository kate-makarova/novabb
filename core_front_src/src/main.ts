import { initFederation } from '@angular-architects/module-federation';

async function loadPlugins() {
  // 👇 Fetch a list of available plugins from your backend or config API
  const response = await fetch('http://localhost:8000/api/manifest');
  const plugins: Record<string, string> = await response.json();
  console.log(plugins);

  // plugins example returned by backend:
  // {
  //   "helloPlugin": "http://localhost:4201/remoteEntry.js",
  //   "otherPlugin": "http://localhost:4300/remoteEntry.js"
  // }

  await initFederation(plugins); // Pass manifest object directly
  await import('./bootstrap');
}

loadPlugins().catch(err => console.error('Federation init failed', err));
