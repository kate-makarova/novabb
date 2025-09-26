import { Component, AfterViewInit, ViewContainerRef, inject } from '@angular/core';
import {PluginService} from '../plugins/plugin.service';
import { loadRemoteModule } from '@angular-architects/module-federation';
import {PluginConfig} from '../plugins/plugun_config';


@Component({
  selector: 'plugin-host',
  standalone: true,
  template: `<h3>Plugin Host</h3><ng-container #vc></ng-container>`
})
export class HeaderComponent implements AfterViewInit {
  private vcr = inject(ViewContainerRef);

  constructor(private pluginService: PluginService) { }

  async ngAfterViewInit() {
    this.pluginService.loadPlugins().subscribe(async plugins => {
      const pluginConfig: PluginConfig = plugins[0];
      const module = await loadRemoteModule(pluginConfig);
      console.log(module);
      const component = module.HelloComponent; // exported from plugin module
      this.vcr.createComponent(component);
    })
  }
}
