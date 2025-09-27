import {Component, Inject, OnInit} from '@angular/core';

@Component({
  selector: 'news-plugin',
  template: ` @for (newsItem of news; track newsItem.id) {
      <div class="news" data-id="{{ newsItem.id }}">
               <h3>{{ newsItem.name }}</h3>
               <p>{{ newsItem.content }}</p>
             </div>
  }`,
  standalone: false
})
export class NewsComponent implements OnInit {
    protected news: News[] = [];
  // constructor(@Inject('TestService') public testService: any) {
  //   // hostService is now available here
  //   this.testService.log('Hello from plugin!');
  // }

    ngOnInit(): void {
        const news: News[] = [
            new News(1, 'Test', 'This is test news')
        ];
        this.news = news;
    }
}
