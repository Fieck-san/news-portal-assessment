import { latestArticleDate } from './latest-news-page';
import { NewsArticle } from '../../models/news';

describe('latest news page view helpers', () => {
  it('finds the newest article date for the last updated line', () => {
    const articles = [
      article({ id: 1, published_at: '2026-07-21T10:00:00+08:00' }),
      article({ id: 2, published_at: '2026-07-21T21:03:09+08:00' }),
      article({ id: 3, published_at: null }),
    ];

    expect(latestArticleDate(articles)?.toISOString()).toBe('2026-07-21T13:03:09.000Z');
    expect(latestArticleDate([])).toBeNull();
  });
});

function article(overrides: Partial<NewsArticle>): NewsArticle {
  return {
    id: 0,
    title: '',
    slug: '',
    summary: '',
    body: '',
    image_url: null,
    is_featured: false,
    published_at: null,
    category: {
      id: 1,
      name: 'Terkini',
      slug: 'terkini',
      sort_order: 1,
    },
    author: null,
    ...overrides,
  };
}
