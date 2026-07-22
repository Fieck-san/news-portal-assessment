import { provideHttpClient } from '@angular/common/http';
import { HttpTestingController, provideHttpClientTesting } from '@angular/common/http/testing';
import { TestBed } from '@angular/core/testing';

import { NewsApiService } from './news-api';

describe('NewsApiService', () => {
  let service: NewsApiService;
  let http: HttpTestingController;

  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [
        NewsApiService,
        provideHttpClient(),
        provideHttpClientTesting(),
      ],
    });

    service = TestBed.inject(NewsApiService);
    http = TestBed.inject(HttpTestingController);
  });

  afterEach(() => {
    http.verify();
  });

  it('requests paginated news with Laravel query parameters', () => {
    service.getNews({ page: 2, perPage: 4, lang: 'en' }).subscribe((response) => {
      expect(response.meta.current_page).toBe(2);
      expect(response.data.length).toBe(0);
    });

    const request = http.expectOne('/api/news?page=2&per_page=4&lang=en');
    expect(request.request.method).toBe('GET');
    request.flush({
      data: [],
      links: { first: null, last: null, prev: null, next: null },
      meta: {
        current_page: 2,
        from: null,
        last_page: 2,
        path: '/api/news',
        per_page: 4,
        to: null,
        total: 0,
      },
    });
  });

  it('unwraps category collections from the API resource envelope', () => {
    service.getCategories('ms').subscribe((categories) => {
      expect(categories).toEqual([
        { id: 1, name: 'Terkini', slug: 'terkini', sort_order: 1, news_count: 12 },
      ]);
    });

    const request = http.expectOne('/api/categories?lang=ms');
    expect(request.request.method).toBe('GET');
    request.flush({
      data: [
        { id: 1, name: 'Terkini', slug: 'terkini', sort_order: 1, news_count: 12 },
      ],
    });
  });
});
