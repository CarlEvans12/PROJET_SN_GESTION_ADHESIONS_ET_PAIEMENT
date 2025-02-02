import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { 
  IonContent, 
  IonHeader,
  IonItem,
  IonFooter, 
  IonTitle, 
  IonInput, 
  IonToolbar, 
  IonCard, 
  IonCardHeader, 
  IonCardTitle, 
  IonCardContent, 
  IonIcon 
} from '@ionic/angular/standalone';
import { IonicModule } from '@ionic/angular';
import { addIcons } from 'ionicons';
import { register } from 'swiper/element/bundle';
import { 
  timeOutline, 
  flameOutline, 
  chevronForwardOutline,
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
import { RouterModule } from '@angular/router';

register();
addIcons({
  'time': timeOutline,
  'flame-outline': flameOutline,
  'chevron-forward-outline': chevronForwardOutline,

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

interface Exercice {
  id: number;
  titre: string;
  niveau: string;
  duree: string;
  description: string;
  instructions: string;
  image: string;
  calories: number;
  equipement: string[];
}

@Component({
  selector: 'app-exercices',
  templateUrl: './exercices.page.html',
  styleUrls: ['./exercices.page.scss'],
  standalone: true,
  imports: [
    RouterModule,
    IonContent,
    IonHeader,
    IonTitle,
    IonToolbar,
    IonCard,
    IonCardHeader,
    IonCardTitle,
    IonCardContent,
    IonIcon,
    IonFooter,
    CommonModule,
    IonInput,
    FormsModule,
    IonItem
  ]
})
export class ExercicesPage implements OnInit {
  exercices: Exercice[] = [];
  exercicesFiltres: Exercice[] = [];
  termeRecherche: string = '';

  constructor() {
    
  }

  ngOnInit() {
    this.initialiserExercices();
    this.exercicesFiltres = this.exercices; 
  }

  private initialiserExercices() {
    this.exercices = [
      {
        id: 1,
        titre: "Pompes classiques",
        niveau: "Débutant",
        duree: "10 minutes",
        description: "Excellent exercice pour développer le haut du corps",
        instructions: "1. Position de planche. 2. Descendre en pliant les bras. 3. Remonter en poussant",
        image: 'assets/image/img4.jpg',
        calories: 100,
        equipement: ["Tapis de sport (optionnel)"]
      },
      {
        id: 2,
        titre: "Squats",
        niveau: "Tous niveaux",
        duree: "15 minutes",
        description: "Parfait pour renforcer les jambes",
        instructions: "1. Debout, pieds écartés. 2. Descendre comme pour s'asseoir. 3. Remonter",
        image: "/api/placeholder/400/300",
        calories: 150,
        equipement: ["Aucun"]
      },
      {
        id: 3,
        titre: "Planche",
        niveau: "Intermédiaire",
        duree: "5 minutes",
        description: "Renforce les abdominaux et le core",
        instructions: "1. Appui sur les avant-bras. 2. Corps droit et gainé. 3. Tenir la position",
        image: "/api/placeholder/400/300",
        calories: 80,
        equipement: ["Tapis de sport"]
      },
      {
        id: 4,
        titre: "Burpees",
        niveau: "Avancé",
        duree: "20 minutes",
        description: "Exercice complet très intense",
        instructions: "1. Debout. 2. Position pompe. 3. Saut vertical. 4. Recommencer",
        image: "/api/placeholder/400/300",
        calories: 200,
        equipement: ["Aucun"]
      }
    ];
  }

  
  gererRecherche(event: any) {
    const terme = event.target.value.toLowerCase().trim();
    
    if (!terme) {
      this.exercicesFiltres = this.exercices;
      return;
    }

    this.exercicesFiltres = this.exercices.filter(exercice => 
      exercice.titre.toLowerCase().includes(terme) ||
      exercice.niveau.toLowerCase().includes(terme) ||
      exercice.description.toLowerCase().includes(terme)
    );
  }
}