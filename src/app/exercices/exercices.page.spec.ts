import { ComponentFixture, TestBed } from '@angular/core/testing';
import { ExercicesPage } from './exercices.page';

describe('ExercicesPage', () => {
  let component: ExercicesPage;
  let fixture: ComponentFixture<ExercicesPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(ExercicesPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
