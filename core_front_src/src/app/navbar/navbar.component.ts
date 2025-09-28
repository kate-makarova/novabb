import {Component, AfterViewInit } from '@angular/core';
import {InjectableComponent} from '../core-abstaract-components/injectable.component';

@Component({
  selector: 'app-nav',
  standalone: true,
  templateUrl: `navbar.component.html`
})
export class NavbarComponent extends InjectableComponent implements AfterViewInit {
  override getComponentName(): string {
    return 'nav';
  }
}
