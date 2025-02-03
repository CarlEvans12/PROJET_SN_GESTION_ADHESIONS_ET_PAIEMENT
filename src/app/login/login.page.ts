import { Component } from '@angular/core';
import { IonicModule } from '@ionic/angular';
import { FormGroup } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { FormBuilder, Validators } from '@angular/forms';
import { AuthService } from '../services/auth.service';

interface LoginResponse {
    success: boolean;
    user?: any; 
    message?: string;
}

@Component({
    selector: 'app-login',
    templateUrl: './login.page.html',
    styleUrls: ['./login.page.scss'],
})
@Component({
  imports: [
    ReactiveFormsModule // Nécessaire pour les formulaires
  ]
})

@Component({
  standalone: true,
  imports: [
    IonicModule,
    ReactiveFormsModule,
    CommonModule
  ],
  templateUrl: './login.page.html'
})
export class LoginPage {
    loginForm: FormGroup;

    constructor(private formBuilder: FormBuilder, private authService: AuthService) {
        this.loginForm = this.formBuilder.group({
            email: ['', [Validators.required, Validators.email]],
            password: ['', [Validators.required]],
        });
    }

    onLogin() {
        if (this.loginForm.valid) {
            this.authService.login(this.loginForm.value.email, this.loginForm.value.password)
                .subscribe((response: LoginResponse) => {
                    if (response.success) {
                        // Gérer la connexion réussie
                        console.log('Login successful', response.user);
                    } else {
                        // Gérer l'échec de la connexion
                        console.error(response.message);
                    }
                });
        }
    }

    goToRegister() {
        // Redirection vers la page d'inscription
    }
}