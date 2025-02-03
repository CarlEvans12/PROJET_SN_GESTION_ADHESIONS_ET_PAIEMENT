import { Component,OnInit } from '@angular/core';
import { 
  IonHeader, 
  IonToolbar, 
  IonTitle, 
  IonContent, 
  IonGrid, 
  IonItem, 
  IonIcon, 
  IonInput,
  IonCard,
  IonCardContent,
  IonCardHeader,
  IonCardTitle,
  IonButton,
  IonLabel,
  IonRow,
  IonCol,
  IonFooter
} from '@ionic/angular/standalone';
import { register } from 'swiper/element/bundle';
import { CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { addIcons } from 'ionicons';
import { 
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
import { CommonModule } from '@angular/common';
import { IonicModule } from '@ionic/angular';
import { RouterModule } from '@angular/router';
register();

addIcons({
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


@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
  imports: [
    CommonModule,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonContent,
    IonGrid,
    IonItem,
    IonIcon,
    IonInput,
    IonCard,
    
    IonCardContent,
    IonCardHeader,
    IonCardTitle,
    IonButton,
    IonLabel,
    IonRow,
    IonCol,
    IonFooter
  ],
  schemas: [CUSTOM_ELEMENTS_SCHEMA]
})

export class HomePage implements OnInit {
  
  swiperConfig = {
    slidesPerView: 2,
    spaceBetween: 10,
    pagination: {
      enabled: true
    },
    autoplay: {
      delay: 3000,
      disableOnInteraction: false  // Permet de continuer l'autoplay même après interaction
    },
    loop: true  // Important pour un défilement continu
  };
  swiperConfig2 = {
    slidesPerView: 2,
    spaceBetween: 10,
    pagination: {
      enabled: true
    },
    autoplay: {
      delay: 3000,
      disableOnInteraction: false  
    },
    loop: true  
  };

  // Tableau d'images à faire défiler

  popularExercises = [
    {
      url: 'assets/image/img4.jpg',
      title: 'Exercices Squats',
      description: 'SQUATS',
      timing: 'MATIN/SOIR'
    },
    {
      url: 'assets/image/img5.jpg',
      title: 'Exercices Pompes',
      description: 'POMPES',
      timing: 'MATIN/SOIR'
    },
    {
      url: 'assets/image/img6.jpg',
      title: 'Exercices Abdos',
      description: 'ABDOS',
      timing: 'MATIN/SOIR'
    },
    {
      url: 'assets/image/splash.jpg',
      title: 'Exercices CORDE',
      description: 'CORDE A SAUTER',
      timing: 'MATIN/SOIR'
    },
    {
      url: 'assets/image/img3.jpg',
      title: 'Exercices Jambes',
      description: 'CARDIO',
      timing: 'MATIN/SOIR'
    },
  ];


  images = [
    {
      url: 'assets/image/img1.jpg',
      title: 'Repousse tes limites'
    },
    {
      url: 'assets/image/img2.jpg',
      title: 'La douleur est temporaire, la fierté est éternelle'
    },
    {
      url: 'assets/image/img3.jpg',
      title: 'Tu es plus fort que tu ne le penses'
    }
  ];

  constructor() {}

  ngOnInit() {}
}