import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { IonContent, IonHeader, IonTitle, IonToolbar } from '@ionic/angular/standalone';
import { Router } from '@angular/router';
import { IonItem, IonButton, IonInput } from '@ionic/angular/standalone';
import { HttpClientModule, HttpClient } from '@angular/common/http';
interface LoginResponse {
  message: string;
  user?: any; // Remplacez `any` par le type spécifique de votre utilisateur si vous avez une interface pour ça
}
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
    IonInput,
    HttpClientModule
  ]
})

export class LoginPage implements OnInit {
  loginForm!: FormGroup;

  constructor(
    private router: Router,
    private formBuilder: FormBuilder,
    private http: HttpClient
  ) {
    // Prevent browser back navigation
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
      const { email, password } = this.loginForm.value;
      this.http.post<LoginResponse>('http://localhost:3000/login/membre', { email_membre: email, motDePasse: password })
      .subscribe(response => {
        console.log('Réponse du serveur:', response);
        // Gérer la redirection ou l'affichage d'un message de succès
        if (response.message === 'Connexion réussie') {
          // Rediriger l'utilisateur ou afficher un message de succès
          this.router.navigate(['/home']); // Exemple de redirection
        }
      }, error => {
        console.error('Erreur de connexion:', error);
        // Afficher un message d'erreur à l'utilisateur
        alert(error.error.message || 'Une erreur est survenue');
      });
  } }

  goToRegister() {
    this.router.navigate(['/register']);
  }
}