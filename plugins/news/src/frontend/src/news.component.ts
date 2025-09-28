import {Component, Inject, OnInit} from '@angular/core';
import {News} from "./news.model";

@Component({
  selector: 'news-plugin',
  template: ` @for (newsItem of news; track newsItem.id) {
      <div class="news" data-id="{{ newsItem.id }}">
               <h3>{{ newsItem.name }}</h3>
               <p>{{ newsItem.content }}</p>
             </div>
  }`,
  standalone: true
})
export class NewsComponent implements OnInit {
    protected news: News[] = [];

  constructor(@Inject('ApiService') public apiService: any) {
  }

    ngOnInit(): void {
        this.apiService.get('/plugins/nova-basic-news/list').subscribe((res: any) => {
            this.news = res;
        })
        // const news: News[] = [
        //     new News(1, 'Test', 'This is test news')
        // ];
        // this.news = news;
    }
}
