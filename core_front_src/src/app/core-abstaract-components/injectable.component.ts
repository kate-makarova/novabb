import {AfterViewInit, ViewContainerRef, Injector, ViewChild, Directive} from '@angular/core';
import {PluginService} from '../plugins/plugin.service';
import { loadRemoteModule } from '@angular-architects/module-federation';
import {PluginConfig} from '../plugins/plugin_config';
import {ApiService} from '../services/api.service';

@Directive()
export abstract class InjectableComponent implements AfterViewInit {
  @ViewChild('vc', { read: ViewContainerRef, static: true })
  private vcr!: ViewContainerRef;

  constructor(private pluginService: PluginService, private injector: Injector, private apiService: ApiService) {}

  abstract getComponentName(): string;

  async ngAfterViewInit() {
    this.pluginService.loadPlugins(this.getComponentName()).subscribe(async plugins => {
      for (let pluginConfigObj of plugins) {
        const pluginConfig: PluginConfig = PluginConfig.init(pluginConfigObj);
        const module = await loadRemoteModule(pluginConfig.toLoadRemoteModuleOptions());
        console.log(module);
        const component = module[pluginConfig.componentName]; // exported from plugin module

        this.vcr.createComponent(component, {
          injector: Injector.create({
            providers: [{ provide: 'ApiService', useValue: this.apiService }],
            parent: this.injector
          })
        });
      }
    });
  }
}
