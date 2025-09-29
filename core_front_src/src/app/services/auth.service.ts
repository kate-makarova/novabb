import { Injectable } from '@angular/core';
import { JwtHelperService } from '@auth0/angular-jwt';
import {ApiService} from './api.service';
import {tap} from 'rxjs';
import {HttpClient} from '@angular/common/http';

@Injectable({ providedIn: 'root' })
export class AuthService {
  constructor(private jwtHelper: JwtHelperService,
              private http: HttpClient) { }

  login(email: string, password: string) {
    return this.http.post<{ access_token: string }>('/api/login', { email, password })
      .pipe(
        tap(res => {
          localStorage.setItem('access_token', res.access_token);
        })
      );
  }

  logout() {
    localStorage.removeItem('access_token');
  }

  isLoggedIn(): boolean {
    const token = localStorage.getItem('access_token');
    return token != null && !this.jwtHelper.isTokenExpired(token);
  }

  getDecodedToken() {
    const token = localStorage.getItem('access_token');
    return token ? this.jwtHelper.decodeToken(token) : null;
  }
}
