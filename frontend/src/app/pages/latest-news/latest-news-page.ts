import { AsyncPipe } from '@angular/common';
import { Component, inject } from '@angular/core';
import { toObservable } from '@angular/core/rxjs-interop';
import { ActivatedRoute } from '@angular/router';
import { BehaviorSubject, Observable, catchError, combineLatest, distinctUntilChanged, map, of, startWith, switchMap } from 'rxjs';

import { NewsArticle, PaginatedResponse } from '../../models/news';
import { LocaleService } from '../../services/locale';
import { NewsApiService } from '../../services/news-api';

type NewsState =
  | { status: 'loading'; categorySlug: string | null }
  | { status: 'ready'; categorySlug: string | null; response: PaginatedResponse<NewsArticle> }
  | { status: 'error'; categorySlug: string | null; message: string };

@Component({
  selector: 'app-latest-news-page',
  imports: [AsyncPipe],
  templateUrl: './latest-news-page.html',
  styleUrl: './latest-news-page.css',
})
export class LatestNewsPageComponent {
  readonly locale = inject(LocaleService);

  private readonly api = inject(NewsApiService);
  private readonly route = inject(ActivatedRoute);
  private readonly page = new BehaviorSubject<number>(1);
  private readonly language$ = toObservable(this.locale.language);

  readonly categorySlug$ = this.route.paramMap.pipe(
    map((params) => params.get('slug')),
    distinctUntilChanged(),
  );

  readonly newsState$: Observable<NewsState> = combineLatest([this.categorySlug$, this.page, this.language$]).pipe(
    switchMap(([categorySlug, page, language]) => {
      const request$ = categorySlug
        ? this.api.getCategoryNews(categorySlug, { page, perPage: 8, lang: language })
        : this.api.getNews({ page, perPage: 8, lang: language });

      return request$.pipe(
        map((response) => ({ status: 'ready', categorySlug, response }) as NewsState),
        startWith({ status: 'loading', categorySlug } as NewsState),
        catchError((error: Error) => of({
          status: 'error',
          categorySlug,
          message: error.message,
        } as NewsState)),
      );
    }),
  );

  nextPage(meta: { current_page: number; last_page: number }): void {
    if (meta.current_page < meta.last_page) {
      this.page.next(meta.current_page + 1);
    }
  }

  previousPage(meta: { current_page: number }): void {
    if (meta.current_page > 1) {
      this.page.next(meta.current_page - 1);
    }
  }

  trackArticle(_index: number, article: NewsArticle): number {
    return article.id;
  }

  sectionTitle(categorySlug: string | null): string {
    return this.locale.categoryLabel(categorySlug);
  }

  lastUpdatedDate(articles: NewsArticle[]): Date | null {
    return latestArticleDate(articles);
  }

  formattedDate(value: string | Date | null): string {
    return this.locale.formatDate(value);
  }
}

export function latestArticleDate(articles: NewsArticle[]): Date | null {
  const timestamps = articles
    .map((article) => article.published_at ? Date.parse(article.published_at) : Number.NaN)
    .filter((timestamp) => Number.isFinite(timestamp));

  if (timestamps.length === 0) {
    return null;
  }

  return new Date(Math.max(...timestamps));
}
