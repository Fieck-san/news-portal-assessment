import { Injectable, computed, signal } from '@angular/core';

export type Language = 'en' | 'ms';

type LabelKey =
  | 'sectionLabel'
  | 'lastUpdated'
  | 'lastUpdatedPending'
  | 'loading'
  | 'errorTitle'
  | 'emptyTitle'
  | 'emptyMessage'
  | 'previous'
  | 'next'
  | 'fallbackAuthor'
  | 'languageLabel';

type LabelSet = Record<LabelKey, string>;

const LABELS: Record<Language, LabelSet> = {
  en: {
    sectionLabel: 'News',
    lastUpdated: 'Last updated',
    lastUpdatedPending: 'Last updated after stories load',
    loading: 'Loading news...',
    errorTitle: 'Unable to load news',
    emptyTitle: 'No articles found',
    emptyMessage: 'Try another category or seed the Laravel database again.',
    previous: 'Previous',
    next: 'Next',
    fallbackAuthor: 'News desk',
    languageLabel: 'Language',
  },
  ms: {
    sectionLabel: 'Berita',
    lastUpdated: 'Dikemas kini',
    lastUpdatedPending: 'Dikemas kini selepas berita dimuatkan',
    loading: 'Memuatkan berita...',
    errorTitle: 'Berita gagal dimuatkan',
    emptyTitle: 'Tiada artikel dijumpai',
    emptyMessage: 'Cuba kategori lain atau jalankan semula seeder pangkalan data Laravel.',
    previous: 'Sebelumnya',
    next: 'Seterusnya',
    fallbackAuthor: 'Meja berita',
    languageLabel: 'Bahasa',
  },
};

const CATEGORY_LABELS: Record<Language, Record<string, string>> = {
  en: {
    terkini: 'Latest',
    global: 'Global',
    politik: 'Politics',
    bisnes: 'Business',
    sukan: 'Sports',
    pendapat: 'Opinion',
  },
  ms: {
    terkini: 'Terkini',
    global: 'Global',
    politik: 'Politik',
    bisnes: 'Bisnes',
    sukan: 'Sukan',
    pendapat: 'Pendapat',
  },
};

const DATE_LOCALE: Record<Language, string> = {
  en: 'en-US',
  ms: 'ms-MY',
};

@Injectable({ providedIn: 'root' })
export class LocaleService {
  readonly language = signal<Language>('en');
  readonly labels = computed(() => LABELS[this.language()]);

  setLanguage(language: Language): void {
    this.language.set(language);
  }

  categoryLabel(slug: string | null, fallbackName?: string): string {
    if (!slug) {
      return CATEGORY_LABELS[this.language()]['terkini'];
    }

    return CATEGORY_LABELS[this.language()][slug] ?? fallbackName ?? titleFromSlug(slug);
  }

  formatDate(value: string | Date | null): string {
    if (!value) {
      return '';
    }

    const date = value instanceof Date ? value : new Date(value);

    return new Intl.DateTimeFormat(DATE_LOCALE[this.language()], {
      dateStyle: 'medium',
      timeStyle: 'medium',
    }).format(date);
  }
}

function titleFromSlug(slug: string): string {
  return slug
    .split('-')
    .filter(Boolean)
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join(' ');
}
