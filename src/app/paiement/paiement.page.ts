import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { 
  IonContent, 
  IonHeader,
  IonFooter,
  IonTitle,
  IonToolbar,
  IonCard,
  IonCardContent,
  IonIcon,
  IonInput,
  IonButton,
  IonSegment,
  IonSegmentButton,
  IonSelect,
  IonSelectOption,
  IonLabel,
  IonItem,
  IonList
} from '@ionic/angular/standalone';
import { RouterModule } from '@angular/router';
import { CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { addIcons } from 'ionicons';
import { 
  cardOutline,
  phonePortraitOutline,
  checkmarkCircleOutline,
  homeOutline,
  fitnessOutline,
  notificationsOutline,
  walletOutline,
  personOutline
} from 'ionicons/icons';

addIcons({
  'card-outline': cardOutline,
  'phone-portrait-outline': phonePortraitOutline,
  'checkmark-circle-outline': checkmarkCircleOutline,
  'home-outline': homeOutline,
  'fitness-outline': fitnessOutline,
  'notifications-outline': notificationsOutline,
  'wallet-outline': walletOutline,
  'person-outline': personOutline
});


@Component({
  selector: 'app-paiement',
  templateUrl: './paiement.page.html',
  styleUrls: ['./paiement.page.scss'],
  standalone: true,
  imports: [
    CommonModule,
    FormsModule,
    RouterModule,
    IonContent,
    IonHeader,
    IonFooter,
    IonTitle,
    IonToolbar,
    IonSelect,
  IonSelectOption,
    IonCard,
    IonCardContent,
    IonIcon,
    IonInput,
    IonButton,
    IonSegment,
    IonSegmentButton,
    IonLabel,
    IonItem,
    IonList
  ],
  schemas: [CUSTOM_ELEMENTS_SCHEMA]
})
export class PaiementPage implements OnInit {
  methodePaiement: string = 'carte';  // méthode de paiement (initialisée à carte)
  numeroCarte: string = '';          // numéro de carte bancaire
  expirationCarte: string = '';      // date d'expiration de la carte
  cvvCarte: string = '';             // code CVV de la carte
  numeroMobile: string = '';         // numéro mobile pour Orange Money ou MTN MoMo
   
  typeAbonnement: string = 'standard'; // valeur par défaut
  nombreMois: number = 1; // valeur par défaut
  montantBase: { [key: string]: number } = {
    'standard': 10000,
    'premium': 15000,
    'pro': 20000
  };

  montant: number = this.montantBase['standard']; // initialisé avec le montant standard


  constructor() { }
  

  ngOnInit() {
  }
  //  pour changer la méthode de paiement
  changerMethodePaiement(event: any) {
    this.methodePaiement = event.detail.value;
  }
  calculerMontantTotal() {
    this.montant = this.montantBase[this.typeAbonnement] * this.nombreMois;
  }
  changerTypeAbonnement(event: any) {
    this.typeAbonnement = event.detail.value;
    this.calculerMontantTotal();
  }
  changerNombreMois(event: any) {
    this.nombreMois = event.detail.value;
    this.calculerMontantTotal();
  }

  traiterPaiement() {
    //mettre le backend traiter le paiement 
    console.log('Traitement du paiement...');
  }


}
