import {Component, AfterViewInit } from '@angular/core';
import {InjectableComponent} from '../core-abstaract-components/injectable.component';

@Component({
  selector: 'app-footer',
  standalone: true,
  templateUrl: `footer.component.html`
})
export class FooterComponent extends InjectableComponent implements AfterViewInit {
  override getComponentName(): string {
    return 'footer';
  }
}
