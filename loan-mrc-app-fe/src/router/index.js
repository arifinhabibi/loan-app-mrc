import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import NotFound404View from '../views/NotFound404View.vue'
import HistoryView from '../views/HistoryView.vue'
import ReturnView from '../views/ReturnView.vue'
import LoanView from '../views/LoanView.vue'

const routes = [
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFoud404View',
    component: NotFound404View
  },
  {
    path: '/beranda',
    name: 'home',
    component: HomeView
  },
  {
    path: '/',
    name: 'login',
    component: LoginView
  },
  {
    path: '/riwayat-peminjaman',
    name: 'historyView',
    component: HistoryView
  },
  {
    path: '/pengembalian',
    name: 'ReturnView',
    component: ReturnView
  },
  {
    path: '/peminjaman',
    name: 'LoanView',
    component: LoanView
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
