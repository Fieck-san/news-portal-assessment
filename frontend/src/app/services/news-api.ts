import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable, inject } from '@angular/core';
import { Observable, catchError, map, throwError } from 'rxjs';

import { environment } from '../../environments/environment';
import { ApiCollection, Category, NewsArticle, PaginatedResponse } from '../models/news';
import { Language } from './locale';

export interface NewsQuery {
  page?: number;
  perPage?: number;
  category?: string | null;
  lang?: Language;
}

@Injectable({ providedIn: 'root' })
export class NewsApiService {
  private readonly http = inject(HttpClient);
  private readonly apiUrl = environment.apiUrl;

  getCategories(lang?: Language): Observable<Category[]> {
    return this.http.get<ApiCollection<Category>>(`${this.apiUrl}/categories`, {
      params: this.toParams({ lang }),
    }).pipe(
      map((response) => response.data),
      catchError(() => throwError(() => new Error('Categories could not be loaded.'))),
    );
  }

  getNews(query: NewsQuery = {}): Observable<PaginatedResponse<NewsArticle>> {
    return this.http.get<PaginatedResponse<NewsArticle>>(`${this.apiUrl}/news`, {
      params: this.toParams(query),
    }).pipe(
      catchError(() => throwError(() => new Error('News could not be loaded.'))),
    );
  }

  getCategoryNews(slug: string, query: Omit<NewsQuery, 'category'> = {}): Observable<PaginatedResponse<NewsArticle>> {
    return this.http.get<PaginatedResponse<NewsArticle>>(`${this.apiUrl}/categories/${slug}/news`, {
      params: this.toParams(query),
    }).pipe(
      catchError(() => throwError(() => new Error('Category news could not be loaded.'))),
    );
  }

  private toParams(query: NewsQuery): HttpParams {
    let params = new HttpParams();

    if (query.page) {
      params = params.set('page', query.page);
    }

    if (query.perPage) {
      params = params.set('per_page', query.perPage);
    }

    if (query.category) {
      params = params.set('category', query.category);
    }

    if (query.lang) {
      params = params.set('lang', query.lang);
    }

    return params;
  }
}
