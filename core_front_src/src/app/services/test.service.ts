import { Injectable } from '@angular/core';

@Injectable({ providedIn: 'root' })
export class TestService {
  log(msg: string) {
    console.log('HostService:', msg);
  }
}
