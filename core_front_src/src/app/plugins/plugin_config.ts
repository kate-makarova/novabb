import {LoadRemoteModuleOptions} from '@angular-architects/module-federation-runtime';

export class PluginConfig {
  remoteName: string;
  exposedModule: string;
  remoteEntry: string;
  componentName: string;

  constructor(remoteName: string, componentName: string, exposedModule: string, remoteEntry: string) {
    this.remoteName = remoteName;
    this.exposedModule = exposedModule;
    this.componentName = componentName;
    this.remoteEntry = remoteEntry;
  }

  static init(obj: any): PluginConfig {
    return new PluginConfig(obj.remoteName, obj.componentName, obj.exposedModule, obj.remoteEntry);
  }

   toLoadRemoteModuleOptions(): LoadRemoteModuleOptions {
     return {
       remoteName: this.remoteName,
       exposedModule: this.exposedModule,
       remoteEntry: this.remoteEntry
     }
  }
}
