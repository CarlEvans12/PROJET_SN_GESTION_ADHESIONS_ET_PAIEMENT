import { Component, ViewChild } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { Router } from '@angular/router';
import { 
  IonContent, 
  IonHeader, 
  IonTitle, 
  IonToolbar, 
  IonIcon,
  GestureController 
} from '@ionic/angular/standalone';
import { register } from 'swiper/element/bundle';
import { addIcons } from 'ionicons';
import { flameOutline, trophyOutline } from 'ionicons/icons';

register();
addIcons({
  'flame-outline': flameOutline,
  'trophy-outline': trophyOutline
});

@Component({
  selector: 'app-welcome',
  templateUrl: './welcome.page.html',
  styleUrls: ['./welcome.page.scss'],
  standalone: true,
  imports: [
    CommonModule, 
    RouterModule,
    IonContent, 
    IonHeader, 
    IonTitle, 
    IonToolbar, 
    IonIcon
  ]
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