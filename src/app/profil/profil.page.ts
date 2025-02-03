import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { IonContent, IonLabel, IonIcon, IonItem , IonHeader,IonFooter, IonTitle, IonToolbar } from '@ionic/angular/standalone';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AlertController, ModalController } from '@ionic/angular';
import { addIcons } from 'ionicons';
import { Router } from '@angular/router';
import { RouterModule } from '@angular/router';
import { ReactiveFormsModule } from '@angular/forms';
import { CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { 
  createOutline, 
  cameraOutline, 
  lockClosedOutline 
} from 'ionicons/icons';

import { 
  IonButtons, 
  IonButton, 
  IonAvatar, 
  IonList, 
  IonInput 
} from '@ionic/angular/standalone';
addIcons({
  'create-outline': createOutline,
  'camera-outline': cameraOutline,
  'lock-closed-outline': lockClosedOutline ,
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
  selector: 'app-profil',
  templateUrl: './profil.page.html',
  styleUrls: ['./profil.page.scss'],
  standalone: true,
  imports: [IonContent,IonButtons, RouterModule,  IonButton,IonAvatar,IonList,IonInput,ReactiveFormsModule,IonItem ,IonIcon,IonLabel,IonFooter,IonHeader, IonTitle, IonToolbar, CommonModule, FormsModule,],
  schemas: [CUSTOM_ELEMENTS_SCHEMA]
})

export class ProfilPage implements OnInit {
  profilForm: FormGroup;
  modeEdition = false;
  utilisateur = {
    prenom: '',
    nom: '',
    email: '',
    telephone: ''
  };

  constructor(private fb: FormBuilder) { 


    this.profilForm = this.fb.group({
      prenom: ['', Validators.required],
      nom: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      telephone: ['']
    });
  }

  ngOnInit() {
    
  }
  modifierProfil() {
    this.modeEdition = true;
  }
  changerPhoto() {
    // Implémentation de la logique pour changer la photo
  }
  sauvegarderModifications() {
    if (this.profilForm.valid) {
      // Sauvegarder les nouvelles informations
      this.modeEdition = false;
    }
  }

  // Annuler les modifications
  annulerModifications() {
    this.profilForm.patchValue(this.utilisateur);
    this.modeEdition = false;
  }
 // Changer le mot de passe
 changerMotDePasse() {
  // Afficher un modal pour changer le mot de passe
}
}
