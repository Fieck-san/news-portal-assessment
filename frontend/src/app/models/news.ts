export interface Author {
  id: number;
  name: string;
  title: string | null;
  avatar_url: string | null;
}

export interface Category {
  id: number;
  name: string;
  slug: string;
  sort_order: number;
  news_count?: number;
}

export interface NewsArticle {
  id: number;
  title: string;
  slug: string;
  summary: string;
  body: string;
  image_url: string | null;
  is_featured: boolean;
  published_at: string | null;
  category: Category;
  author: Author | null;
}

export interface PaginationLinkSet {
  first: string | null;
  last: string | null;
  prev: string | null;
  next: string | null;
}

export interface PaginationMeta {
  current_page: number;
  from: number | null;
  last_page: number;
  path: string;
  per_page: number;
  to: number | null;
  total: number;
}

export interface ApiCollection<T> {
  data: T[];
}

export interface PaginatedResponse<T> extends ApiCollection<T> {
  links: PaginationLinkSet;
  meta: PaginationMeta;
}

