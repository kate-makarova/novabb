import { Injectable, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import {PluginConfig} from './plugin_config';


@Injectable({ providedIn: 'root' })
export class PluginService {
  private http = inject(HttpClient);

  loadPlugins(type: string) {
    return this.http.get<PluginConfig[]>('http://localhost:8000/api/plugins/enabled/'+type);
  }
}
