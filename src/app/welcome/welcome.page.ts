import { OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { IonContent, IonHeader, IonTitle, IonToolbar,IonIcon } from '@ionic/angular/standalone';
import { GestureController } from '@ionic/angular';
import { register } from 'swiper/element/bundle';
import { Component, ViewChild, ElementRef } from '@angular/core';
import { Router } from '@angular/router';
import { addIcons } from 'ionicons';
import { 
  flameOutline,trophyOutline
} from 'ionicons/icons';
register();

addIcons({
  
  'flame-outline':flameOutline,
  'trophy-outline':trophyOutline
});


@Component({
  selector: 'app-welcome',
  templateUrl: './welcome.page.html',
  styleUrls: ['./welcome.page.scss'],
  standalone: true,
  imports: [IonContent, IonHeader, IonTitle, IonToolbar, CommonModule, FormsModule,IonIcon]
})
export class WelcomePage {
  @ViewChild(IonContent) contenu!: IonContent;

  constructor(
    private router: Router,
    private controleurGeste: GestureController
  ) {}

  async ngAfterViewInit() {
    
    const elementContenu = await this.contenu.getScrollElement();
    
    const gesture = this.controleurGeste.create({
      el: elementContenu,
      gestureName: 'swipe-up',
      direction: 'y',
      onMove: (detail) => {
        if (detail.deltaY < -100) {
          this.router.navigate(['/login']);
        }
      }
    });
    gesture.enable();
  }
}