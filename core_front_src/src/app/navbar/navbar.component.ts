import {Component, AfterViewInit } from '@angular/core';
import {InjectableComponent} from '../core-abstaract-components/injectable.component';
import {RouterLink} from '@angular/router';

@Component({
  selector: 'app-nav',
  standalone: true,
  imports: [
    RouterLink
  ],
  templateUrl: `navbar.component.html`
})
export class NavbarComponent extends InjectableComponent implements AfterViewInit {
  override getComponentName(): string {
    return 'nav';
  }
}
