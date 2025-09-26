import {Component, OnInit} from '@angular/core';
import {ApiService} from '../services/api.service';

@Component({
  templateUrl: './main-page.component.html',
})
export class MainPageComponent implements OnInit {
  response: string | undefined;
  constructor(private apiService: ApiService) {}
    ngOnInit(): void {
       this.apiService.get('/main').subscribe((res: any) => {
         this.response = res.response;
       })
    }

}
