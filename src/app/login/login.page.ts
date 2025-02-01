import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { IonContent, IonHeader, IonTitle, IonToolbar } from '@ionic/angular/standalone';
import { Router } from '@angular/router';
import {  
   IonItem, IonButton, IonInput } from '@ionic/angular/standalone';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
  standalone: true,
  imports: [
    IonContent, 
    IonHeader, 
    IonTitle, 
    IonToolbar, 
    CommonModule, 
    ReactiveFormsModule,
    IonItem,
    IonToolbar,
    IonButton,
    IonInput
  ]
})
export class LoginPage implements OnInit {

  loginForm!: FormGroup; //permet de dire à TypeScript que je suis  sûr que la variable loginForm sera initialisée à un moment donné avant d'être utilisée pour eviter les erreur 


  constructor(private router: Router,
     private formBuilder: FormBuilder,) {

    // Empêcher le retour en arrière
    history.pushState(null, '', window.location.href);
    window.onpopstate = function () {
      history.pushState(null, '', window.location.href);
    };
  }

  ngOnInit() {
    this.loginForm = this.formBuilder.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(6)]]
    });
  }

  onLogin() {
    if (this.loginForm.valid) {
      // ici quand on va impleter l'api comme ca apres souscription des info ca va allé chercher dans la bd du  coté admin
      
    }
  }

  goToRegister() {
    this.router.navigate(['/register']);
  }
}
