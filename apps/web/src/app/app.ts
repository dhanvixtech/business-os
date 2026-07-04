import { Component, inject, signal } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { ApiService } from './core/services/api.service';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet],
  templateUrl: './app.html',
  styleUrl: './app.css'
})
export class App {
  protected readonly title = signal('web');

  private api = inject(ApiService);

  health: any;

  ngOnInit() {

    this.api.getHealth().subscribe({

      next: (response) => {

        console.log(response);

        this.health = response;

      },

      error: (error) => {

        console.error(error);

      }

    });
  }
}
