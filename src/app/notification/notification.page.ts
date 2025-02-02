import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { IonContent,IonFooter, IonHeader, IonTitle, IonToolbar, IonItem, IonList, IonIcon, IonLabel, IonButton, IonBadge } from '@ionic/angular/standalone';
import { Router } from '@angular/router';
import { addIcons } from 'ionicons';
import { register } from 'swiper/element/bundle';
import { RouterModule } from '@angular/router';
register();
addIcons({
  'close-outline': closeOutline,
  'search-outline': searchOutline,
  'notifications-outline': notificationsOutline,
  'cart-outline': cartOutline,
  'home-outline': homeOutline,
  'person-outline': personOutline,
  'wallet-outline': walletOutline,
  'fitness-outline': fitnessOutline,
  'arrow-back-outline': arrowBackOutline,
  
  'arrow-forward-outline': arrowForwardOutline
});
import { 
  
  
  closeOutline,
  searchOutline, 
  notificationsOutline, 
  cartOutline,
  homeOutline,
  personOutline,
  walletOutline,
  arrowBackOutline,
  fitnessOutline,
  arrowForwardOutline 
} from 'ionicons/icons';
@Component({
  selector: 'app-notifications',
  templateUrl: './notification.page.html',
  styleUrls: ['./notification.page.scss'],
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    IonContent,
    IonHeader,
    IonTitle,
    IonToolbar,
    IonItem,
    IonList,
    IonIcon,
    IonLabel,
    IonButton,
    IonBadge,
    IonFooter
  ]
})
export class NotificationPage implements OnInit {
  notifications = [
    {
      type: 'warning',
      title: 'Abonnement',
      message: 'Votre abonnement expire dans 3 jours',
      time: 'Il y a 2 heures',
      
      nonlue: false
    },
    {
      type: 'motivation',
      title: 'Motivation',
      message: '5 jours sans entrainement ! Pensez à votre santé ',
      time: 'Il y a 1 jour',
    
      nonlue: true
    },
    {
      type: 'achievement',
      title: 'Objectif atteint !',
      message: 'Félicitations ! Vous avez atteint votre objectif de 10 séances ce mois-ci',
      time: 'Il y a 2 jours',
      
      nonlue: true
    },
    {
      type: 'info',
      title: 'Nouveau cours disponible',
      message: 'Un nouveau cours de BOXE a été ajouté à votre programme',
      time: 'Il y a 3 jours',
      
      nonlue: false
    }
  ];

  constructor(private router: Router) {}

  ngOnInit() {}

  obtenirNombreNonLus(): number {
    return this.notifications.filter(n => n.nonlue).length;
  }
  marquerCommeLu(notification: any) {
    notification.nonlue = false;
  }

  supprimerNotification(index: number, event: Event) {
    event.stopPropagation();
    this.notifications.splice(index, 1);
  }
  
  
}