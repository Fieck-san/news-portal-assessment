import { TestBed } from '@angular/core/testing';

import { LocaleService } from './locale';

describe('LocaleService', () => {
  let service: LocaleService;

  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [LocaleService],
    });

    service = TestBed.inject(LocaleService);
  });

  it('uses English labels by default', () => {
    expect(service.language()).toBe('en');
    expect(service.labels().sectionLabel).toBe('News');
    expect(service.labels().lastUpdated).toBe('Last updated');
    expect(service.categoryLabel(null)).toBe('Latest');
    expect(service.categoryLabel('politik')).toBe('Politics');
  });

  it('switches labels to Malay', () => {
    service.setLanguage('ms');

    expect(service.language()).toBe('ms');
    expect(service.labels().sectionLabel).toBe('Berita');
    expect(service.labels().lastUpdated).toBe('Dikemas kini');
    expect(service.categoryLabel(null)).toBe('Terkini');
    expect(service.categoryLabel('politik')).toBe('Politik');
  });
});
