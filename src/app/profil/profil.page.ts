import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { IonicModule } from '@ionic/angular';
import { RouterModule } from '@angular/router';

// Importation des icônes
import { addIcons } from 'ionicons';
import { createOutline, cameraOutline, lockClosedOutline, homeOutline, fitnessOutline, notificationsOutline, walletOutline, personOutline } from 'ionicons/icons';

@Component({
  selector: 'app-profil',
  templateUrl: './profil.page.html',
  styleUrls: ['./profil.page.scss'],
  standalone: true,
  imports: [
    IonicModule, 
    CommonModule, 
    FormsModule, 
    ReactiveFormsModule,
    RouterModule
  ]
})
export class ProfilPage implements OnInit {
  profilForm!: FormGroup;
  modeEdition: boolean = false;
  utilisateur: any = {
    prenom: 'rachelle',
    nom: 'Maguejeu',
    email: 'rachelle.doe@example.com',
    telephone: '+237 6 690 65 57 56'
  };

  constructor(private formBuilder: FormBuilder) {
    
    addIcons({ 
      createOutline, 
      cameraOutline, 
      lockClosedOutline,
      homeOutline,
      fitnessOutline,
      notificationsOutline,
      walletOutline,
      personOutline
    });
  }

  ngOnInit() {
    this.initForm();
  }

  initForm() {
    this.profilForm = this.formBuilder.group({
      prenom: [{value: this.utilisateur.prenom, disabled: !this.modeEdition}],
      nom: [{value: this.utilisateur.nom, disabled: !this.modeEdition}],
      email: [{value: this.utilisateur.email, disabled: !this.modeEdition}],
      telephone: [{value: this.utilisateur.telephone, disabled: !this.modeEdition}]
    });
  }

  modifierProfil() {
    this.modeEdition = true;
    this.initForm();
  }

  annulerModifications() {
    this.modeEdition = false;
    this.initForm();
  }

  sauvegarderModifications() {
    if (this.profilForm.valid) {
      this.utilisateur = {
        ...this.utilisateur,
        ...this.profilForm.value
      };
      this.modeEdition = false;
    }
  }

  changerPhoto() {
    console.log('Changement de photo');
  }

  changerMotDePasse() {
    console.log('Changer mot de passe');
  }
}