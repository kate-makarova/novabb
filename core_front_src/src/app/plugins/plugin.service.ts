import { Injectable, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import {PluginConfig} from './plugin_config';
import {environment} from '../../environments/environment';


@Injectable({ providedIn: 'root' })
export class PluginService {
  private http = inject(HttpClient);

  loadPlugins(type: string) {
    const baseUrl = environment.apiUrl;
    return this.http.get<PluginConfig[]>(baseUrl+'/api/plugins/enabled/'+type);
  }
}
