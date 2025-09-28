import {Injectable} from '@angular/core';

@Injectable({ providedIn: 'root' })
export class ThemeService {
  private themeLinkId = 'app-theme';

  setTheme(href: string) {
    let linkEl = document.getElementById(this.themeLinkId) as HTMLLinkElement;

    if (!linkEl) {
      linkEl = document.createElement('link');
      linkEl.id = this.themeLinkId;
      linkEl.rel = 'stylesheet';
      document.head.appendChild(linkEl);
    }

    linkEl.href = href;
  }
}
