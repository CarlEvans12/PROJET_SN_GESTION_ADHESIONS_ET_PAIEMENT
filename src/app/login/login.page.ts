import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AuthService } from './auth.service';

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