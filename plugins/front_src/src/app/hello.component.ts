import { Component } from '@angular/core';

@Component({
  selector: 'hello-plugin',
  template: `<div style="padding:10px; border: 1px solid #333;">
               <h3>Hello Plugin Component</h3>
               <p>This is loaded dynamically via Module Federation!</p>
             </div>`,
  standalone: false
})
export class HelloComponent {}
