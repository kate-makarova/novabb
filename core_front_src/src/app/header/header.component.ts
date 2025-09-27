import { Component, AfterViewInit, ViewContainerRef, inject,
  Injector, ComponentRef } from '@angular/core';
import {PluginService} from '../plugins/plugin.service';
import { loadRemoteModule } from '@angular-architects/module-federation';
import {PluginConfig} from '../plugins/plugun_config';
import {TestService} from '../services/test.service';
import {Router} from '@angular/router';

@Component({
  selector: 'plugin-host',
  standalone: true,
  template: `<h3>Plugin Host</h3><ng-container #vc></ng-container>`
})
export class HeaderComponent implements AfterViewInit {
  private vcr = inject(ViewContainerRef);

  constructor(
    private pluginService: PluginService,
              private injector: Injector,
    private router: Router,
    private testService: TestService
  ) { }

  async ngAfterViewInit() {
    this.pluginService.loadPlugins().subscribe(async plugins => {
      const pluginConfig: PluginConfig = plugins[0];
      const module = await loadRemoteModule(pluginConfig);
      console.log(module);
      const component = module.HelloComponent; // exported from plugin module

      const compRef: ComponentRef<any> = this.vcr.createComponent(component, {
        injector: Injector.create({
          providers: [
            { provide: 'TestService', useValue: this.testService }
          ],
          parent: this.injector
        })
      });

    //  compRef.instance.testService.log('Hello from plugin!');
      this.router.resetConfig([...router.config, ...module.helloRoutes]);
    })
  }
}
