import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class SubscriptionService {
  private apiUrl = 'http://localhost:3000'; // Remplacez par l'URL de votre API

  constructor(private http: HttpClient) {}

  getSubscriptionTypes(): Observable<any> {
    return this.http.get(`${this.apiUrl}/subscription-types`);
  }

  createMembership(user_id: number, type_id: number, start_date: string): Observable<any> {
    return this.http.post(`${this.apiUrl}/create-membership`, { user_id, type_id, start_date });
  }

  processPayment(membership_id: number, amount: number, payment_method: string): Observable<any> {
    return this.http.post(`${this.apiUrl}/process-payment`, { membership_id, amount, payment_method });
  }
}