import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  private baseUrl = environment.apiUrl; // e.g. http://localhost/api

  constructor(private http: HttpClient) {}

  private handle<T>(obs: Observable<T>): Observable<T> {
    // guarantees JSON parsing
    return obs.pipe(map(res => res as T));
  }

  get<T>(endpoint: string, params: any = {}): Observable<T> {
    return this.handle(
      this.http.get<T>(`${this.baseUrl}${endpoint}`, {
        params,
        responseType: 'json'
      })
    );
  }

  post<T>(endpoint: string, body: any): Observable<T> {
    return this.handle(
      this.http.post<T>(`${this.baseUrl}${endpoint}`, body, {
        responseType: 'json'
      })
    );
  }

  put<T>(endpoint: string, body: any): Observable<T> {
    return this.handle(
      this.http.put<T>(`${this.baseUrl}${endpoint}`, body, {
        responseType: 'json'
      })
    );
  }

  delete<T>(endpoint: string): Observable<T> {
    return this.handle(
      this.http.delete<T>(`${this.baseUrl}${endpoint}`, {
        responseType: 'json'
      })
    );
  }
}
