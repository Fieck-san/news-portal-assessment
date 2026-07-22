import { AsyncPipe, NgClass } from '@angular/common';
import { Component, inject } from '@angular/core';
import { toObservable } from '@angular/core/rxjs-interop';
import { RouterLink, RouterLinkActive } from '@angular/router';
import { Observable, catchError, map, of, switchMap } from 'rxjs';

import { Category } from '../../models/news';
import { LocaleService } from '../../services/locale';
import { NewsApiService } from '../../services/news-api';

@Component({
  selector: 'app-top-nav',
  imports: [AsyncPipe, NgClass, RouterLink, RouterLinkActive],
  templateUrl: './top-nav.html',
  styleUrl: './top-nav.css',
})
export class TopNavComponent {
  readonly locale = inject(LocaleService);

  private readonly api = inject(NewsApiService);
  private readonly language$ = toObservable(this.locale.language);

  readonly categories$: Observable<Category[]> = this.language$.pipe(
    switchMap((language) => this.api.getCategories(language)),
    map((categories) => categories.filter((category) => category.slug !== 'terkini')),
    catchError(() => of([])),
  );

  isMenuOpen = false;

  toggleMenu(): void {
    this.isMenuOpen = !this.isMenuOpen;
  }

  closeMenu(): void {
    this.isMenuOpen = false;
  }

  categoryIconClass(slug: string): string {
    const iconClassBySlug: Record<string, string> = {
      global: 'icon-global',
      politik: 'icon-politik',
      bisnes: 'icon-bisnes',
      sukan: 'icon-sukan',
      pendapat: 'icon-pendapat',
    };

    return iconClassBySlug[slug] ?? 'icon-category';
  }
}
