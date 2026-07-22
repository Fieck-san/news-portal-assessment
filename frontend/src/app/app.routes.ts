import { Routes } from '@angular/router';

import { LatestNewsPageComponent } from './pages/latest-news/latest-news-page';

export const routes: Routes = [
  { path: '', component: LatestNewsPageComponent, title: 'Latest News' },
  { path: 'category/:slug', component: LatestNewsPageComponent, title: 'Category News' },
  { path: '**', redirectTo: '' },
];
