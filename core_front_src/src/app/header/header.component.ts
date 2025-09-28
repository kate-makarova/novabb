import {Component, AfterViewInit} from '@angular/core';
import {InjectableComponent} from '../core-abstaract-components/injectable.component';

@Component({
  selector: 'app-header',
  standalone: true,
  template: `<ng-container #vc></ng-container>`
})
export class HeaderComponent extends InjectableComponent implements AfterViewInit {

  override getComponentName(): string {
    return 'header';
  }
}
