import { Component, AfterViewInit, ViewContainerRef, inject,
  Injector, ComponentRef } from '@angular/core';
import {PluginService} from '../plugins/plugin.service';
import { loadRemoteModule } from '@angular-architects/module-federation';
import {TestService} from '../services/test.service';
import {PluginConfig} from '../plugins/plugin_config';

@Component({
  selector: 'app-header',
  standalone: true,
  template: `<ng-container #vc></ng-container>`
})
export class HeaderComponent implements AfterViewInit {
  private vcr = inject(ViewContainerRef);

  constructor(
    private pluginService: PluginService,
    private injector: Injector,
    private testService: TestService
  ) { }

  async ngAfterViewInit() {
    this.pluginService.loadPlugins('header').subscribe(async plugins => {
      for (let pluginConfigObj of plugins) {
        const pluginConfig: PluginConfig = PluginConfig.init(pluginConfigObj);
        const module = await loadRemoteModule(pluginConfig.toLoadRemoteModuleOptions());
        console.log(module);
        const component = module[pluginConfig.componentName]; // exported from plugin module

        const compRef: ComponentRef<any> = this.vcr.createComponent(component, {
          injector: Injector.create({
            providers: [
              { provide: 'TestService', useValue: this.testService }
            ],
            parent: this.injector
          })
        });
      }
    })
  }
}
